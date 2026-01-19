@extends('admin.dashboard')
@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('categories.index') }}"
                    class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Detail Kategori</h1>
                    <p class="text-sm text-gray-500 mt-1">Informasi lengkap kategori</p>
                </div>
            </div>
        </div>

        {{-- Detail Card --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            {{-- Card Header with Icon --}}
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $category->name }}</h2>
                        <p class="text-blue-100 text-sm mt-1">ID: {{ $category->id }}</p>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Created At --}}
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-100">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Dibuat Pada</h3>
                        </div>
                        <p class="text-gray-900 font-semibold text-lg">{{ $category->created_at->format('d M Y') }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $category->created_at->format('H:i:s') }}</p>
                        <p class="text-gray-500 text-xs mt-2">{{ $category->created_at->diffForHumans() }}</p>
                    </div>

                    {{-- Updated At --}}
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-100">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Terakhir Diubah</h3>
                        </div>
                        <p class="text-gray-900 font-semibold text-lg">{{ $category->updated_at->format('d M Y') }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $category->updated_at->format('H:i:s') }}</p>
                        <p class="text-gray-500 text-xs mt-2">{{ $category->updated_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Additional Info Section --}}
                <div class="mt-6 p-5 bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border border-gray-200">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Informasi Tambahan</h3>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Status</p>
                            <p class="text-gray-900 font-medium mt-1">
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    Aktif
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Total Hari</p>
                            <p class="text-gray-900 font-medium mt-1">{{ $category->created_at->diffInDays(now()) }} hari</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Nama Kategori</p>
                            <p class="text-gray-900 font-medium mt-1 truncate">{{ $category->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Footer with Actions --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">ID Kategori:</span> {{ $category->id }}
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-amber-500/30 transition-all duration-200 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Kategori
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="w-full sm:w-auto"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-red-500/30 transition-all duration-200 active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Kategori
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection