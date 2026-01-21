@extends('admin.dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Asset Details</h1>
                    <p class="mt-2 text-sm text-gray-600">Complete information about this asset</p>
                </div>
                <a href="{{ route('assets.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0D903A] transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Status Banner -->
            <div class="px-6 py-4 bg-gradient-to-r from-[#0D903A] to-[#0a7a31]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-white">{{ $asset->name }}</h2>
                            <p class="text-sm text-white/80">{{ $asset->kode_aset }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($asset->status == 'tersedia') bg-green-500 text-white
                            @elseif($asset->status == 'dipinjam') bg-blue-500 text-white
                            @else bg-red-500 text-white
                            @endif">
                            {{ ucfirst($asset->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <!-- Left Column - Image -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Asset Photo</h3>
                            @if($asset->photo)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $asset->photo) }}"
                                    alt="{{ $asset->name }}"
                                    class="w-full h-64 object-cover rounded-lg border-2 border-gray-300 shadow-sm transition-transform duration-200 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-lg transition-all duration-200"></div>
                            </div>
                            @else
                            <div class="flex flex-col items-center justify-center h-64 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300">
                                <svg class="w-16 h-16 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">No photo available</p>
                            </div>
                            @endif
                        </div>

                        <!-- Quick Stats -->
                        <div class="mt-6 bg-gradient-to-br from-[#0D903A]/10 to-[#0a7a31]/10 rounded-xl p-4 border border-[#0D903A]/20">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Quick Info</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-600">Category</span>
                                    <span class="text-xs font-semibold text-gray-900">{{ $asset->category->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-600">Condition</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($asset->kondisi == 'baik') bg-green-100 text-green-800
                                        @elseif($asset->kondisi == 'rusak ringan') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($asset->kondisi) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-600">Location</span>
                                    <span class="text-xs font-semibold text-gray-900">{{ $asset->lokasi }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Section -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#0D903A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Asset ID</label>
                                <p class="text-base font-semibold text-gray-900">{{ $asset->id }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Asset Code</label>
                                <p class="text-base font-semibold text-gray-900">{{ $asset->kode_aset }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Asset Name</label>
                                <p class="text-base font-semibold text-gray-900">{{ $asset->name }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Category</label>
                                <p class="text-base font-semibold text-gray-900">{{ $asset->category->name ?? 'N/A' }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Location</label>
                                <p class="text-base font-semibold text-gray-900">{{ $asset->lokasi }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Condition</label>
                                <div class="flex items-center space-x-2">
                                    @if($asset->kondisi == 'baik')
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    @elseif($asset->kondisi == 'rusak ringan')
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($asset->kondisi == 'baik') bg-green-100 text-green-800
                                        @elseif($asset->kondisi == 'rusak ringan') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($asset->kondisi) }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Status</label>
                                <div class="flex items-center space-x-2">
                                    @if($asset->status == 'tersedia')
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    @elseif($asset->status == 'dipinjam')
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($asset->status == 'tersedia') bg-green-100 text-green-800
                                        @elseif($asset->status == 'dipinjam') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($asset->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#0D903A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Description
                        </h3>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-700 leading-relaxed">{{ $asset->deskripsi ?? 'No description available' }}</p>
                        </div>
                    </div>

                    <!-- Metadata Section -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#0D903A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Metadata
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Created At</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $asset->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-gray-500">{{ $asset->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Last Updated</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $asset->updated_at->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-gray-500">{{ $asset->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Last updated {{ $asset->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('assets.edit', $asset->id) }}"
                            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-[#0D903A] to-[#0a7a31] text-white rounded-lg text-sm font-semibold hover:from-[#0a7a31] hover:to-[#085c23] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0D903A] transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Asset
                        </a>
                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this asset? This action cannot be undone.');"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Asset
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection