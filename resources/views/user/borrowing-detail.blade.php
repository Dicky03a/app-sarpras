@extends('layouts.user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Peminjaman</h1>
            <a href="{{ route('user.requests') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">ID Peminjaman</label>
                    <p class="text-gray-900 dark:text-white">#{{ $borrowing->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Status</label>
                    <p class="text-gray-900 dark:text-white">
                        <span class="px-2 py-1 rounded-full
                            @if($borrowing->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100
                            @elseif($borrowing->status == 'disetujui') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100
                            @elseif($borrowing->status == 'ditolak') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100
                            @elseif($borrowing->status == 'dipinjam') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100
                            @elseif($borrowing->status == 'selesai') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100
                            @endif">
                            @if($borrowing->status == 'pending') Menunggu Persetujuan
                            @elseif($borrowing->status == 'disetujui') Disetujui
                            @elseif($borrowing->status == 'ditolak') Ditolak
                            @elseif($borrowing->status == 'dipinjam') Sedang Dipinjam
                            @elseif($borrowing->status == 'selesai') Selesai
                            @endif
                        </span>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Nama Tempat</label>
                    <p class="text-gray-900 dark:text-white">{{ $borrowing->asset->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Kode Tempat</label>
                    <p class="text-gray-900 dark:text-white">{{ $borrowing->asset->kode_aset ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Tanggal Mulai</label>
                    <p class="text-gray-900 dark:text-white">{{ $borrowing->tanggal_mulai->format('d F Y') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Tanggal Selesai</label>
                    <p class="text-gray-900 dark:text-white">{{ $borrowing->tanggal_selesai->format('d F Y') }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Keperluan</label>
                    <p class="text-gray-900 dark:text-white">{{ $borrowing->keperluan }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Lampiran Bukti</label>
                    @if($borrowing->lampiran_bukti)
                        <div class="flex flex-col">
                            <a href="{{ asset('storage/' . $borrowing->lampiran_bukti) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-900 underline mb-2 inline-block dark:text-blue-400 dark:hover:text-blue-300">
                               Lihat Lampiran: {{ basename($borrowing->lampiran_bukti) }}
                            </a>
                            @php
                                $fileExtension = strtolower(pathinfo($borrowing->lampiran_bukti, PATHINFO_EXTENSION));
                            @endphp
                            @if($fileExtension == 'pdf')
                                <iframe src="{{ asset('storage/' . $borrowing->lampiran_bukti) }}#toolbar=0"
                                        width="100%"
                                        height="400px"
                                        class="border rounded">
                                    Browser Anda tidak mendukung penampilan PDF.
                                </iframe>
                            @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $borrowing->lampiran_bukti) }}"
                                     alt="Lampiran Bukti"
                                     class="max-w-full h-auto rounded border"
                                     style="max-height: 400px;">
                            @else
                                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded border">
                                    <p class="text-gray-700 dark:text-gray-300">Tipe File: {{ $fileExtension }}</p>
                                    <p class="text-gray-700 dark:text-gray-300">File tidak bisa ditampilkan secara langsung. Silakan klik link untuk melihat.</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-900 dark:text-white">Tidak ada lampiran</p>
                    @endif
                </div>

                @if($borrowing->rejection)
                    <div class="mb-4 md:col-span-2 bg-red-50 dark:bg-red-900/20 p-4 rounded border border-red-200 dark:border-red-800">
                        <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Alasan Penolakan</label>
                        <p class="text-gray-900 dark:text-white">{{ $borrowing->rejection->alasan }}</p>
                    </div>
                @endif

                @if($borrowing->admin)
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Admin yang Memproses</label>
                        <p class="text-gray-900 dark:text-white">{{ $borrowing->admin->name ?? '-' }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-semibold">Tanggal Pengajuan</label>
                    <p class="text-gray-900 dark:text-white">{{ $borrowing->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Move History Section -->
        @if($borrowing->moves->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Riwayat Pemindahan Tempat</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Pemindahan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tempat Lama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tempat Baru</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alasan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Admin</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($borrowing->moves as $move)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $move->moved_at->format('d F Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $move->oldAsset->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $move->newAsset->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $move->alasan_pemindahan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $move->admin->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
                    <p class="text-blue-800 dark:text-blue-200">
                        <strong>Catatan:</strong> Peminjaman Anda telah dipindahkan ke tempat yang berbeda. 
                        Tempat yang tertera di atas adalah tempat terbaru untuk peminjaman Anda.
                    </p>
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
                            <h3 class="font-medium text-gray-900 dark:text-white">Pengajuan Diajukan</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $borrowing->created_at->format('d F Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Peminjaman diajukan oleh Anda</p>
                    </div>
                </div>
                
                @if($borrowing->status !== 'pending')
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full 
                        @if(in_array($borrowing->status, ['disetujui', 'dipinjam', 'selesai'])) bg-green-100 dark:bg-green-900 
                        @else bg-gray-100 dark:bg-gray-700 
                        @endif
                        flex items-center justify-center">
                        <span class="text-xs font-bold 
                            @if(in_array($borrowing->status, ['disetujui', 'dipinjam', 'selesai'])) text-green-800 dark:text-green-100 
                            @else text-gray-800 dark:text-gray-100 
                            @endif">2</span>
                    </div>
                    <div class="ml-4 flex-1 border-l-2 
                        @if(in_array($borrowing->status, ['disetujui', 'dipinjam', 'selesai'])) border-green-200 dark:border-green-800 
                        @else border-gray-200 dark:border-gray-700 
                        @endif
                        pl-4 pb-6">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white">
                                @if($borrowing->status == 'ditolak') Peminjaman Ditolak
                                @else Peminjaman Disetujui
                                @endif
                            </h3>
                            @if($borrowing->admin)
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                @if($borrowing->updated_at) {{ $borrowing->updated_at->format('d F Y H:i') }} @endif
                            </span>
                            @endif
                        </div>
                        @if($borrowing->admin)
                        <p class="text-sm text-gray-600 dark:text-gray-300">Diproses oleh {{ $borrowing->admin->name }}</p>
                        @endif
                    </div>
                </div>
                @endif
                
                @if($borrowing->status == 'dipinjam')
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full 
                        @if($borrowing->status == 'dipinjam' || $borrowing->status == 'selesai') bg-blue-100 dark:bg-blue-900 
                        @else bg-gray-100 dark:bg-gray-700 
                        @endif
                        flex items-center justify-center">
                        <span class="text-xs font-bold 
                            @if($borrowing->status == 'dipinjam' || $borrowing->status == 'selesai') text-blue-800 dark:text-blue-100 
                            @else text-gray-800 dark:text-gray-100 
                            @endif">3</span>
                    </div>
                    <div class="ml-4 flex-1 border-l-2 
                        @if($borrowing->status == 'dipinjam' || $borrowing->status == 'selesai') border-blue-200 dark:border-blue-800 
                        @else border-gray-200 dark:border-gray-700 
                        @endif
                        pl-4 pb-6">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white">Peminjaman Dimulai</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                @if($borrowing->updated_at) {{ $borrowing->updated_at->format('d F Y H:i') }} @endif
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Barang mulai dipinjam</p>
                    </div>
                </div>
                @endif
                
                @if($borrowing->status == 'selesai')
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                        <span class="text-xs font-bold text-purple-800 dark:text-purple-100">4</span>
                    </div>
                    <div class="ml-4 flex-1 border-l-2 border-purple-200 dark:border-purple-800 pl-4">
                        <div class="flex justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white">Peminjaman Diselesaikan</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                @if($borrowing->updated_at) {{ $borrowing->updated_at->format('d F Y H:i') }} @endif
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Barang telah dikembalikan</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection