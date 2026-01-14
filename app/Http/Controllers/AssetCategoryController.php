<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name',
        ]);

        AssetCategory::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(AssetCategory $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(AssetCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, AssetCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name,' . $category->id,
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(AssetCategory $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
