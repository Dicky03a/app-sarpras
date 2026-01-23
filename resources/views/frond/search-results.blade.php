@extends('layouts.index')

@section('content')

<!-- SEARCH RESULTS HEADER -->
<div class="bg-gradient-to-r from-green-50 to-blue-50 py-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Hasil Pencarian untuk "<span class="text-green-600">{{ $query }}</span>"
            </h1>
            <p class="text-gray-600 text-lg">
                Menemukan {{ $assets->count() }} aset yang cocok
            </p>
        </div>
    </div>
</div>

<!-- SEARCH RESULTS CONTENT -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Filter</h3>
                    
                    <div class="space-y-6">
                        <!-- Category Filter -->
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Kategori</h4>
                            <select id="categoryFilter" class="w-full rounded-lg py-2 px-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Condition Filter -->
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Kondisi</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-green-600 mr-2 condition-filter" value="baik">
                                    <span class="text-gray-700">Baik</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-green-600 mr-2 condition-filter" value="rusak ringan">
                                    <span class="text-gray-700">Rusak Ringan</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-green-600 mr-2 condition-filter" value="rusak berat">
                                    <span class="text-gray-700">Rusak Berat</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Search Results -->
            <div class="lg:w-3/4">
                @if($assets->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($assets as $asset)
                        <a href="{{ route('asset.show', $asset->slug) }}"
                              class="card group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 hover:border-blue-200"
                              data-category-id="{{ $asset->category_id }}" data-condition="{{ $asset->kondisi }}">

                              <!-- Image Section -->
                              <div class="relative h-56 overflow-hidden">
                                    <div class="absolute top-4 left-4 z-10">
                                        <span class="px-4 py-2 rounded-full text-xs font-bold text-white shadow-lg
                                              {{ $asset->kondisi == 'baik' ? 'bg-gradient-to-r from-green-500 to-green-600' :
                                                 ($asset->kondisi == 'rusak ringan' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600' :
                                                 'bg-gradient-to-r from-red-500 to-red-600') }}">
                                              {{ $asset->kondisi == 'baik' ? 'Kondisi Baik' :
                                                 ($asset->kondisi == 'rusak ringan' ? 'Rusak Ringan' : 'Rusak Berat') }}
                                        </span>
                                    </div>

                                    <img src="{{ $asset->photo ? asset('storage/' . $asset->photo) : '/images/thumbnails/thumbnails-1.png' }}"
                                          class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                          alt="{{ $asset->name }}">

                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                              </div>

                              <!-- Content Section -->
                              <div class="p-6 space-y-4">
                                    <div>
                                        <h3 class="font-bold text-xl text-gray-900 mb-2 line-clamp-2 group-hover:text-green-400 transition-colors">
                                            {{ $asset->name }}
                                        </h3>
                                        <p class="text-sm font-mono text-gray-500 bg-gray-50 inline-block px-3 py-1 rounded-lg">
                                            {{ $asset->kode_aset }}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between py-3 border-t border-gray-100">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700">{{ $asset->category->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between py-3 border-t border-gray-100">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700">{{ $asset->lokasi }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700">{{ $asset->status }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg font-medium">
                                                {{ $asset->status }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg font-medium">
                                                {{ ucfirst($asset->kondisi) }}
                                            </span>
                                        </div>
                                    </div>
                              </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Aset tidak ditemukan</h3>
                        <p class="text-gray-600 text-lg mb-6">Tidak ada aset yang cocok dengan pencarian "{{ $query }}"</p>
                        <a href="{{ route('asset.front') }}" class="inline-block bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full py-3 px-6 font-semibold hover:shadow-lg hover:shadow-green-500/50 transition-all duration-300">
                            Jelajahi Semua Aset
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for filtering -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('categoryFilter');
    const conditionFilters = document.querySelectorAll('.condition-filter');
    const assetCards = document.querySelectorAll('.card');

    // Function to filter assets
    function filterAssets() {
        const selectedCategory = categoryFilter.value;
        const selectedConditions = Array.from(conditionFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        assetCards.forEach(card => {
            const cardCategory = card.querySelector('[data-category-id]');
            const cardCondition = card.querySelector('[data-condition]');
            
            let showCard = true;

            // Check category filter
            if (selectedCategory && cardCategory && cardCategory.dataset.categoryId !== selectedCategory) {
                showCard = false;
            }

            // Check condition filter
            if (selectedConditions.length > 0 && cardCondition && !selectedConditions.includes(cardCondition.dataset.condition)) {
                showCard = false;
            }

            if (showCard) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Add event listeners
    categoryFilter.addEventListener('change', filterAssets);
    conditionFilters.forEach(filter => {
        filter.addEventListener('change', filterAssets);
    });
});
</script>

@endsection