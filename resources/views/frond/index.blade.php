@extends('layouts.index')

@section('content')

<!-- NAVBAR -->
<nav class="bg-white/98 backdrop-blur-lg border-b border-gray-100 sticky top-0 z-50 shadow-sm" x-data="{ open: false }">
      <div class="flex items-center justify-between w-full max-w-7xl py-4 mx-auto px-6 lg:px-8">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                  <div class="relative">
                        <div class="absolute inset-0 bg-green-500/20 blur-xl rounded-full"></div>
                        <img src="{{ asset('images/logo-unugiri.png') }}" alt="Logo" class="relative w-11 h-11 object-contain">
                  </div>
                  <div class="flex flex-col">
                        <h2 class="font-bold text-xl text-green-600 leading-tight">Sarpras</h2>
                        <span class="text-[10px] text-gray-500 font-medium tracking-wide">Asset Management System</span>
                  </div>
            </div>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex items-center gap-8 font-medium text-gray-700">
                  <li>
                        <a href="#header" class="relative py-2 transition-all hover:text-green-600 group">
                              Home
                              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-500 to-green-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                  </li>
                  <li>
                        <a href="#Cities" class="relative py-2 transition-all hover:text-green-600 group">
                              Categories
                              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-500 to-green-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                  </li>
                  <li>
                        <a href="#Fresh-Space" class="relative py-2 transition-all hover:text-green-600 group">
                              Assets
                              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-500 to-green-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                  </li>
                  <li>
                        <form action="{{ route('assets.search') }}" method="GET" class="relative">
                              <input
                                    type="text"
                                    name="q"
                                    placeholder="Cari aset..."
                                    class="pl-4 pr-10 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-64"
                              >
                              <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                              </button>
                        </form>
                  </li>
            </ul>

            <!-- Desktop Auth Button -->
            <div class="hidden md:flex">
                  @auth
                  <a href="{{ getDashboardRedirect() }}"
                        class="flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full py-2.5 px-6 font-semibold hover:shadow-lg hover:shadow-green-500/50 transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                  </a>
                  @else
                  <a href="{{ route('login') }}"
                        class="flex items-center gap-2 border-2 border-green-600 text-green-600 rounded-full py-2.5 px-6 font-semibold hover:bg-green-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Sign In
                  </a>
                  @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button @click="open = !open"
                  class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors">
                  <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!open">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  </svg>
                  <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="open" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
            </button>
      </div>

      <!-- Mobile Menu -->
      <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden bg-white border-t border-gray-100 shadow-lg"
            style="display: none;">
            <div class="px-6 py-4 space-y-1">
                  <a href="#header" class="block py-3 px-4 font-medium text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-600 transition-colors">Home</a>
                  <a href="#Cities" class="block py-3 px-4 font-medium text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-600 transition-colors">Categories</a>
                  <a href="#Fresh-Space" class="block py-3 px-4 font-medium text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-600 transition-colors">Assets</a>

                  <div class="pt-4 border-t border-gray-200 mt-4">
                        @auth
                        <a href="{{ getDashboardRedirect() }}"
                              class="flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full py-3 font-semibold shadow-md">
                              Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                              class="flex items-center justify-center gap-2 border-2 border-green-600 text-green-600 rounded-full py-3 font-semibold hover:bg-green-600 hover:text-white transition-colors">
                              Sign In
                        </a>
                        @endauth
                  </div>
            </div>
      </div>
</nav>

