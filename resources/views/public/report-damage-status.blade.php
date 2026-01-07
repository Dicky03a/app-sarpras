@extends('layouts.index')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Status Laporan Kerusakan</h1>
            <p class="text-gray-600 dark:text-gray-300">Cek status laporan kerusakan aset Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Cari Laporan Kerusakan</h2>
            
            <form method="GET" action="{{ route('public.report.damage.status') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="report_id" class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">ID Laporan *</label>
                        <input type="text" name="report_id" id="report_id"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Masukkan ID laporan" required value="{{ request('report_id') }}">
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Email *</label>
                        <input type="email" name="email" id="email"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Masukkan email Anda" required value="{{ request('email') }}">
                    </div>
                </div>

                <div class="flex items-center justify-center mt-6">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Cek Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Report Status Display -->
        @if($reportDamage)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Detail Laporan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">ID Laporan</label>
                    <p class="text-gray-900 dark:text-white">#{{ $reportDamage->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Status</label>
                    <p class="text-gray-900 dark:text-white">
                        <span class="px-2 py-1 rounded-full 
                            @if($reportDamage->status == 'menunggu_verifikasi') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100
                            @elseif($reportDamage->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100
                            @endif">
                            @if($reportDamage->status == 'menunggu_verifikasi') Menunggu Verifikasi
                            @elseif($reportDamage->status == 'selesai') Selesai
                            @endif
                        </span>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Aset</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->asset->name ?? 'N/A' }} ({{ $reportDamage->asset->kode_aset ?? 'N/A' }})</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Pelapor</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->user->name ?? $reportDamage->user->email ?? 'N/A' }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Deskripsi Kerusakan</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->deskripsi_kerusakan }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Tanggal Lapor</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->tanggal_lapor->format('d F Y H:i') }}</p>
                </div>
            </div>

            <!-- Photo Section -->
            @if($reportDamage->foto_kerusakan)
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Foto Kerusakan</label>
                <div class="flex flex-col">
                    <a href="{{ asset('storage/' . $reportDamage->foto_kerusakan) }}"
                       target="_blank"
                       class="text-blue-600 hover:text-blue-900 underline mb-2 inline-block dark:text-blue-400 dark:hover:text-blue-300">
                       Lihat Foto: {{ basename($reportDamage->foto_kerusakan) }}
                    </a>
                    <img src="{{ asset('storage/' . $reportDamage->foto_kerusakan) }}"
                         alt="Foto Kerusakan"
                         class="max-w-full h-auto rounded border dark:border-gray-700"
                         style="max-height: 400px;">
                </div>
            </div>
            @endif

            <!-- Verification Information (only show if verified) -->
            @if($reportDamage->status == 'selesai')
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3">Hasil Verifikasi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Kondisi Aset Terbaru</label>
                        <p class="text-gray-900 dark:text-white">
                            <span class="px-2 py-1 rounded-full 
                                @if($reportDamage->kondisi_setelah_verifikasi == 'baik') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100
                                @elseif($reportDamage->kondisi_setelah_verifikasi == 'rusak_ringan') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100
                                @elseif($reportDamage->kondisi_setelah_verifikasi == 'rusak_berat') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $reportDamage->kondisi_setelah_verifikasi)) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Tanggal Verifikasi</label>
                        <p class="text-gray-900 dark:text-white">{{ $reportDamage->tanggal_verifikasi ? $reportDamage->tanggal_verifikasi->format('d F Y H:i') : 'N/A' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Pesan Tindak Lanjut</label>
                        <p class="text-gray-900 dark:text-white">{{ $reportDamage->pesan_tindak_lanjut }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border border-yellow-200 dark:border-yellow-800">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Status Laporan</h3>
                <p class="text-gray-900 dark:text-white">Laporan Anda sedang menunggu verifikasi oleh admin. Silakan cek kembali nanti untuk informasi terbaru.</p>
            </div>
            @endif
        </div>
        @elseif(request()->has('report_id') && request()->has('email'))
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-center py-8">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Laporan Tidak Ditemukan</h3>
                <p class="text-gray-500 dark:text-gray-400">Laporan dengan ID dan email yang Anda masukkan tidak ditemukan. Pastikan data yang Anda masukkan benar.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection