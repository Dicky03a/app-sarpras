@extends('layouts.user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Pengajuan Saya</h1>
        <a href="{{ route('asset.front') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajukan Peminjaman Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($borrowingRequests->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada pengajuan</h3>
            <p class="text-gray-500 dark:text-gray-400">Anda belum membuat pengajuan peminjaman aset.</p>
            <div class="mt-4">
                <a href="{{ route('asset.front') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ajukan Peminjaman Baru
                </a>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aset</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Mulai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Selesai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keperluan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($borrowingRequests as $request)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->asset->name ?? 'Aset Tidak Ditemukan' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $request->asset->code ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($request->tanggal_selesai)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate" title="{{ $request->keperluan }}">{{ $request->keperluan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status == 'disetujui') bg-green-100 text-green-800
                                    @elseif($request->status == 'ditolak') bg-red-100 text-red-800
                                    @elseif($request->status == 'dipinjam') bg-blue-100 text-blue-800
                                    @elseif($request->status == 'selesai') bg-gray-100 text-gray-800
                                    @endif">
                                    @if($request->status == 'pending') Menunggu Persetujuan
                                    @elseif($request->status == 'disetujui') Disetujui
                                    @elseif($request->status == 'ditolak') Ditolak
                                    @elseif($request->status == 'dipinjam') Sedang Dipinjam
                                    @elseif($request->status == 'selesai') Selesai
                                    @endif
                                </span>
                                @if($request->status == 'ditolak' && $request->rejection)
                                    <div class="text-xs text-red-600 mt-1">Alasan: {{ $request->rejection->alasan }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('borrowings.show', $request->id) }}" class="text-blue-600 hover:text-blue-900">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection