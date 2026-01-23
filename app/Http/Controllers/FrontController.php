<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        // You can add logic for the home page here if needed
        $assets = Asset::with('category')->get()->sortByDesc('created_at')->take(6); // Get the latest 6 assets
        $categories = AssetCategory::all();
        return view('frond.index', compact('assets', 'categories')); // or whatever home page view you want
    }

    public function category()
    {
        $assets = Asset::with('category')->get();
        $categories = AssetCategory::all();

        return view('frond.category', compact('assets', 'categories'));
    }

    public function asset()
    {
        $assets = Asset::all();

        return view('frond.asset', compact('assets'));
    }

    public function showAsset($slug)
    {
        $asset = Asset::where('slug', $slug)->firstOrFail();

        return view('frond.components.details', compact('asset'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $assets = Asset::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('kode_aset', 'LIKE', "%{$query}%")
                    ->orWhereHas('category', function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhere('lokasi', 'LIKE', "%{$query}%")
                    ->orWhere('kondisi', 'LIKE', "%{$query}%")
                    ->orWhere('status', 'LIKE', "%{$query}%")
                    ->with('category')
                    ->get();

        $categories = AssetCategory::all();

        return view('frond.search-results', compact('assets', 'categories', 'query'));
    }
}
