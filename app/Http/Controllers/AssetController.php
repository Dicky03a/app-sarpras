<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with('category')->get();
        return view('assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AssetCategory::all();
        return view('assets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:asset_categories,id',
            'name' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        // Remove kode_aset from the request since it will be auto-generated
        unset($data['kode_aset']);

        Asset::create($data);

        return redirect()->route('assets.index')
                         ->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        $asset->load('category');
        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        return view('assets.edit', compact('asset', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'category_id' => 'required|exists:asset_categories,id',
            'name' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($asset->photo) {
                Storage::disk('public')->delete($asset->photo);
            }

            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        // Remove kode_aset from the request since we don't want to update it
        unset($data['kode_aset']);

        $asset->update($data);

        return redirect()->route('assets.index')
                         ->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        // Delete photo if exists
        if ($asset->photo) {
            Storage::disk('public')->delete($asset->photo);
        }

        $asset->delete();

        return redirect()->route('assets.index')
                         ->with('success', 'Asset deleted successfully.');
    }

    /**
     * Upload photo and return the path
     */
    private function uploadPhoto($photo)
    {
        $fileName = time() . '_' . $photo->getClientOriginalName();
        return $photo->storeAs('assets', $fileName, 'public');
    }
}