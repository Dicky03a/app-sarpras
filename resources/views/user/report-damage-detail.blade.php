@extends('layouts.user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Laporan Kerusakan</h1>
            <a href="{{ route('user.report.damages') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Informasi Dasar</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Kategori Aset</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->asset->category->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Deskripsi Kerusakan</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->deskripsi_kerusakan }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Tanggal Lapor</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->tanggal_lapor->format('d F Y H:i') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Tanggal Buat</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Photo Section -->
        @if($reportDamage->foto_kerusakan)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Foto Kerusakan</h2>
            
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Hasil Verifikasi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Kondisi Aset Terbaru</label>
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

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Admin Verifikasi</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->admin->name ?? 'Admin' }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Pesan Tindak Lanjut</label>
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
                        <p class="text-gray-900 dark:text-white">{{ $reportDamage->pesan_tindak_lanjut }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Tanggal Verifikasi</label>
                    <p class="text-gray-900 dark:text-white">{{ $reportDamage->tanggal_verifikasi ? $reportDamage->tanggal_verifikasi->format('d F Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Status Timeline -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Timeline Status</h2>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                        <span class="text-xs font-bold text-yellow-800 dark:text-yellow-100">1</span>
                    </div>
                    <div class="ml-4 flex-1 border-l-2 border-gray-200 dark:border-gray-700 pl-4 pb-6">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white">Laporan Dibuat</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $reportDamage->created_at->format('d F Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Laporan kerusakan diajukan oleh Anda</p>
                    </div>
                </div>
                
                @if($reportDamage->status == 'selesai')
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                        <span class="text-xs font-bold text-green-800 dark:text-green-100">2</span>
                    </div>
                    <div class="ml-4 flex-1 border-l-2 border-green-200 dark:border-green-800 pl-4">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white">Laporan Diverifikasi</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $reportDamage->tanggal_verifikasi ? $reportDamage->tanggal_verifikasi->format('d F Y H:i') : $reportDamage->updated_at->format('d F Y H:i') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Laporan diverifikasi oleh {{ $reportDamage->admin->name ?? 'Admin' }}. 
                            Kondisi aset diperbarui menjadi "{{ ucfirst(str_replace('_', ' ', $reportDamage->kondisi_setelah_verifikasi)) }}"
                        </p>
                    </div>
                </div>
                @else
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <span class="text-xs font-bold text-blue-800 dark:text-blue-100">2</span>
                    </div>
                    <div class="ml-4 flex-1 border-l-2 border-blue-200 dark:border-blue-800 pl-4">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white">Menunggu Verifikasi</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Laporan sedang menunggu verifikasi dari admin</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection