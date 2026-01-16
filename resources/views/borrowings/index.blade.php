{{-- BORROWINGS INDEX PAGE --}}
@extends('admin.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-6 md:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Manajemen Peminjaman</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola semua permintaan peminjaman aset</p>
                </div>
                <a href="{{ route('borrowings.create.direct') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#0D903A] text-white rounded-xl font-semibold hover:bg-[#0D903A]/90 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    Buat Peminjaman Baru
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 md:gap-6 mb-6 md:mb-8">
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-yellow-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-yellow-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-1">Pending</p>
                    <p class="text-xl font-bold text-yellow-600">{{ $borrowings->where('status', 'pending')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-green-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-green-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-1">Disetujui</p>
                    <p class="text-xl font-bold text-green-600">{{ $borrowings->where('status', 'disetujui')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-blue-600">
                                <path fill-rule="evenodd" d="M6 5v1H4.667a1.75 1.75 0 0 0-1.743 1.598l-.826 9.5A1.75 1.75 0 0 0 3.84 19H16.16a1.75 1.75 0 0 0 1.743-1.902l-.826-9.5A1.75 1.75 0 0 0 15.333 6H14V5a4 4 0 0 0-8 0Zm4-2.5A2.5 2.5 0 0 0 7.5 5v1h5V5A2.5 2.5 0 0 0 10 2.5ZM7.5 10a2.5 2.5 0 0 0 5 0V9h1.5v1a4 4 0 0 1-8 0V9h1.5v1Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-1">Dipinjam</p>
                    <p class="text-xl font-bold text-blue-600">{{ $borrowings->where('status', 'dipinjam')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-purple-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-purple-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-1">Selesai</p>
                    <p class="text-xl font-bold text-purple-600">{{ $borrowings->where('status', 'selesai')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-red-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-red-600">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-1">Ditolak</p>
                    <p class="text-xl font-bold text-red-600">{{ $borrowings->where('status', 'ditolak')->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden lg:block bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aset</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keperluan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($borrowings as $borrowing)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-semibold text-sm">{{ substr($borrowing->user->name ?? 'N', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $borrowing->user->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">ID: {{ $borrowing->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $borrowing->asset->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->asset->kode_aset ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs text-gray-500">Mulai:</span>
                                    <span class="font-medium">{{ $borrowing->tanggal_mulai->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-500">Selesai:</span>
                                    <span class="font-medium">{{ $borrowing->tanggal_selesai->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900 max-w-xs truncate">{{ $borrowing->keperluan }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($borrowing->status == 'pending')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 bg-yellow-600 rounded-full"></span>
                                    Pending
                                </span>
                                @elseif($borrowing->status == 'disetujui')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                    Disetujui
                                </span>
                                @elseif($borrowing->status == 'ditolak')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                    Ditolak
                                </span>
                                @elseif($borrowing->status == 'dipinjam')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Dipinjam
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 bg-purple-600 rounded-full"></span>
                                    Selesai
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $borrowing->admin->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex flex-col items-end gap-2">
                                    <a href="{{ route('borrowings.show', $borrowing->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lihat</a>

                                    @if($borrowing->status == 'pending')
                                    <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-medium text-sm">Setujui</button>
                                    </form>
                                    <a href="#" class="text-red-600 hover:text-red-800 font-medium text-sm modal-trigger"
                                        data-id="{{ $borrowing->id }}"
                                        data-name="{{ $borrowing->user->name ?? 'N/A' }}"
                                        data-asset="{{ $borrowing->asset->name ?? 'N/A' }}">Tolak</a>
                                    @elseif($borrowing->status == 'disetujui')
                                    <form action="{{ route('borrowings.markAsBorrowed', $borrowing->id) }}" method="POST" onsubmit="return confirm('Tandai sebagai dipinjam?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Tandai Dipinjam</button>
                                    </form>
                                    @elseif($borrowing->status == 'dipinjam')
                                    <form action="{{ route('borrowings.markAsReturned', $borrowing->id) }}" method="POST" onsubmit="return confirm('Tandai sudah dikembalikan?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                                        <button type="submit" class="text-purple-600 hover:text-purple-800 font-medium text-sm">Tandai Selesai</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">Belum ada peminjaman</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="lg:hidden space-y-4">
            @forelse($borrowings as $borrowing)
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-semibold">{{ substr($borrowing->user->name ?? 'N', 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 truncate">{{ $borrowing->user->name ?? 'N/A' }}</h3>
                        <p class="text-sm text-gray-600 truncate">{{ $borrowing->asset->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500 mt-1">ID: {{ $borrowing->id }}</p>
                    </div>
                    @if($borrowing->status == 'pending')
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full flex-shrink-0">
                        Pending
                    </span>
                    @elseif($borrowing->status == 'disetujui')
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full flex-shrink-0">
                        Disetujui
                    </span>
                    @elseif($borrowing->status == 'ditolak')
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full flex-shrink-0">
                        Ditolak
                    </span>
                    @elseif($borrowing->status == 'dipinjam')
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full flex-shrink-0">
                        Dipinjam
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full flex-shrink-0">
                        Selesai
                    </span>
                    @endif
                </div>

                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Periode:</span>
                        <span class="font-medium text-gray-900 text-right">{{ $borrowing->tanggal_mulai->format('d/m/Y') }} - {{ $borrowing->tanggal_selesai->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Keperluan:</span>
                        <span class="font-medium text-gray-900 text-right max-w-[60%] truncate">{{ $borrowing->keperluan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Admin:</span>
                        <span class="font-medium text-gray-900">{{ $borrowing->admin->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2 pt-3 border-t border-gray-200">
                    <a href="{{ route('borrowings.show', $borrowing->id) }}" class="w-full text-center bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2.5 px-3 rounded-lg transition text-sm">
                        Lihat Detail
                    </a>

                    @if($borrowing->status == 'pending')
                    <div class="grid grid-cols-2 gap-2">
                        <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                            <button type="submit" class="w-full bg-green-50 hover:bg-green-100 text-green-600 font-medium py-2.5 px-3 rounded-lg transition text-sm">
                                Setujui
                            </button>
                        </form>
                        <a href="#" class="w-full text-center bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2.5 px-3 rounded-lg transition text-sm modal-trigger"
                            data-id="{{ $borrowing->id }}"
                            data-name="{{ $borrowing->user->name ?? 'N/A' }}"
                            data-asset="{{ $borrowing->asset->name ?? 'N/A' }}">
                            Tolak
                        </a>
                    </div>
                    @elseif($borrowing->status == 'disetujui')
                    <form action="{{ route('borrowings.markAsBorrowed', $borrowing->id) }}" method="POST" onsubmit="return confirm('Tandai sebagai dipinjam?');">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                        <button type="submit" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2.5 px-3 rounded-lg transition text-sm">
                            Tandai Dipinjam
                        </button>
                    </form>
                    @elseif($borrowing->status == 'dipinjam')
                    <form action="{{ route('borrowings.markAsReturned', $borrowing->id) }}" method="POST" onsubmit="return confirm('Tandai sudah dikembalikan?');">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                        <button type="submit" class="w-full bg-purple-50 hover:bg-purple-100 text-purple-600 font-medium py-2.5 px-3 rounded-lg transition text-sm">
                            Tandai Selesai
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 mx-auto mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                <p class="text-gray-500 font-medium">Belum ada peminjaman</p>
                <p class="text-sm text-gray-400 mt-1">Tambahkan peminjaman pertama</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 w-11/12 max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Tolak Peminjaman</h3>
                    <button class="close-modal text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">

                    <div class="mb-4 p-4 bg-gray-50 rounded-xl">
                        <div class="mb-3">
                            <label class="block text-xs text-gray-500 mb-1">Peminjam:</label>
                            <p class="font-semibold text-gray-900" id="modalUserName"></p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Aset:</label>
                            <p class="font-semibold text-gray-900" id="modalAssetName"></p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="alasan" class="block font-semibold text-sm text-gray-700 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alasan" id="alasan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                            rows="4" placeholder="Jelaskan alasan penolakan..." required></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" class="close-modal flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition">
                            Tolak Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('rejectModal');
        const modalTriggers = document.querySelectorAll('.modal-trigger');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const rejectForm = document.getElementById('rejectForm');

        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const borrowingId = this.getAttribute('data-id');
                const userName = this.getAttribute('data-name');
                const assetName = this.getAttribute('data-asset');

                document.getElementById('modalUserName').textContent = userName;
                document.getElementById('modalAssetName').textContent = assetName;
                rejectForm.action = '/borrowings/' + borrowingId + '/reject';

                modal.classList.remove('hidden');
            });
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endsection
