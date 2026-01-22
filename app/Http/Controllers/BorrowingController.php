<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingRejection;
use App\Models\Asset;
use App\Models\BorrowingMove;
use App\Models\User;
use App\Notifications\BorrowingMoveNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the borrowings.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'asset', 'admin', 'rejection'])
            ->orderBy('created_at', 'desc')
            ->get();

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
     * Approve a borrowing request.
     */
    public function approve(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Check if borrowing is already approved or processed
        if ($borrowing->status !== 'pending') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        DB::beginTransaction();

        try {
            // Get conflicting borrowings
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

            // Reject all conflicting borrowing requests (but don't change asset status yet)
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
     * Reject a borrowing request.
     */
    public function reject(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'alasan' => 'required|string|max:500',
        ]);

        // Check if borrowing is already processed
        if (in_array($borrowing->status, ['ditolak', 'selesai'])) {
            return redirect()->route('borrowings.index')
                ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        DB::beginTransaction();

        try {
            // Update borrowing status
            $borrowing->update([
                'status' => 'ditolak',
                'admin_id' => $request->admin_id,
            ]);

            // Create rejection record
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
     * Mark a borrowing as borrowed (ongoing).
     */
    public function markAsBorrowed(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Check if borrowing status is valid for this action
        if (!in_array($borrowing->status, ['pending', 'disetujui'])) {
            return redirect()->route('borrowings.index')
                ->with('error', 'Status peminjaman tidak valid untuk aksi ini.');
        }

        DB::beginTransaction();

        try {
            // Get conflicting borrowings
            $conflictingBorrowings = $this->getConflictingBorrowings(
                $borrowing->asset_id,
                $borrowing->id,
                $borrowing->tanggal_mulai,
                $borrowing->tanggal_selesai,
                ['pending', 'disetujui']
            );

            // Update asset status to 'dipinjam'
            $borrowing->asset->update(['status' => 'dipinjam']);

            // Update borrowing status
            $borrowing->update([
                'status' => 'dipinjam',
                'admin_id' => $request->admin_id,
            ]);

            // Reject all conflicting borrowing requests
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
     * Mark a borrowing as returned (completed).
     */
    public function markAsReturned(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Check if borrowing is currently borrowed
        if ($borrowing->status !== 'dipinjam') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman dengan status "dipinjam" yang dapat diselesaikan.');
        }

        DB::beginTransaction();

        try {
            // Update asset status back to 'tersedia'
            $borrowing->asset->update(['status' => 'tersedia']);

            // Update borrowing status
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
     */
    public function create(Asset $asset)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melakukan peminjaman.');
        }

        // Check if asset is available
        if ($asset->status !== 'tersedia') {
            return $this->handleUnavailableAsset($asset);
        }

        return view('borrowings.create', compact('asset'));
    }

    /**
     * Store a newly created borrowing request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keperluan' => 'required|string|max:500',
            'lampiran_bukti' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        $asset = Asset::findOrFail($request->asset_id);

        // Check if asset is available
        if ($asset->status !== 'tersedia') {
            return $this->handleUnavailableAsset($asset);
        }

        // Check for borrowing conflicts during the requested period
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
            // Handle file upload
            $lampiranPath = $request->file('lampiran_bukti')
                ->store('borrowing_documents', 'public');

            // Create borrowing
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
     */
    public function storeDirect(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keperluan' => 'required|string|max:500',
            'status' => 'required|in:pending,disetujui,dipinjam,selesai,ditolak',
            'lampiran_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        $asset = Asset::findOrFail($request->asset_id);

        // Check if asset is available (except for 'dipinjam' status)
        if ($request->status !== 'dipinjam' && $asset->status !== 'tersedia') {
            return $this->handleUnavailableAsset($asset);
        }

        // Check for borrowing conflicts
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
            // Handle file upload if provided
            $lampiranPath = null;
            if ($request->hasFile('lampiran_bukti')) {
                $lampiranPath = $request->file('lampiran_bukti')
                    ->store('borrowing_documents', 'public');
            }

            // Create borrowing
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

            // Update asset status only if borrowing is actively borrowed
            if ($request->status === 'dipinjam') {
                $asset->update(['status' => 'dipinjam']);
            } elseif ($request->status === 'disetujui') {
                // Don't change asset status when creating a direct booking with 'disetujui' status
                // The asset remains 'tersedia' until the borrowing actually begins
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
     */
    public function move(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'new_asset_id' => 'required|exists:assets,id',
            'alasan_pemindahan' => 'required|string|max:500',
        ]);

        if ($borrowing->status !== 'disetujui') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman dengan status "disetujui" yang dapat dipindahkan.');
        }

        $newAsset = Asset::findOrFail($request->new_asset_id);

        // Check if new asset is available
        if ($newAsset->status !== 'tersedia') {
            return redirect()->back()
                ->with('error', 'Aset baru tidak tersedia untuk dipinjam.');
        }

        // Check for conflicts on the new asset
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
            // Create move record
            $borrowingMove = BorrowingMove::create([
                'borrowing_id' => $borrowing->id,
                'old_asset_id' => $borrowing->asset_id,
                'new_asset_id' => $request->new_asset_id,
                'alasan_pemindahan' => $request->alasan_pemindahan,
                'admin_id' => auth()->id(),
            ]);

            // Update old asset status to available
            $borrowing->asset->update(['status' => 'tersedia']);

            // Update borrowing with new asset
            $borrowing->update(['asset_id' => $request->new_asset_id]);

            // Update new asset status to borrowed
            $newAsset->update(['status' => 'dipinjam']);

            DB::commit();

            // Send notification to user
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
     */
    private function getConflictingBorrowings($assetId, $excludeBorrowingId, $startDate, $endDate, array $statuses)
    {
        return Borrowing::where('asset_id', $assetId)
            ->where('id', '!=', $excludeBorrowingId)
            ->whereIn('status', $statuses)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
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
     */
    private function checkBorrowingConflict($assetId, $startDate, $endDate)
    {
        return Borrowing::where('asset_id', $assetId)
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('tanggal_mulai', '<=', $startDate)
                            ->where('tanggal_selesai', '>=', $endDate);
                    });
            })
            ->first();
    }

    /**
     * Handle unavailable asset scenario.
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
     */
    public function checkAvailability(Request $request, Asset $asset)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        // Check for borrowing conflicts during the requested period
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
