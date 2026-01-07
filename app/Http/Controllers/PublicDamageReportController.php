<?php

namespace App\Http\Controllers;

use App\Models\ReportDamage;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PublicDamageReportController extends Controller
{
    /**
     * Show the public form for reporting damage.
     */
    public function showForm()
    {
        $assets = Asset::all();
        return view('public.report-damage', compact('assets'));
    }

    /**
     * Store a newly created damage report from public.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'asset_id' => 'required|exists:assets,id',
            'deskripsi_kerusakan' => 'required|string|max:1000',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Check if a user with this email already exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Create a new user account for the public reporter
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(uniqid()), // Generate a random password
            ]);
        } else {
            // Update the user's name if it's different
            if ($user->name !== $request->name) {
                $user->update(['name' => $request->name]);
            }
        }

        // Handle photo upload if provided
        $fotoPath = null;
        if ($request->hasFile('foto_kerusakan')) {
            $fotoPath = $request->file('foto_kerusakan')->store('damage_reports', 'public');
        }

        ReportDamage::create([
            'user_id' => $user->id,
            'asset_id' => $request->asset_id,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'tanggal_lapor' => now(),
            'foto_kerusakan' => $fotoPath,
            'status' => 'menunggu_verifikasi', // Default status
        ]);

        return redirect()->route('public.report.damage.form')
                         ->with('success', 'Laporan kerusakan berhasil dikirim dan menunggu verifikasi.');
    }

    /**
     * Show the public form for checking damage report status.
     */
    public function showStatusForm()
    {
        return view('public.report-damage-status');
    }

    /**
     * Get the status of a damage report.
     */
    public function getStatus(Request $request)
    {
        $request->validate([
            'report_id' => 'required|integer|exists:report_damages,id',
            'email' => 'required|email',
        ]);

        $reportDamage = ReportDamage::with(['asset', 'user', 'admin'])
            ->where('id', $request->report_id)
            ->first();

        // Verify that the email matches the user who created the report
        if ($reportDamage && $reportDamage->user->email !== $request->email) {
            $reportDamage = null; // Don't show the report if email doesn't match
        }

        return view('public.report-damage-status', compact('reportDamage'));
    }
}