<!-- HERO SECTION -->
<header id="header" class="flex flex-col w-full">

      <!-- HERO -->
      <section id="Hero-Banner"
            class="relative flex flex-col md:flex-row min-h-[720px] md:-mb-[93px]">

            <!-- TEXT -->
            <div id="Hero-Text"
                  class="relative flex flex-col w-full
            md:max-w-[650px]
            h-fit
            rounded-[24px] md:rounded-[30px]
            border border-[#E0DEF7]
            p-6 md:p-10
            gap-6 md:gap-[30px]
            bg-white
            mt-6 md:mt-[70px]

            mx-4
            md:mx-8
            lg:ml-[calc((100%-1130px)/2)] lg:mr-0

            z-10">


                  <div class="flex items-center w-fit rounded-full py-2 px-4 gap-2 bg-[#000929]">
                        <img src="/images/icons/crown-white.svg" class="w-4 h-4 md:w-5 md:h-5" alt="icon">
                        <span class="text-sm md:text-base font-semibold text-white">
                              Dukung Aktivitas Lebih Optimal.
                        </span>
                  </div>

                  <h1 class="font-extrabold text-[32px] md:text-[50px] leading-tight md:leading-[60px]">
                        SIM Pengajuan<br>Izin Aset
                  </h1>

                  <p class="text-base md:text-lg leading-7 md:leading-8 text-[#000929]">
                        Sarana dan prasarana yang terkelola dengan baik mendukung produktivitas, kenyamanan, dan keberlanjutan aktivitas dalam satu sistem yang terintegrasi.
                  </p>

                  <!-- BUTTON -->
                  <div class="flex flex-col sm:flex-row gap-4 sm:gap-5">
                        <a href="#Fresh-Space"
                              class="flex items-center justify-center rounded-full px-6 py-4 gap-3 bg-[#0D903A]">
                              <img src="/images/icons/slider-horizontal-white.svg" class="w-6 h-6" alt="icon">
                              <span class="font-bold text-lg md:text-xl text-[#F7F7FD]">
                                    Explore Now
                              </span>
                        </a>

                        <a href="{{ route('dashboard') }}"
                              class="flex items-center justify-center rounded-full border border-[#000929] px-6 py-4 gap-3 bg-white">
                              <img src="/images/icons/video-octagon.svg" class="w-6 h-6" alt="icon">
                              <span class="font-semibold text-lg md:text-xl">
                                    Watch Story
                              </span>
                        </a>
                  </div>
            </div>

            <!-- IMAGE -->
            <div id="Hero-Image"
                  class="relative md:absolute right-0 w-full md:w-[calc(100%-((100%-1130px)/2)-305px)]
                   h-[300px] md:h-[720px]
                   md:rounded-bl-[40px] overflow-hidden mt-6 md:mt-0">
                  <img src="{{ asset('images/Arusgiri.com.jpg') }}"
                        class="w-full h-full object-cover" alt="hero background">
            </div>
      </section>

      <!-- STATS -->
      <div
            class="flex flex-col pt-20 md:pt-[150px] pb-10 px-6 md:px-[120px]
               gap-10 bg-[#0D903A]">
            <!-- COUNTER -->
            <div class="grid grid-cols-2 md:flex md:justify-center gap-6 md:gap-[50px]">
                  <div class="text-center ">
                        <p class="text-sm md:text-xl text-[#F7F7FD]">Total Gedung</p>
                        <p class="font-bold text-2xl mt-4 md:text-[38px] text-white">5</p>
                  </div>
                  <div class="text-center">
                        <p class="text-sm md:text-xl text-[#F7F7FD]">Kelas</p>
                        <p class="font-bold text-2xl mt-4 md:text-[38px] text-white">98</p>
                  </div>
                  <div class="text-center">
                        <p class="text-sm md:text-xl text-[#F7F7FD]">Barang</p>
                        <p class="font-bold text-2xl mt-4 md:text-[38px] text-white">9+</p>
                  </div>
                  <div class="text-center">
                        <p class="text-sm md:text-xl text-[#F7F7FD]">Transportasi</p>
                        <p class="font-bold text-2xl mt-4 md:text-[38px] text-white">13</p>
                  </div>
            </div>
      </div>

</header>

<!-- BENEFITS SECTION -->
<section id="Benefits" class="py-20 md:py-28 bg-white">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                  <div class="inline-block mb-4">
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">Keunggulan Kami</span>
                  </div>
                  <h2 class="font-bold text-3xl md:text-5xl leading-tight bg-gradient-to-r from-gray-900 to-green-600 bg-clip-text text-transparent mb-4">
                        Solusi Terbaik untuk<br>Pengelolaan Aset
                  </h2>
                  <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                        Platform yang dirancang untuk memudahkan pengelolaan sarana dan prasarana dengan fitur-fitur unggulan
                  </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                  <!-- Benefit Card 1 -->
                  <div class="group p-6 bg-white rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                              </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Keamanan Terjamin</h3>
                        <p class="text-gray-600 leading-relaxed">Data dikelola dengan sistem keamanan berlapis dan akses yang terkontrol dengan baik.</p>
                  </div>

                  <!-- Benefit Card 2 -->
                  <div class="group p-6 bg-white rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                              </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Akses Mudah</h3>
                        <p class="text-gray-600 leading-relaxed">Dapat diakses kapan saja dan dimana saja dengan tampilan yang responsif dan user-friendly.</p>
                  </div>

                  <!-- Benefit Card 3 -->
                  <div class="group p-6 bg-white rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z" />
                              </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Fleksibilitas Tinggi</h3>
                        <p class="text-gray-600 leading-relaxed">Mendukung berbagai jenis aset sesuai dengan kebutuhan organisasi Anda.</p>
                  </div>

                  <!-- Benefit Card 4 -->
                  <div class="group p-6 bg-white rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                              </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Standar Terbaik</h3>
                        <p class="text-gray-600 leading-relaxed">Pengelolaan dilakukan sesuai dengan standar administrasi dan best practices.</p>
                  </div>

                  <!-- Benefit Card 5 -->
                  <div class="group p-6 bg-white rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                              </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Inventaris Lengkap</h3>
                        <p class="text-gray-600 leading-relaxed">Mendukung pencatatan dan tracking inventaris secara detail dan terorganisir.</p>
                  </div>

                  <!-- Benefit Card 6 -->
                  <div class="group p-6 bg-white rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                              </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2 text-gray-900">Berkelanjutan</h3>
                        <p class="text-gray-600 leading-relaxed">Membantu mengoptimalkan penggunaan aset untuk jangka panjang dan berkelanjutan.</p>
                  </div>
            </div>
      </div>
</section>

<!-- CATEGORIES SECTION -->
<section id="Cities" class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
                  <div>
                        <div class="inline-block mb-3">
                              <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">Kategori Aset</span>
                        </div>
                        <h2 class="font-bold text-3xl md:text-5xl leading-tight text-gray-900">
                              Jelajahi Berdasarkan<br>Kategori
                        </h2>
                  </div>

                  <div class="relative w-full md:w-auto min-w-[280px]">
                        <select id="categoryFilter"
                              class="w-full rounded-2xl py-4 px-6 pr-12 bg-white font-semibold shadow-lg border-2 border-gray-100 appearance-none cursor-pointer transition-all duration-300 hover:shadow-xl hover:border-green-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                              <option value="">Semua Kategori</option>
                              @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                              </svg>
                        </div>
                  </div>
            </div>

            <div id="assetsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                  @foreach($assets as $asset)
                  <div class="asset-item group" data-category="{{ $asset->category_id }}">
                        <a href="{{ route('asset.show', $asset->slug) }}"
                              class="block bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-green-200">
                              <div class="relative h-64 overflow-hidden">
                                    <img src="{{ $asset->photo ? asset('storage/' . $asset->photo) : '/images/thumbnails/thumbnails-1.png' }}"
                                          class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                          alt="{{ $asset->name }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                                          <h3 class="font-bold text-lg mb-1 line-clamp-2">{{ $asset->name }}</h3>
                                          <p class="text-sm text-gray-200 mb-2">{{ $asset->kode_aset }}</p>
                                          <span class="inline-block bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ $asset->category->name ?? 'N/A' }}
                                          </span>
                                    </div>
                              </div>
                        </a>
                  </div>
                  @endforeach
            </div>
      </div>
</section>

<!-- ASSETS SHOWCASE SECTION -->
<section id="Fresh-Space" class="py-20 md:py-28 bg-white">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                  <div class="inline-block mb-4">
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">Koleksi Aset</span>
                  </div>
                  <h2 class="font-bold text-3xl md:text-5xl leading-tight bg-gradient-to-r from-gray-900 to-blue-600 bg-clip-text text-transparent mb-4">
                        Temukan Aset yang<br>Anda Butuhkan
                  </h2>
                  <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                        Jelajahi koleksi lengkap sarana dan prasarana dengan informasi detail dan terkini
                  </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                  @forelse($assets as $asset)
                  <a href="{{ route('asset.show', $asset->slug) }}"
                        class="card group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 hover:border-blue-200">

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
                  @empty
                  <div class="col-span-full text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-xl font-semibold text-gray-600">Tidak ada aset tersedia saat ini</p>
                        <p class="text-gray-500 mt-2">Silakan coba lagi nanti atau hubungi administrator</p>
                  </div>
                  @endforelse
            </div>
      </div>
</section>

<!-- FOOTER -->
<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white">
      <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

                  <!-- Company Info -->
                  <div class="lg:col-span-2">
                        <div class="flex items-center gap-3 mb-6">
                              <div class="relative">
                                    <div class="absolute inset-0 bg-green-500/30 blur-xl rounded-full"></div>
                                    <img src="{{ asset('images/logo-unugiri.png') }}" alt="Logo" class="relative w-12 h-12">
                              </div>
                              <div>
                                    <h2 class="font-bold text-2xl text-white">Sarpras</h2>
                                    <p class="text-xs text-gray-400">Asset Management System</p>
                              </div>
                        </div>
                        <p class="text-gray-300 mb-6 leading-relaxed max-w-md">
                              Platform manajemen sarana dan prasarana yang modern dan terintegrasi untuk mendukung produktivitas, kenyamanan, dan keberlanjutan aktivitas organisasi.
                        </p>
                        <div class="flex gap-4">
                              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-green-600 flex items-center justify-center transition-all duration-300 hover:scale-110">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                              </a>
                              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-pink-600 flex items-center justify-center transition-all duration-300 hover:scale-110">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                          <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                              </a>
                              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-400 flex items-center justify-center transition-all duration-300 hover:scale-110">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                          <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                              </a>
                        </div>
                  </div>

                  <!-- Quick Links -->
                  <div>
                        <h3 class="text-lg font-bold mb-6 text-white">Menu Cepat</h3>
                        <ul class="space-y-3">
                              <li>
                                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-green-400 transition-colors flex items-center gap-2 group">
                                          <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                          </svg>
                                          Beranda
                                    </a>
                              </li>
                              <li>
                                    <a href="{{ route('asset.front') }}" class="text-gray-300 hover:text-green-400 transition-colors flex items-center gap-2 group">
                                          <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                          </svg>
                                          Daftar Aset
                                    </a>
                              </li>
                              <li>
                                    <a href="{{ route('category.front') }}" class="text-gray-300 hover:text-green-400 transition-colors flex items-center gap-2 group">
                                          <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                          </svg>
                                          Kategori
                                    </a>
                              </li>
                              <li>
                                    <a href="#Benefits" class="text-gray-300 hover:text-green-400 transition-colors flex items-center gap-2 group">
                                          <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                          </svg>
                                          Tentang Kami
                                    </a>
                              </li>
                        </ul>
                  </div>

                  <!-- Contact Info -->
                  <div>
                        <h3 class="text-lg font-bold mb-6 text-white">Hubungi Kami</h3>
                        <ul class="space-y-4 text-gray-300">
                              <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 mt-1 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-sm leading-relaxed">Jl. HOS Cokroaminoto No.29, Sidorejo, Salatiga, Jawa Tengah</span>
                              </li>
                              <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-sm">(0298) 321555</span>
                              </li>
                              <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm">info@unugiri.ac.id</span>
                              </li>
                        </ul>
                  </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-700 my-8"></div>

            <!-- Copyright -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                  <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Sarpras UNUGIRI. Hak Cipta Dilindungi.
                  </p>
                  <div class="flex flex-wrap justify-center gap-6">
                        <a href="#" class="text-gray-400 hover:text-green-400 text-sm transition-colors">Kebijakan Privasi</a>
                        <a href="#" class="text-gray-400 hover:text-green-400 text-sm transition-colors">Syarat & Ketentuan</a>
                        <a href="#" class="text-gray-400 hover:text-green-400 text-sm transition-colors">FAQ</a>
                  </div>
            </div>
      </div>
</footer>

<!-- JavaScript -->
<script>
      document.addEventListener('DOMContentLoaded', function() {
            const categoryFilter = document.getElementById('categoryFilter');
            const assetItems = document.querySelectorAll('.asset-item');

            categoryFilter.addEventListener('change', function() {
                  const selectedCategory = this.value;

                  assetItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');

                        if (selectedCategory === '' || itemCategory === selectedCategory) {
                              item.classList.remove('hidden');
                              setTimeout(() => {
                                    item.style.opacity = '1';
                                    item.style.transform = 'translateY(0)';
                              }, 10);
                        } else {
                              item.style.opacity = '0';
                              item.style.transform = 'translateY(20px)';
                              setTimeout(() => {
                                    item.classList.add('hidden');
                              }, 300);
                        }
                  });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                  anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                              target.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                              });
                        }
                  });
            });

            // Add animation on scroll
            const observerOptions = {
                  threshold: 0.1,
                  rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                  entries.forEach(entry => {
                        if (entry.isIntersecting) {
                              entry.target.style.opacity = '1';
                              entry.target.style.transform = 'translateY(0)';
                        }
                  });
            }, observerOptions);

            // Observe all asset cards
            document.querySelectorAll('.card, .asset-item').forEach(card => {
                  card.style.opacity = '0';
                  card.style.transform = 'translateY(30px)';
                  card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                  observer.observe(card);
            });
      });
</script>

<style>
      .bg-grid-pattern {
            background-image:
                  linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                  linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
      }

      @keyframes fadeInUp {
            from {
                  opacity: 0;
                  transform: translateY(30px);
            }

            to {
                  opacity: 1;
                  transform: translateY(0);
            }
      }

      .asset-item {
            transition: all 0.3s ease;
      }
</style>

@endsection