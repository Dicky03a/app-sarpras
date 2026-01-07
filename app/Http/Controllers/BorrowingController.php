<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingRejection;
use App\Models\Asset;
use App\Models\BorrowingMove;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the borrowings.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'asset', 'admin', 'rejection'])->orderBy('created_at', 'desc')->get();
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Display the specified borrowing.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'asset', 'admin', 'rejection', 'moves', 'moves.oldAsset', 'moves.newAsset', 'moves.admin']);
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

        // Check for conflicting borrowing requests for the same asset during the same period
        $conflictingBorrowings = Borrowing::where('asset_id', $borrowing->asset_id)
            ->where('id', '!=', $borrowing->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function ($query) use ($borrowing) {
                $query->whereBetween('tanggal_mulai', [$borrowing->tanggal_mulai, $borrowing->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$borrowing->tanggal_mulai, $borrowing->tanggal_selesai])
                    ->orWhere(function ($q) use ($borrowing) {
                        $q->where('tanggal_mulai', '<=', $borrowing->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $borrowing->tanggal_selesai);
                    });
            })
            ->get();

        // Update the borrowing to approved status
        $borrowing->update([
            'status' => 'disetujui',
            'admin_id' => $request->admin_id,
        ]);

        // Update asset status to 'dipinjam' since it's now approved for borrowing
        $borrowing->asset->update(['status' => 'dipinjam']);

        // Reject all conflicting borrowing requests
        foreach ($conflictingBorrowings as $conflictingBorrowing) {
            $conflictingBorrowing->update([
                'status' => 'ditolak',
                'admin_id' => $request->admin_id,
            ]);

            // Create rejection record for each conflicting borrowing
            BorrowingRejection::create([
                'borrowing_id' => $conflictingBorrowing->id,
                'alasan' => 'Konflik jadwal peminjaman. Telah disetujui peminjaman lain untuk rentang waktu yang sama.',
            ]);
        }

        if ($conflictingBorrowings->count() > 0) {
            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil disetujui. Aset sekarang dalam status "dipinjam". ' . $conflictingBorrowings->count() . ' peminjaman lain yang memiliki konflik jadwal telah ditolak otomatis.');
        } else {
            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil disetujui. Aset sekarang dalam status "dipinjam".');
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

        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Mark a borrowing as borrowed (ongoing).
     */
    public function markAsBorrowed(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Check for conflicting borrowing requests for the same asset during the same period
        $conflictingBorrowings = Borrowing::where('asset_id', $borrowing->asset_id)
            ->where('id', '!=', $borrowing->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function ($query) use ($borrowing) {
                $query->whereBetween('tanggal_mulai', [$borrowing->tanggal_mulai, $borrowing->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$borrowing->tanggal_mulai, $borrowing->tanggal_selesai])
                    ->orWhere(function ($q) use ($borrowing) {
                        $q->where('tanggal_mulai', '<=', $borrowing->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $borrowing->tanggal_selesai);
                    });
            })
            ->get();

        // Update asset status to 'dipinjam'
        $borrowing->asset->update(['status' => 'dipinjam']);

        $borrowing->update([
            'status' => 'dipinjam',
            'admin_id' => $request->admin_id,
        ]);

        // Reject all conflicting borrowing requests
        foreach ($conflictingBorrowings as $conflictingBorrowing) {
            $conflictingBorrowing->update([
                'status' => 'ditolak',
                'admin_id' => $request->admin_id,
            ]);

            // Create rejection record for each conflicting borrowing
            BorrowingRejection::create([
                'borrowing_id' => $conflictingBorrowing->id,
                'alasan' => 'Konflik jadwal peminjaman. Telah diaktifkan peminjaman lain untuk rentang waktu yang sama.',
            ]);
        }

        if ($conflictingBorrowings->count() > 0) {
            return redirect()->route('borrowings.index')
                ->with('success', 'Status peminjaman diperbarui menjadi sedang dipinjam. ' . $conflictingBorrowings->count() . ' peminjaman lain yang memiliki konflik jadwal telah ditolak otomatis.');
        } else {
            return redirect()->route('borrowings.index')
                ->with('success', 'Status peminjaman diperbarui menjadi sedang dipinjam.');
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

        // Update asset status back to 'tersedia'
        $borrowing->asset->update(['status' => 'tersedia']);

        $borrowing->update([
            'status' => 'selesai',
            'admin_id' => $request->admin_id,
        ]);

        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil diselesaikan.');
    }

    /**
     * Show the form for creating a new borrowing request.
     */
    public function create(Asset $asset)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melakukan peminjaman.');
        }

        // Check if asset is available
        if ($asset->status !== 'tersedia') {
            if ($asset->status === 'dipinjam') {
                // Check for active borrowing requests that overlap with the planned borrowing period
                $activeBorrowing = Borrowing::where('asset_id', $asset->id)
                    ->where('status', 'dipinjam')
                    ->first();

                if ($activeBorrowing) {
                    return redirect()->back()->with('error', 'Aset ini sedang dipinjam oleh user lain sampai tanggal ' .
                        \Carbon\Carbon::parse($activeBorrowing->tanggal_selesai)->format('d F Y') .
                        '. Silakan pilih tanggal lain atau aset lain.');
                }
            }

            return redirect()->back()->with('error', 'Aset saat ini tidak tersedia untuk dipinjam.');
        }

        // Only check for borrowed conflicts (active usage), not pending or approved ones
        // User should be able to create a request even if there's another pending or approved request
        $conflictingBorrowings = Borrowing::where('asset_id', $asset->id)
            ->where('status', 'dipinjam')  // Only check for active borrowings
            ->get();

        if ($conflictingBorrowings->count() > 0) {
            $conflictDates = [];
            foreach ($conflictingBorrowings as $conflicting) {
                $conflictDates[] = \Carbon\Carbon::parse($conflicting->tanggal_mulai)->format('d F Y') .
                    ' - ' . \Carbon\Carbon::parse($conflicting->tanggal_selesai)->format('d F Y');
            }

            $conflictDateString = implode(', ', $conflictDates);
            return redirect()->back()->with('error', 'Aset ini sudah dipesan untuk dipinjam oleh user lain pada rentang tanggal: ' .
                $conflictDateString . '. Silakan pilih tanggal lain atau aset lain.');
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
            'lampiran_bukti' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB max
        ]);

        // Check if asset is available
        $asset = Asset::find($request->asset_id);
        if ($asset->status !== 'tersedia') {
            if ($asset->status === 'dipinjam') {
                // Check for active borrowing requests that overlap with the planned borrowing period
                $activeBorrowing = Borrowing::where('asset_id', $asset->id)
                    ->where('status', 'dipinjam')
                    ->first();

                if ($activeBorrowing) {
                    return redirect()->back()->with('error', 'Aset ini sedang dipinjam oleh user lain sampai tanggal ' .
                        \Carbon\Carbon::parse($activeBorrowing->tanggal_selesai)->format('d F Y') .
                        '. Silakan pilih tanggal lain atau aset lain.');
                }
            }

            return redirect()->back()->with('error', 'Aset saat ini tidak tersedia untuk dipinjam.');
        }

        // Check if asset isn't already borrowed during the requested period
        // Only check for 'dipinjam' status (active borrowing), not pending or approved requests
        $existingBorrowing = Borrowing::where('asset_id', $request->asset_id)
            ->where('status', 'dipinjam')  // Only check for active borrowings
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->first();

        if ($existingBorrowing) {
            // Only reject if the asset is actually in use (dipinjam status)
            return redirect()->back()->with('error', 'Aset sudah dipinjam oleh user lain pada periode yang diminta. Aset akan tersedia kembali pada tanggal ' .
                \Carbon\Carbon::parse($existingBorrowing->tanggal_selesai)->format('d F Y') .
                '. Silakan pilih tanggal lain atau aset lain.');
        }

        // Handle file upload
        $lampiranPath = $request->file('lampiran_bukti')->store('borrowing_documents', 'public');

        $borrowing = Borrowing::create([
            'user_id' => auth()->id(),
            'asset_id' => $request->asset_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
            'lampiran_bukti' => $lampiranPath,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Permintaan peminjaman berhasil diajukan.');
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
            'lampiran_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB max
        ]);

        // Check if asset is available (unless admin is creating a 'dipinjam' status)
        $asset = Asset::find($request->asset_id);
        if ($request->status !== 'dipinjam' && $asset->status !== 'tersedia') {
            if ($asset->status === 'dipinjam') {
                // Check for active borrowing requests that overlap with the planned borrowing period
                $activeBorrowing = Borrowing::where('asset_id', $asset->id)
                    ->where('status', 'dipinjam')
                    ->first();

                if ($activeBorrowing) {
                    return redirect()->back()->with('error', 'Aset ini sedang dipinjam oleh user lain sampai tanggal ' .
                        \Carbon\Carbon::parse($activeBorrowing->tanggal_selesai)->format('d F Y') .
                        '. Silakan pilih tanggal lain atau aset lain.');
                }
            }

            return redirect()->back()->with('error', 'Aset saat ini tidak tersedia untuk dipinjam.');
        }

        // Check if asset isn't already borrowed during the requested period
        $existingBorrowing = Borrowing::where('asset_id', $request->asset_id)
            ->where('status', 'dipinjam')  // Only check for active borrowings
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->first();

        if ($existingBorrowing) {
            return redirect()->back()->with('error', 'Aset sudah dipinjam oleh user lain pada periode yang diminta. Aset akan tersedia kembali pada tanggal ' .
                \Carbon\Carbon::parse($existingBorrowing->tanggal_selesai)->format('d F Y') .
                '. Silakan pilih tanggal lain atau aset lain.');
        }

        // Handle file upload if provided
        $lampiranPath = null;
        if ($request->hasFile('lampiran_bukti')) {
            $lampiranPath = $request->file('lampiran_bukti')->store('borrowing_documents', 'public');
        }

        $borrowing = Borrowing::create([
            'user_id' => auth()->id(), // The logged-in admin becomes the user
            'asset_id' => $request->asset_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keperluan' => $request->keperluan,
            'lampiran_bukti' => $lampiranPath,
            'status' => $request->status,
            'admin_id' => auth()->id(), // Admin who created this direct borrowing
        ]);

        // Update asset status if the borrowing is marked as 'dipinjam'
        if ($request->status === 'dipinjam') {
            $asset->update(['status' => 'dipinjam']);
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dibuat secara langsung.');
    }

    /**
     * Show the form for moving a borrowing to a different place.
     */
    public function showMoveForm(Borrowing $borrowing)
    {
        // Check if borrowing status is 'disetujui'
        if ($borrowing->status !== 'disetujui') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman dengan status "disetujui" yang dapat dipindahkan.');
        }

        // Get all available assets (excluding the current one)
        $availableAssets = Asset::where('id', '!=', $borrowing->asset_id)
            ->where('status', 'tersedia')
            ->get();

        return view('borrowings.move', compact('borrowing', 'availableAssets'));
    }

    /**
     * Move a borrowing to a different place.
     */
    public function move(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'new_asset_id' => 'required|exists:assets,id',
            'alasan_pemindahan' => 'required|string|max:500',
        ]);

        // Check if borrowing status is 'disetujui'
        if ($borrowing->status !== 'disetujui') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman dengan status "disetujui" yang dapat dipindahkan.');
        }

        // Get the new asset
        $newAsset = Asset::find($request->new_asset_id);

        // Check if new asset is available
        if ($newAsset->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Tempat baru tidak tersedia untuk dipinjam.');
        }

        // Check for conflicting borrowing requests for the new asset during the same period
        $conflictingBorrowings = Borrowing::where('asset_id', $request->new_asset_id)
            ->where('id', '!=', $borrowing->id)
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->where(function ($query) use ($borrowing) {
                $query->whereBetween('tanggal_mulai', [$borrowing->tanggal_mulai, $borrowing->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$borrowing->tanggal_mulai, $borrowing->tanggal_selesai])
                    ->orWhere(function ($q) use ($borrowing) {
                        $q->where('tanggal_mulai', '<=', $borrowing->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $borrowing->tanggal_selesai);
                    });
            })
            ->get();

        if ($conflictingBorrowings->count() > 0) {
            return redirect()->back()->with('error', 'Tempat baru sudah dipesan untuk dipinjam oleh user lain pada rentang tanggal yang sama.');
        }

        // Start transaction to ensure data consistency
        \DB::beginTransaction();

        try {
            // Create a record in borrowing_moves table to track the move
            $borrowingMove = BorrowingMove::create([
                'borrowing_id' => $borrowing->id,
                'old_asset_id' => $borrowing->asset_id,
                'new_asset_id' => $request->new_asset_id,
                'alasan_pemindahan' => $request->alasan_pemindahan,
                'admin_id' => auth()->id(),
            ]);

            // Update the borrowing record with the new asset
            $borrowing->update([
                'asset_id' => $request->new_asset_id,
            ]);

            // Update asset status: old asset becomes available, new asset becomes borrowed
            $borrowing->asset->update(['status' => 'tersedia']); // old asset
            $newAsset->update(['status' => 'dipinjam']); // new asset

            \DB::commit();

            // Send notification to user about the move
            $this->sendMoveNotification($borrowing, $borrowingMove);

            return redirect()->route('borrowings.show', $borrowing->id)
                ->with('success', 'Peminjaman berhasil dipindahkan ke tempat baru.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memindahkan peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Send notification to user about the move.
     */
    private function sendMoveNotification(Borrowing $borrowing, BorrowingMove $borrowingMove)
    {
        // Send database notification to the user
        $borrowing->user->notify(new \App\Notifications\BorrowingMoveNotification($borrowingMove));
    }
}
