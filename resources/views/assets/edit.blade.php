@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Asset</h1>

        <form action="{{ route('assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="category_id" class="block text-gray-700 mb-2">Category</label>
                        <select name="category_id" id="category_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-gray-700 mb-2">Asset Name</label>
                        <input type="text" name="name" id="name" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('name', $asset->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kode_aset" class="block text-gray-700 mb-2">Asset Code</label>
                        <input type="text" name="kode_aset" id="kode_aset"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100"
                               value="{{ old('kode_aset', $asset->kode_aset) }}" readonly disabled>
                    </div>

                    <div>
                        <label for="lokasi" class="block text-gray-700 mb-2">Location</label>
                        <input type="text" name="lokasi" id="lokasi" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('lokasi', $asset->lokasi) }}" required>
                        @error('lokasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="kondisi" class="block text-gray-700 mb-2">Condition</label>
                            <select name="kondisi" id="kondisi" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Condition</option>
                                <option value="baik" {{ old('kondisi', $asset->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak ringan" {{ old('kondisi', $asset->kondisi) == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak berat" {{ old('kondisi', $asset->kondisi) == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            @error('kondisi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Status</option>
                                <option value="tersedia" {{ old('status', $asset->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipinjam" {{ old('status', $asset->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="rusak" {{ old('status', $asset->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-gray-700 mb-2">Description</label>
                        <textarea name="deskripsi" id="deskripsi" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  rows="4">{{ old('deskripsi', $asset->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 mt-6">
                    <a href="{{ route('assets.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Asset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection