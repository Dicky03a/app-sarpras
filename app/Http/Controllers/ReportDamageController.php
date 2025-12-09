<?php

namespace App\Http\Controllers;

use App\Models\ReportDamage;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;

class ReportDamageController extends Controller
{
    /**
     * Display a listing of the report damages.
     */
    public function index()
    {
        $reportDamages = ReportDamage::with(['user', 'asset'])->orderBy('tanggal_lapor', 'desc')->get();
        return view('reportdamages.index', compact('reportDamages'));
    }

    /**
     * Show the form for creating a new report damage.
     */
    public function create()
    {
        $assets = Asset::all();
        $users = User::all();
        return view('reportdamages.create', compact('assets', 'users'));
    }

    /**
     * Store a newly created report damage in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'asset_id' => 'required|exists:assets,id',
            'deskripsi_kerusakan' => 'required|string',
        ]);

        ReportDamage::create($request->all());

        return redirect()->route('reportdamages.index')
                         ->with('success', 'Report damage created successfully.');
    }

    /**
     * Display the specified report damage.
     */
    public function show(ReportDamage $reportDamage)
    {
        $reportDamage->load(['user', 'asset']);
        return view('reportdamages.show', compact('reportDamage'));
    }

    /**
     * Show the form for editing the specified report damage.
     */
    public function edit(ReportDamage $reportDamage)
    {
        $assets = Asset::all();
        $users = User::all();
        return view('reportdamages.edit', compact('reportDamage', 'assets', 'users'));
    }

    /**
     * Update the specified report damage in storage.
     */
    public function update(Request $request, ReportDamage $reportDamage)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'asset_id' => 'required|exists:assets,id',
            'deskripsi_kerusakan' => 'required|string',
        ]);

        $reportDamage->update($request->all());

        return redirect()->route('reportdamages.index')
                         ->with('success', 'Report damage updated successfully.');
    }

    /**
     * Remove the specified report damage from storage.
     */
    public function destroy(ReportDamage $reportDamage)
    {
        $reportDamage->delete();

        return redirect()->route('reportdamages.index')
                         ->with('success', 'Report damage deleted successfully.');
    }
}