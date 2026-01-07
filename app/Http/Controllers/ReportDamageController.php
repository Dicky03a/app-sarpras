<?php

namespace App\Http\Controllers;

use App\Models\ReportDamage;
use App\Models\Asset;
use App\Models\User;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportDamageController extends Controller
{
    /**
     * Display a listing of the report damages.
     */
    public function index()
    {
        $reportDamages = ReportDamage::with(['user', 'asset', 'admin'])->orderBy('tanggal_lapor', 'desc')->get();
        return view('reportdamages.index', compact('reportDamages'));
    }

    /**
     * Show the form for creating a new report damage.
     */
    public function create()
    {
        $assets = Asset::all();
        return view('reportdamages.create', compact('assets'));
    }

    /**
     * Store a newly created report damage in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'deskripsi_kerusakan' => 'required|string|max:1000',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle photo upload if provided
        $fotoPath = null;
        if ($request->hasFile('foto_kerusakan')) {
            $fotoPath = $request->file('foto_kerusakan')->store('damage_reports', 'public');
        }

        ReportDamage::create([
            'user_id' => Auth::id(), // Current logged-in user
            'asset_id' => $request->asset_id,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'tanggal_lapor' => now(),
            'foto_kerusakan' => $fotoPath,
            'status' => 'menunggu_verifikasi', // Default status
        ]);

        return redirect()->route('user.requests') // Redirect to user's requests page
                         ->with('success', 'Laporan kerusakan berhasil dikirim dan menunggu verifikasi.');
    }

    /**
     * Display the specified report damage.
     */
    public function show(ReportDamage $reportDamage)
    {
        $reportDamage->load(['user', 'asset', 'admin']);
        return view('reportdamages.show', compact('reportDamage'));
    }

    /**
     * Show the form for editing the specified report damage.
     */
    public function edit(ReportDamage $reportDamage)
    {
        $assets = Asset::all();
        return view('reportdamages.edit', compact('reportDamage', 'assets'));
    }

    /**
     * Update the specified report damage in storage.
     */
    public function update(Request $request, ReportDamage $reportDamage)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'deskripsi_kerusakan' => 'required|string|max:1000',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle photo upload if provided
        $fotoPath = $reportDamage->foto_kerusakan; // Keep existing photo if no new one is uploaded
        if ($request->hasFile('foto_kerusakan')) {
            // Delete old photo if exists
            if ($fotoPath) {
                \Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto_kerusakan')->store('damage_reports', 'public');
        }

        $reportDamage->update([
            'user_id' => $request->user_id,
            'asset_id' => $request->asset_id,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'foto_kerusakan' => $fotoPath,
        ]);

        return redirect()->route('reportdamages.index')
                         ->with('success', 'Report damage updated successfully.');
    }

    /**
     * Remove the specified report damage from storage.
     */
    public function destroy(ReportDamage $reportDamage)
    {
        // Delete the photo if it exists
        if ($reportDamage->foto_kerusakan) {
            \Storage::disk('public')->delete($reportDamage->foto_kerusakan);
        }

        $reportDamage->delete();

        return redirect()->route('reportdamages.index')
                         ->with('success', 'Report damage deleted successfully.');
    }

    /**
     * Show the form for admin to verify a damage report.
     */
    public function showVerify(ReportDamage $reportDamage)
    {
        $reportDamage->load(['user', 'asset']);
        return view('reportdamages.verify', compact('reportDamage'));
    }

    /**
     * Process the verification of a damage report by admin.
     */
    public function verify(Request $request, ReportDamage $reportDamage)
    {
        $request->validate([
            'kondisi_setelah_verifikasi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'pesan_tindak_lanjut' => 'required|string|max:1000',
        ]);

        // Update the report damage with verification details
        $reportDamage->update([
            'status' => 'selesai',
            'kondisi_setelah_verifikasi' => $request->kondisi_setelah_verifikasi,
            'pesan_tindak_lanjut' => $request->pesan_tindak_lanjut,
            'admin_id' => Auth::id(),
            'tanggal_verifikasi' => now(),
        ]);

        // Update the asset condition in the assets table
        $asset = $reportDamage->asset;
        $asset->update([
            'kondisi' => $request->kondisi_setelah_verifikasi
        ]);

        // Send notification to the user about the verification
        $this->sendVerificationNotification($reportDamage);

        return redirect()->route('reportdamages.index')
                         ->with('success', 'Laporan kerusakan berhasil diverifikasi dan kondisi aset diperbarui.');
    }

    /**
     * Send notification to user about the verification.
     */
    private function sendVerificationNotification(ReportDamage $reportDamage)
    {
        // Send database notification to the user
        $reportDamage->user->notify(new \App\Notifications\DamageReportVerifiedNotification($reportDamage));
    }

    /**
     * Display damage reports for the current user.
     */
    public function userReports()
    {
        $user = Auth::user();
        $reportDamages = $user->reportDamages()
            ->with(['asset', 'admin'])
            ->orderBy('tanggal_lapor', 'desc')
            ->get();

        return view('user.report-damages', compact('reportDamages'));
    }

    /**
     * Display a specific damage report for the current user.
     */
    public function userReportDetail(ReportDamage $reportDamage)
    {
        $user = Auth::user();

        // Ensure the user can only view their own damage reports
        if ($reportDamage->user_id !== $user->id) {
            abort(403, 'Unauthorized to view this damage report.');
        }

        $reportDamage->load(['asset', 'asset.category', 'admin']);

        return view('user.report-damage-detail', compact('reportDamage'));
    }
}