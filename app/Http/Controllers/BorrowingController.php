<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingRejection;
use App\Models\Asset;
use App\Models\BorrowingMove;
use App\Models\User;
use App\Notifications\BorrowingMoveNotification;
use App\Rules\SecureFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the borrowings with pagination.
     *
     * This method retrieves borrowings with proper eager loading to prevent N+1 queries
     * and implements pagination to avoid loading all records at once.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'asset', 'admin', 'rejection'])
            ->orderBy('created_at', 'desc')
            ->paginate(20); // Paginate with 20 records per page

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Display the specified borrowing.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load([
            'user',
            'asset',
            'admin',
            'rejection',
            'moves',
            'moves.oldAsset',
            'moves.newAsset',
            'moves.admin'
        ]);

        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Approve a borrowing request and reject conflicting bookings.
     *
     * This method handles the approval of a borrowing request with the following business rules:
     * 1. Only pending borrowings can be approved
     * 2. When approving a borrowing, all conflicting borrowings in the same time period are automatically rejected
     * 3. Conflicting borrowings are those with overlapping date ranges for the same asset
     * 4. The asset status is not changed at this stage (remains available until borrowed)
     *
     * @param Request $request Contains admin_id who approves the request
     * @param Borrowing $borrowing The borrowing request to approve
     * @return \Illuminate\Http\RedirectResponse Redirects to borrowings index with success/error message
     * @throws \Exception If database transaction fails
     */
    public function approve(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Business Rule: Only pending borrowings can be approved
        if ($borrowing->status !== 'pending') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        DB::beginTransaction();

        try {
            // Find all conflicting borrowings that overlap with this request's time period
            $conflictingBorrowings = $this->getConflictingBorrowings(
                $borrowing->asset_id,
                $borrowing->id,
                $borrowing->tanggal_mulai,
                $borrowing->tanggal_selesai,
                ['pending', 'disetujui']
            );

            // Update the borrowing to approved status
            $borrowing->update([
                'status' => 'disetujui',
                'admin_id' => $request->admin_id,
            ]);

            // Business Rule: Automatically reject all conflicting borrowings to prevent double-booking
            $rejectedCount = $this->rejectConflictingBorrowings(
                $conflictingBorrowings,
                $request->admin_id,
                'Konflik jadwal peminjaman. Telah disetujui peminjaman lain untuk rentang waktu yang sama.'
            );

            DB::commit();

            $message = 'Peminjaman berhasil disetujui.';
            if ($rejectedCount > 0) {
                $message .= " {$rejectedCount} peminjaman lain yang memiliki konflik jadwal telah ditolak otomatis.";
            }

            return redirect()->route('borrowings.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Reject a borrowing request and record the reason.
     *
     * This method handles the rejection of a borrowing request with the following business rules:
     * 1. Only pending or approved borrowings can be rejected (not already rejected or completed)
     * 2. A reason for rejection must be provided
     * 3. The rejection is recorded in the borrowing_rejections table
     * 4. The asset status remains unchanged after rejection
     *
     * @param Request $request Contains admin_id and reason for rejection
     * @param Borrowing $borrowing The borrowing request to reject
     * @return \Illuminate\Http\RedirectResponse Redirects to borrowings index with success/error message
     * @throws \Exception If database transaction fails
     */
    public function reject(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'alasan' => 'required|string|max:500',
        ]);

        // Business Rule: Only pending or approved borrowings can be rejected
        if (in_array($borrowing->status, ['ditolak', 'selesai'])) {
            return redirect()->route('borrowings.index')
                ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        DB::beginTransaction();

        try {
            // Update borrowing status to rejected
            $borrowing->update([
                'status' => 'ditolak',
                'admin_id' => $request->admin_id,
            ]);

            // Create rejection record for audit trail
            BorrowingRejection::create([
                'borrowing_id' => $borrowing->id,
                'alasan' => $request->alasan,
            ]);

            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Mark a borrowing as borrowed (ongoing) and update asset status.
     *
     * This method transitions a borrowing from approved/pending to borrowed status with the following business rules:
     * 1. Only pending or approved borrowings can be marked as borrowed
     * 2. When marking as borrowed, the asset status changes to 'dipinjam' (borrowed)
     * 3. All conflicting borrowings in the same time period are automatically rejected
     * 4. This action represents the physical handover of the asset to the borrower
     *
     * @param Request $request Contains admin_id who marks the borrowing as borrowed
     * @param Borrowing $borrowing The borrowing request to mark as borrowed
     * @return \Illuminate\Http\RedirectResponse Redirects to borrowings index with success/error message
     * @throws \Exception If database transaction fails
     */
    public function markAsBorrowed(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Business Rule: Only pending or approved borrowings can be marked as borrowed
        if (!in_array($borrowing->status, ['pending', 'disetujui'])) {
            return redirect()->route('borrowings.index')
                ->with('error', 'Status peminjaman tidak valid untuk aksi ini.');
        }

        DB::beginTransaction();

        try {
            // Find all conflicting borrowings that overlap with this request's time period
            $conflictingBorrowings = $this->getConflictingBorrowings(
                $borrowing->asset_id,
                $borrowing->id,
                $borrowing->tanggal_mulai,
                $borrowing->tanggal_selesai,
                ['pending', 'disetujui']
            );

            // Business Rule: Change asset status to borrowed when the borrowing starts
            $borrowing->asset->update(['status' => 'dipinjam']);

            // Update borrowing status to borrowed
            $borrowing->update([
                'status' => 'dipinjam',
                'admin_id' => $request->admin_id,
            ]);

            // Business Rule: Automatically reject all conflicting borrowings to prevent double-booking
            $rejectedCount = $this->rejectConflictingBorrowings(
                $conflictingBorrowings,
                $request->admin_id,
                'Konflik jadwal peminjaman. Telah diaktifkan peminjaman lain untuk rentang waktu yang sama.'
            );

            DB::commit();

            $message = 'Status peminjaman diperbarui menjadi sedang dipinjam.';
            if ($rejectedCount > 0) {
                $message .= " {$rejectedCount} peminjaman lain yang memiliki konflik jadwal telah ditolak otomatis.";
            }

            return redirect()->route('borrowings.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Mark a borrowing as returned (completed) and update asset status.
     *
     * This method completes a borrowing cycle with the following business rules:
     * 1. Only borrowed items can be marked as returned
     * 2. When marking as returned, the asset status changes back to 'tersedia' (available)
     * 3. The borrowing status changes to 'selesai' (completed)
     * 4. This action represents the return of the asset to the inventory
     *
     * @param Request $request Contains admin_id who marks the borrowing as returned
     * @param Borrowing $borrowing The borrowing request to mark as returned
     * @return \Illuminate\Http\RedirectResponse Redirects to borrowings index with success/error message
     * @throws \Exception If database transaction fails
     */
    public function markAsReturned(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Business Rule: Only borrowed items can be marked as returned
        if ($borrowing->status !== 'dipinjam') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman dengan status "dipinjam" yang dapat diselesaikan.');
        }

        DB::beginTransaction();

        try {
            // Business Rule: Return asset to available status when borrowing is completed
            $borrowing->asset->update(['status' => 'tersedia']);

            // Update borrowing status to completed
            $borrowing->update([
                'status' => 'selesai',
                'admin_id' => $request->admin_id,
            ]);

            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil diselesaikan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for creating a new borrowing request.
     *
     * This method displays the borrowing request form with the following business rules:
     * 1. User must be authenticated to access the form
     * 2. Only available assets ('tersedia') can be borrowed
     * 3. If asset is not available, appropriate handling is performed
     *
     * @param Asset $asset The asset to borrow
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse Returns the borrowing form view or redirects with error message
     */
    public function create(Asset $asset)
    {
        // Business Rule: User must be authenticated to create a borrowing request
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melakukan peminjaman.');
        }

        // Business Rule: Only available assets can be borrowed
        if ($asset->status !== 'tersedia') {
            return $this->handleUnavailableAsset($asset);
        }

        return view('borrowings.create', compact('asset'));
    }

    /**
     * Store a newly created borrowing request.
     *
     * This method handles the creation of a new borrowing request with the following business rules:
     * 1. The asset must be available ('tersedia') to be borrowed
     * 2. The requested date range must not conflict with existing borrowings
     * 3. A proof document must be uploaded with the request
     * 4. The borrowing status starts as 'pending' awaiting admin approval
     * 5. File uploads are validated and sanitized for security
     *
     * @param Request $request Contains asset_id, tanggal_mulai, tanggal_selesai, keperluan, and lampiran_bukti
     * @return \Illuminate\Http\RedirectResponse Redirects to user dashboard with success/error message
     * @throws \Exception If database transaction fails
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keperluan' => 'required|string|max:500',
            'lampiran_bukti' => ['required', 'file', new SecureFileUpload()],
        ]);

        $asset = Asset::findOrFail($request->asset_id);

        // Business Rule: Only available assets can be borrowed
        if ($asset->status !== 'tersedia') {
            return $this->handleUnavailableAsset($asset);
        }

        // Business Rule: Check for date conflicts with existing borrowings
        $existingBorrowing = $this->checkBorrowingConflict(
            $request->asset_id,
            $request->tanggal_mulai,
            $request->tanggal_selesai
        );

        if ($existingBorrowing) {
            $endDate = Carbon::parse($existingBorrowing->tanggal_selesai)->format('d F Y');
            return redirect()->back()
                ->with('error', "Aset sudah dipinjam oleh user lain pada periode yang diminta. Aset akan tersedia kembali pada tanggal {$endDate}. Silakan pilih tanggal lain atau aset lain.");
        }

        DB::beginTransaction();

        try {
            // Handle file upload with sanitized filename for security
            $file = $request->file('lampiran_bukti');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Generate a unique, sanitized filename to prevent path traversal attacks
            $sanitizedFileName = uniqid('borrowing_doc_' . auth()->id() . '_') . '.' . $extension;
            $lampiranPath = $file->storeAs('borrowing_documents', $sanitizedFileName, 'public');

            // Create borrowing with initial pending status
            Borrowing::create([
                'user_id' => auth()->id(),
                'asset_id' => $request->asset_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keperluan' => $request->keperluan,
                'lampiran_bukti' => $lampiranPath,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('user.dashboard')
                ->with('success', 'Permintaan peminjaman berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Borrowing creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengajukan peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for creating a new borrowing directly (admin only).
     */
    public function createDirect()
    {
        $assets = Asset::all();
        return view('borrowings.create-direct', compact('assets'));
    }

    /**
     * Store a newly created borrowing directly (admin only).
     *
     * This method allows administrators to create borrowings directly with the following business rules:
     * 1. Only admins can create direct borrowings
     * 2. The asset must be available unless creating a 'dipinjam' status borrowing
     * 3. Date conflicts are still checked even for direct bookings
     * 4. The borrowing can be created with any valid status (pending, approved, borrowed, etc.)
     * 5. If status is 'dipinjam', asset status is immediately updated to 'dipinjam'
     * 6. If status is 'disetujui', asset status remains 'tersedia' until borrowed
     *
     * @param Request $request Contains asset_id, tanggal_mulai, tanggal_selesai, keperluan, status, and optional lampiran_bukti
     * @return \Illuminate\Http\RedirectResponse Redirects to borrowings index with success/error message
     * @throws \Exception If database transaction fails
     */
    public function storeDirect(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keperluan' => 'required|string|max:500',
            'status' => 'required|in:pending,disetujui,dipinjam,selesai,ditolak',
            'lampiran_bukti' => ['nullable', 'file', new SecureFileUpload()],
        ]);

        $asset = Asset::findOrFail($request->asset_id);

        // Business Rule: Asset must be available unless creating a 'dipinjam' status borrowing
        if ($request->status !== 'dipinjam' && $asset->status !== 'tersedia') {
            return $this->handleUnavailableAsset($asset);
        }

        // Business Rule: Check for date conflicts even with direct bookings
        $existingBorrowing = $this->checkBorrowingConflict(
            $request->asset_id,
            $request->tanggal_mulai,
            $request->tanggal_selesai
        );

        if ($existingBorrowing) {
            $endDate = Carbon::parse($existingBorrowing->tanggal_selesai)->format('d F Y');
            return redirect()->back()
                ->with('error', "Aset sudah dipinjam oleh user lain pada periode yang diminta. Aset akan tersedia kembali pada tanggal {$endDate}. Silakan pilih tanggal lain atau aset lain.");
        }

        DB::beginTransaction();

        try {
            // Handle file upload if provided, with sanitized filename for security
            $lampiranPath = null;
            if ($request->hasFile('lampiran_bukti')) {
                $file = $request->file('lampiran_bukti');
                $extension = $file->getClientOriginalExtension();

                // Generate a unique, sanitized filename to prevent path traversal attacks
                $sanitizedFileName = uniqid('borrowing_doc_' . auth()->id() . '_') . '.' . $extension;
                $lampiranPath = $file->storeAs('borrowing_documents', $sanitizedFileName, 'public');
            }

            // Create borrowing with specified status
            Borrowing::create([
                'user_id' => auth()->id(),
                'asset_id' => $request->asset_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keperluan' => $request->keperluan,
                'lampiran_bukti' => $lampiranPath,
                'status' => $request->status,
                'admin_id' => auth()->id(),
            ]);

            // Business Rule: Update asset status based on borrowing status
            if ($request->status === 'dipinjam') {
                // When directly creating as borrowed, update asset status immediately
                $asset->update(['status' => 'dipinjam']);
            } elseif ($request->status === 'disetujui') {
                // When creating as approved, asset remains available until borrowed
                // This allows for future scheduling without locking the asset immediately
            }

            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil dibuat secara langsung.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Show form for moving borrowing to different asset.
     */
    public function showMoveForm(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'disetujui') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman dengan status "disetujui" yang dapat dipindahkan.');
        }

        $availableAssets = Asset::where('id', '!=', $borrowing->asset_id)
            ->where('status', 'tersedia')
            ->get();

        return view('borrowings.move', compact('borrowing', 'availableAssets'));
    }

    /**
     * Move borrowing to different asset.
     *
     * This method transfers a borrowing from one asset to another with the following business rules:
     * 1. Only approved borrowings can be moved (not pending, borrowed, or completed)
     * 2. The new asset must be available ('tersedia') for borrowing
     * 3. The new asset must not have conflicting bookings in the same time period
     * 4. When moving, the old asset becomes available and the new asset becomes borrowed
     * 5. A borrowing move record is created for audit trail
     * 6. The user is notified about the asset change
     *
     * @param Request $request Contains new_asset_id and alasan_pemindahan (reason for move)
     * @param Borrowing $borrowing The borrowing to move to a different asset
     * @return \Illuminate\Http\RedirectResponse Redirects to borrowing show page with success/error message
     * @throws \Exception If database transaction fails
     */
    public function move(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'new_asset_id' => 'required|exists:assets,id',
            'alasan_pemindahan' => 'required|string|max:500',
        ]);

        // Business Rule: Only approved borrowings can be moved
        if ($borrowing->status !== 'disetujui') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman dengan status "disetujui" yang dapat dipindahkan.');
        }

        $newAsset = Asset::findOrFail($request->new_asset_id);

        // Business Rule: New asset must be available for borrowing
        if ($newAsset->status !== 'tersedia') {
            return redirect()->back()
                ->with('error', 'Aset baru tidak tersedia untuk dipinjam.');
        }

        // Business Rule: Check for conflicts on the new asset in the same time period
        $conflictingBorrowings = $this->getConflictingBorrowings(
            $request->new_asset_id,
            $borrowing->id,
            $borrowing->tanggal_mulai,
            $borrowing->tanggal_selesai,
            ['pending', 'disetujui', 'dipinjam']
        );

        if ($conflictingBorrowings->count() > 0) {
            return redirect()->back()
                ->with('error', 'Aset baru sudah dipesan untuk dipinjam oleh user lain pada rentang tanggal yang sama.');
        }

        DB::beginTransaction();

        try {
            // Create move record for audit trail
            $borrowingMove = BorrowingMove::create([
                'borrowing_id' => $borrowing->id,
                'old_asset_id' => $borrowing->asset_id,
                'new_asset_id' => $request->new_asset_id,
                'alasan_pemindahan' => $request->alasan_pemindahan,
                'admin_id' => auth()->id(),
            ]);

            // Business Rule: Release the old asset back to available status
            $borrowing->asset->update(['status' => 'tersedia']);

            // Update borrowing to reference the new asset
            $borrowing->update(['asset_id' => $request->new_asset_id]);

            // Business Rule: Mark the new asset as borrowed
            $newAsset->update(['status' => 'dipinjam']);

            DB::commit();

            // Notify the user about the asset change
            $this->sendMoveNotification($borrowing, $borrowingMove);

            return redirect()->route('borrowings.show', $borrowing->id)
                ->with('success', 'Peminjaman berhasil dipindahkan ke aset baru.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memindahkan peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Get conflicting borrowings for an asset during a specific period.
     *
     * This method identifies borrowings that conflict with a given time period based on the following logic:
     * - Two periods conflict if they overlap at any point
     * - Overlap occurs when one period starts before the other ends AND ends after the other starts
     * - The specified borrowing ID is excluded from results (typically to exclude the current borrowing being checked)
     * - Only borrowings with specified statuses are considered (e.g., pending, approved, borrowed)
     *
     * @param int $assetId The asset ID to check for conflicts
     * @param int $excludeBorrowingId The borrowing ID to exclude from results
     * @param string $startDate The start date to check conflicts for
     * @param string $endDate The end date to check conflicts for
     * @param array $statuses Array of statuses to include in the conflict check
     * @return \Illuminate\Database\Eloquent\Collection Collection of conflicting borrowings
     */
    private function getConflictingBorrowings($assetId, $excludeBorrowingId, $startDate, $endDate, array $statuses)
    {
        return Borrowing::where('asset_id', $assetId)
            ->where('id', '!=', $excludeBorrowingId)
            ->whereIn('status', $statuses)
            // Check for overlapping date ranges:
            // Period A overlaps with Period B if A starts before B ends AND A ends after B starts
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])  // New start falls within existing period
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])  // New end falls within existing period
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        // New period completely encompasses existing period
                        $q->where('tanggal_mulai', '<=', $startDate)
                            ->where('tanggal_selesai', '>=', $endDate);
                    });
            })
            ->get();
    }

    /**
     * Reject conflicting borrowings.
     */
    private function rejectConflictingBorrowings($borrowings, $adminId, $reason)
    {
        $count = 0;

        foreach ($borrowings as $conflictingBorrowing) {
            $conflictingBorrowing->update([
                'status' => 'ditolak',
                'admin_id' => $adminId,
            ]);

            BorrowingRejection::create([
                'borrowing_id' => $conflictingBorrowing->id,
                'alasan' => $reason,
            ]);

            $count++;
        }

        return $count;
    }

    /**
     * Check if there's an active borrowing conflict.
     *
     * This method checks for any existing borrowings that conflict with a proposed time period.
     * A conflict exists when:
     * - The asset has an existing booking with status 'pending', 'disetujui', or 'dipinjam'
     * - The proposed time period overlaps with the existing booking's time period
     * - Overlap is determined using the same logic as getConflictingBorrowings()
     *
     * @param int $assetId The asset ID to check for conflicts
     * @param string $startDate The proposed start date
     * @param string $endDate The proposed end date
     * @return \App\Models\Borrowing|null Returns the first conflicting borrowing or null if none found
     */
    private function checkBorrowingConflict($assetId, $startDate, $endDate)
    {
        return Borrowing::where('asset_id', $assetId)
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            // Check for overlapping date ranges:
            // Period A overlaps with Period B if A starts before B ends AND A ends after B starts
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])  // Proposed start falls within existing period
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])  // Proposed end falls within existing period
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        // Proposed period completely encompasses existing period
                        $q->where('tanggal_mulai', '<=', $startDate)
                            ->where('tanggal_selesai', '>=', $endDate);
                    });
            })
            ->first();
    }

    /**
     * Handle unavailable asset scenario.
     *
     * This method determines the appropriate response when a user attempts to borrow an unavailable asset.
     * It checks the asset's status and provides specific error messages based on the reason for unavailability:
     * 1. If asset is currently borrowed ('dipinjam'), shows when it will be available again
     * 2. If asset has upcoming bookings ('pending' or 'disetujui'), shows when the next booking starts
     * 3. For other unavailability reasons, shows a general error message
     *
     * @param Asset $asset The unavailable asset to handle
     * @return \Illuminate\Http\RedirectResponse Redirects back with an appropriate error message
     */
    private function handleUnavailableAsset($asset)
    {
        // Check if asset is currently borrowed
        if ($asset->status === 'dipinjam') {
            $activeBorrowing = Borrowing::where('asset_id', $asset->id)
                ->where('status', 'dipinjam')
                ->first();

            if ($activeBorrowing) {
                $endDate = Carbon::parse($activeBorrowing->tanggal_selesai)->format('d F Y');
                return redirect()->back()
                    ->with('error', "Aset ini sedang dipinjam oleh user lain sampai tanggal {$endDate}. Silakan pilih tanggal lain atau aset lain.");
            }
        }

        // Check for upcoming bookings that might affect availability
        $upcomingBooking = Borrowing::where('asset_id', $asset->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where('tanggal_mulai', '>=', Carbon::now())
            ->first();

        if ($upcomingBooking) {
            $startDate = Carbon::parse($upcomingBooking->tanggal_mulai)->format('d F Y');
            return redirect()->back()
                ->with('error', "Aset ini telah dipesan untuk dipinjam mulai tanggal {$startDate}. Silakan pilih tanggal lain atau aset lain.");
        }

        return redirect()->back()
            ->with('error', 'Aset saat ini tidak tersedia untuk dipinjam.');
    }

    /**
     * Send notification to user about borrowing move.
     */
    private function sendMoveNotification(Borrowing $borrowing, BorrowingMove $borrowingMove)
    {
        $borrowing->user->notify(new BorrowingMoveNotification($borrowingMove));
    }

    /**
     * Check asset availability for given date range.
     *
     * This method checks if an asset is available for a specified date range by looking for conflicts
     * with existing borrowings. It follows these business rules:
     * 1. Only considers borrowings with status 'pending', 'disetujui', or 'dipinjam'
     * 2. Checks for overlapping date ranges between the requested period and existing bookings
     * 3. Returns availability status and appropriate message in JSON format
     *
     * @OA\Post(
     *     path="/api/check-availability/{asset}",
     *     summary="Check asset availability",
     *     description="Check if an asset is available for a given date range",
     *     tags={"Borrowing"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="asset",
     *         in="path",
     *         required=true,
     *         description="Asset ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tanggal_mulai", "tanggal_selesai"},
     *             @OA\Property(property="tanggal_mulai", type="string", format="date", example="2023-12-01"),
     *             @OA\Property(property="tanggal_selesai", type="string", format="date", example="2023-12-05")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Availability check result",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="available", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Aset tersedia untuk periode tersebut.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Asset not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     *
     * @param Request $request Contains tanggal_mulai and tanggal_selesai
     * @param Asset $asset The asset to check availability for
     * @return \Illuminate\Http\JsonResponse JSON response with availability status and message
     */
    public function checkAvailability(Request $request, Asset $asset)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        // Business Rule: Check for borrowing conflicts during the requested period
        // Only consider borrowings with status 'pending', 'disetujui', or 'dipinjam'
        $existingBorrowing = $this->checkBorrowingConflict(
            $asset->id,
            $request->tanggal_mulai,
            $request->tanggal_selesai
        );

        return response()->json([
            'available' => !$existingBorrowing,
            'message' => $existingBorrowing ? 'Aset sudah dipesan untuk periode tersebut.' : 'Aset tersedia untuk periode tersebut.'
        ]);
    }
}
