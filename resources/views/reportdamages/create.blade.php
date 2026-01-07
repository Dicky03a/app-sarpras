@extends('layouts.user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Buat Laporan Kerusakan Aset</h1>
            <a href="{{ route('user.report.damages') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <form action="{{ route('reportdamages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="asset_id" class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Pilih Aset *</label>
                        <select name="asset_id" id="asset_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required>
                            <option value="">Pilih aset yang mengalami kerusakan...</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->name }} ({{ $asset->kode_aset }})
                                </option>
                            @endforeach
                        </select>
                        @error('asset_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi_kerusakan" class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Deskripsi Kerusakan *</label>
                        <textarea name="deskripsi_kerusakan" id="deskripsi_kerusakan"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                  rows="4" placeholder="Jelaskan kerusakan yang terjadi pada aset..." required>{{ old('deskripsi_kerusakan') }}</textarea>
                        @error('deskripsi_kerusakan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="foto_kerusakan" class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Foto Kerusakan</label>
                        <input type="file" name="foto_kerusakan" id="foto_kerusakan"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               accept="image/*">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Format: JPG, PNG, maksimal 5MB</p>
                        @error('foto_kerusakan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('user.report.damages') }}"
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Kirim Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection