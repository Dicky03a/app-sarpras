<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Rules\SecureFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{

    public function index()
    {
        $assets = Asset::with('category')->paginate(20);
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $categories = AssetCategory::all();
        return view('assets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:asset_categories,id',
            'name' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'photo' => ['nullable', 'file', new SecureFileUpload(['jpeg', 'png', 'jpg', 'gif'], 2048)],
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        unset($data['kode_aset']);

        Asset::create($data);

        return redirect()->route('assets.index')
            ->with('success', 'Asset created successfully.');
    }

    public function show(Asset $asset)
    {
        $asset->load('category');
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        return view('assets.edit', compact('asset', 'categories'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'category_id' => 'required|exists:asset_categories,id',
            'name' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'photo' => ['nullable', 'file', new SecureFileUpload(['jpeg', 'png', 'jpg', 'gif'], 2048)],
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($asset->photo) {
                Storage::disk('public')->delete($asset->photo);
            }

            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        unset($data['kode_aset']);

        $asset->update($data);

        return redirect()->route('assets.index')
            ->with('success', 'Asset updated successfully.');
    }

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

    private function uploadPhoto($photo)
    {
        $extension = $photo->getClientOriginalExtension();
        $sanitizedFileName = uniqid('asset_photo_' . auth()->id() . '_') . '.' . $extension;
        return $photo->storeAs('assets', $sanitizedFileName, 'public');
    }
}
