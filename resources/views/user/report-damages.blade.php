@extends('layouts.user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Riwayat Laporan Kerusakan Aset</h1>
            <a href="{{ route('reportdamages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Buat Laporan Baru
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($reportDamages->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada laporan kerusakan</h3>
                <p class="text-gray-500 dark:text-gray-400">Anda belum membuat laporan kerusakan aset.</p>
                <div class="mt-4">
                    <a href="{{ route('reportdamages.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aset</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kondisi Terbaru</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Lapor</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($reportDamages as $reportDamage)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    #{{ $reportDamage->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportDamage->asset->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $reportDamage->asset->kode_aset }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate" title="{{ $reportDamage->deskripsi_kerusakan }}">
                                        {{ Str::limit($reportDamage->deskripsi_kerusakan, 30) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($reportDamage->status == 'menunggu_verifikasi') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100
                                        @elseif($reportDamage->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100
                                        @endif">
                                        @if($reportDamage->status == 'menunggu_verifikasi') Menunggu Verifikasi
                                        @elseif($reportDamage->status == 'selesai') Selesai
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    @if($reportDamage->status == 'selesai')
                                        <span class="px-2 py-1 rounded-full 
                                            @if($reportDamage->kondisi_setelah_verifikasi == 'baik') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100
                                            @elseif($reportDamage->kondisi_setelah_verifikasi == 'rusak_ringan') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100
                                            @elseif($reportDamage->kondisi_setelah_verifikasi == 'rusak_berat') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $reportDamage->kondisi_setelah_verifikasi)) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $reportDamage->tanggal_lapor ? $reportDamage->tanggal_lapor->format('d M Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('user.report.damage.detail', $reportDamage->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection