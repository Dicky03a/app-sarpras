@extends('layouts.index')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Laporan Kerusakan Aset</h1>
            <p class="text-gray-600 dark:text-gray-300">Laporkan aset yang mengalami kerusakan untuk segera ditindaklanjuti</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Form Laporan Kerusakan</h2>
            
            <form action="{{ route('public.report.damage.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Nama Lengkap *</label>
                        <input type="text" name="name" id="name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Masukkan nama lengkap Anda" required value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Email *</label>
                        <input type="email" name="email" id="email"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Masukkan email Anda" required value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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

                <div class="flex items-center justify-center mt-6">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>

        <!-- Public Information Section -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg shadow p-6 border border-blue-200 dark:border-blue-800">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Informasi Laporan Kerusakan</h2>
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Laporan kerusakan akan segera ditindaklanjuti oleh tim terkait</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Anda akan menerima notifikasi setelah laporan diverifikasi</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Harap sertakan foto kerusakan untuk mempercepat proses verifikasi</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection