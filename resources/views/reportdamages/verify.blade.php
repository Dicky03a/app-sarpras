@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi Laporan Kerusakan</h1>
            <a href="{{ route('reportdamages.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Laporan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">ID Laporan</label>
                    <p class="text-gray-900">#{{ $reportDamage->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Status</label>
                    <p class="text-gray-900">
                        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">
                            Menunggu Verifikasi
                        </span>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Pelapor</label>
                    <p class="text-gray-900">{{ $reportDamage->user->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Aset</label>
                    <p class="text-gray-900">{{ $reportDamage->asset->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 mb-2 font-semibold">Deskripsi Kerusakan</label>
                    <p class="text-gray-900">{{ $reportDamage->deskripsi_kerusakan }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 mb-2 font-semibold">Foto Kerusakan</label>
                    @if($reportDamage->foto_kerusakan)
                        <div class="flex flex-col">
                            <a href="{{ asset('storage/' . $reportDamage->foto_kerusakan) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-900 underline mb-2 inline-block">
                               Lihat Foto: {{ basename($reportDamage->foto_kerusakan) }}
                            </a>
                            <img src="{{ asset('storage/' . $reportDamage->foto_kerusakan) }}"
                                 alt="Foto Kerusakan"
                                 class="max-w-full h-auto rounded border"
                                 style="max-height: 400px;">
                        </div>
                    @else
                        <p class="text-gray-900">Tidak ada foto</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Tanggal Lapor</label>
                    <p class="text-gray-900">{{ $reportDamage->tanggal_lapor->format('d F Y H:i') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Kondisi Aset Saat Ini</label>
                    <p class="text-gray-900">
                        <span class="px-2 py-1 rounded-full 
                            @if($reportDamage->asset->kondisi == 'baik') bg-green-100 text-green-800
                            @elseif($reportDamage->asset->kondisi == 'rusak_ringan') bg-yellow-100 text-yellow-800
                            @elseif($reportDamage->asset->kondisi == 'rusak_berat') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $reportDamage->asset->kondisi)) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Verifikasi Laporan</h2>
            
            <form action="{{ route('reportdamages.verify', $reportDamage->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="kondisi_setelah_verifikasi" class="block text-gray-700 mb-2 font-semibold">Kondisi Aset Setelah Verifikasi *</label>
                    <select name="kondisi_setelah_verifikasi" id="kondisi_setelah_verifikasi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Pilih kondisi aset...</option>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                    @error('kondisi_setelah_verifikasi')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="pesan_tindak_lanjut" class="block text-gray-700 mb-2 font-semibold">Pesan Tindak Lanjut *</label>
                    <textarea name="pesan_tindak_lanjut" id="pesan_tindak_lanjut" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tulis pesan tindak lanjut untuk pelapor..." required>{{ old('pesan_tindak_lanjut') }}</textarea>
                    @error('pesan_tindak_lanjut')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('reportdamages.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                            onclick="return confirm('Anda yakin ingin memverifikasi laporan ini? Tindakan ini akan memperbarui kondisi aset.')">
                        Verifikasi Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection