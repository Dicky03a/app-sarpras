@extends('admin.dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Asset</h1>
                    <p class="mt-2 text-sm text-gray-600">Update asset information and details</p>
                </div>
                <a href="{{ route('assets.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0D903A] transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-[#0D903A] to-[#0a7a31] border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-white">Asset Information</h2>
                </div>

                <!-- Card Body -->
                <div class="p-6 space-y-6">
                    <!-- Category Field -->
                    <div class="space-y-2">
                        <label for="category_id" class="block text-sm font-semibold text-gray-700">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="category_id" id="category_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-[#0D903A] focus:border-transparent transition-all duration-200 appearance-none cursor-pointer @error('category_id') border-red-500 @enderror"
                                required>
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('category_id')
                        <p class="flex items-center text-sm text-red-600 mt-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Asset Name Field -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700">
                            Asset Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-[#0D903A] focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror"
                            value="{{ old('name', $asset->name) }}"
                            placeholder="Enter asset name"
                            required>
                        @error('name')
                        <p class="flex items-center text-sm text-red-600 mt-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Asset Code Field (Read-only) -->
                    <div class="space-y-2">
                        <label for="kode_aset" class="block text-sm font-semibold text-gray-700">
                            Asset Code
                        </label>
                        <div class="relative">
                            <input type="text" name="kode_aset" id="kode_aset"
                                class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed"
                                value="{{ old('kode_aset', $asset->kode_aset) }}"
                                readonly disabled>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Asset code is auto-generated and cannot be changed</p>
                    </div>

                    <!-- Location Field -->
                    <div class="space-y-2">
                        <label for="lokasi" class="block text-sm font-semibold text-gray-700">
                            Location <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="lokasi" id="lokasi"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-[#0D903A] focus:border-transparent transition-all duration-200 @error('lokasi') border-red-500 @enderror"
                            value="{{ old('lokasi', $asset->lokasi) }}"
                            placeholder="Enter asset location"
                            required>
                        @error('lokasi')
                        <p class="flex items-center text-sm text-red-600 mt-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Condition and Status Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Condition -->
                        <div class="space-y-2">
                            <label for="kondisi" class="block text-sm font-semibold text-gray-700">
                                Condition <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="kondisi" id="kondisi"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-[#0D903A] focus:border-transparent transition-all duration-200 appearance-none cursor-pointer @error('kondisi') border-red-500 @enderror"
                                    required>
                                    <option value="">Select Condition</option>
                                    <option value="baik" {{ old('kondisi', $asset->kondisi) == 'baik' ? 'selected' : '' }}>
                                        ✓ Baik
                                    </option>
                                    <option value="rusak ringan" {{ old('kondisi', $asset->kondisi) == 'rusak ringan' ? 'selected' : '' }}>
                                        ⚠ Rusak Ringan
                                    </option>
                                    <option value="rusak berat" {{ old('kondisi', $asset->kondisi) == 'rusak berat' ? 'selected' : '' }}>
                                        ✗ Rusak Berat
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('kondisi')
                            <p class="flex items-center text-sm text-red-600 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="status" id="status"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-[#0D903A] focus:border-transparent transition-all duration-200 appearance-none cursor-pointer @error('status') border-red-500 @enderror"
                                    required>
                                    <option value="">Select Status</option>
                                    <option value="tersedia" {{ old('status', $asset->status) == 'tersedia' ? 'selected' : '' }}>
                                        ✓ Tersedia
                                    </option>
                                    <option value="dipinjam" {{ old('status', $asset->status) == 'dipinjam' ? 'selected' : '' }}>
                                        ⏱ Dipinjam
                                    </option>
                                    <option value="rusak" {{ old('status', $asset->status) == 'rusak' ? 'selected' : '' }}>
                                        ✗ Rusak
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('status')
                            <p class="flex items-center text-sm text-red-600 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description Field -->
                    <div class="space-y-2">
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea name="deskripsi" id="deskripsi"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-[#0D903A] focus:border-transparent transition-all duration-200 resize-none @error('deskripsi') border-red-500 @enderror"
                            rows="4"
                            placeholder="Enter asset description (optional)">{{ old('deskripsi', $asset->deskripsi) }}</textarea>
                        @error('deskripsi')
                        <p class="flex items-center text-sm text-red-600 mt-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Photo Upload Field -->
                    <div class="space-y-2">
                        <label for="photo" class="block text-sm font-semibold text-gray-700">
                            Asset Photo
                        </label>

                        @if($asset->photo)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-3">Current Photo:</p>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $asset->photo) }}"
                                    alt="Current Photo"
                                    class="w-40 h-40 object-cover rounded-lg border-2 border-gray-300 shadow-sm">
                                <div class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="relative">
                            <input type="file" name="photo" id="photo"
                                class="hidden"
                                accept="image/*"
                                onchange="previewImage(event)">
                            <label for="photo"
                                class="flex items-center justify-center w-full px-4 py-3 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-100 hover:border-[#0D903A] transition-all duration-200 @error('photo') border-red-500 @enderror">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-2 flex text-sm text-gray-600">
                                        <span class="relative font-medium text-[#0D903A] hover:text-[#0a7a31]">
                                            Upload a file
                                        </span>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </label>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-3">New Photo Preview:</p>
                            <img id="preview" class="w-40 h-40 object-cover rounded-lg border-2 border-gray-300 shadow-sm">
                        </div>

                        @error('photo')
                        <p class="flex items-center text-sm text-red-600 mt-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="flex items-center text-xs text-gray-500 mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Leave blank to keep current photo
                        </p>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> Required fields
                        </p>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('assets.index') }}"
                                class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-[#0D903A] to-[#0a7a31] text-white rounded-lg text-sm font-semibold hover:from-[#0a7a31] hover:to-[#085c23] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0D903A] transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Asset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection