@extends('layouts.index')

@section('content')

<nav
      class="bg-white border-b sticky top-0 z-50"
      x-data="{ open: false }">
      <div class="flex items-center justify-between w-full max-w-[1130px] py-[22px] mx-auto px-4">

            <!-- Logo -->
            <a href="{{ route('home') }}">
                  <img src="/images/logos/logo.svg" alt="logo" class="h-8">
            </a>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex items-center gap-[50px] font-medium">
                  <li><a href="#" class="hover:text-blue-600">Home</a></li>
                  <li><a href="#Cities" class="hover:text-blue-600">Categories</a></li>
                  <li><a href="#Fresh-Space" class="hover:text-blue-600">Aset</a></li>
            </ul>

            <!-- Desktop Auth Button -->
            <div class="hidden md:flex">
                  @auth
                  <a href="{{ getDashboardRedirect() }}"
                        class="flex items-center gap-[10px] rounded-full border border-[#000929] py-3 px-5 font-semibold">
                        Dashboard
                  </a>
                  @else
                  <a href="{{ route('login') }}"
                        class="flex items-center gap-[10px] rounded-full border border-[#000929] py-3 px-5 font-semibold">
                        Sign In
                  </a>
                  @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button @click="open = !open"
                  class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg border">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  </svg>
            </button>
      </div>x`

      <!-- Mobile Menu -->
      <div x-show="open" x-transition
            class="md:hidden bg-white border-t px-6 py-4 space-y-4">

            <a href="#" class="block font-medium">Home</a>
            <a href="#Cities" class="block font-medium">Aset</a>
            <a href="#Fresh-Space" class="block font-medium">Categories</a>

            <div class="pt-4 border-t">
                  @auth
                  <a href="{{ getDashboardRedirect() }}"
                        class="block text-center rounded-full border border-[#000929] py-3 font-semibold">
                        Dashboard
                  </a>
                  @else
                  <a href="{{ route('login') }}"
                        class="block text-center rounded-full border border-[#000929] py-3 font-semibold">
                        Sign In
                  </a>
                  @endauth
            </div>
      </div>
</nav>

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

<section
      id="Benefits"
      class="w-full max-w-[1130px]
           mx-auto
           mt-20 md:mt-[100px]
           px-4 md:px-0">

      <div
            class="flex flex-col md:flex-row
               items-center md:items-start
               gap-10 md:gap-[100px]">

            <!-- TITLE -->
            <h2
                  class="font-bold
                   text-[24px] sm:text-[28px] md:text-[32px]
                   leading-tight md:leading-[48px]
                   text-center md:text-left
                   max-w-md">
                  Solusi Terbaik untuk <br>
                  Pengelolaan Sarana dan Prasarana
            </h2>

            <!-- BENEFIT LIST -->
            <div
                  class="grid grid-cols-1 sm:grid-cols-2
                   gap-6 md:gap-[30px]
                   w-full">

                  <!-- ITEM -->
                  <div class="flex items-start gap-4">
                        <div
                              class="flex items-center justify-center
                           shrink-0
                           w-14 h-14 md:w-[70px] md:h-[70px]
                           rounded-2xl bg-white">
                              <img src="/images/icons/security-user.svg"
                                    class="w-6 h-6 md:w-[34px] md:h-[34px]">
                        </div>
                        <div class="flex flex-col gap-1">
                              <p class="font-bold text-base md:text-lg">
                                    Privacy-First Design
                              </p>
                              <p class="text-sm leading-6 text-gray-600">
                                    Data sarana, prasarana, dan pengguna dikelola dengan sistem keamanan yang terjaga dan akses yang terkontrol.
                              </p>
                        </div>
                  </div>

                  <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center shrink-0 w-14 h-14 md:w-[70px] md:h-[70px] rounded-2xl bg-white">
                              <img src="/images/icons/group.svg" class="w-6 h-6 md:w-[34px] md:h-[34px]">
                        </div>
                        <div class="flex flex-col gap-1">
                              <p class="font-bold text-base md:text-lg">Easy Move Access</p>
                              <p class="text-sm leading-6 text-gray-600">
                                    Pengelolaan sarpras dapat diakses kapan saja dan di mana saja dengan sistem yang responsif dan user-friendly.
                              </p>
                        </div>
                  </div>

                  <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center shrink-0 w-14 h-14 md:w-[70px] md:h-[70px] rounded-2xl bg-white">
                              <img src="/images/icons/3dcube.svg" class="w-6 h-6 md:w-[34px] md:h-[34px]">
                        </div>
                        <div class="flex flex-col gap-1">
                              <p class="font-bold text-base md:text-lg">Flexibility Spaces</p>
                              <p class="text-sm leading-6 text-gray-600">
                                    Mendukung berbagai jenis sarana dan prasarana sesuai kebutuhan instansi atau organisasi.
                              </p>
                        </div>
                  </div>

                  <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center shrink-0 w-14 h-14 md:w-[70px] md:h-[70px] rounded-2xl bg-white">
                              <img src="/images/icons/cup.svg" class="w-6 h-6 md:w-[34px] md:h-[34px]">
                        </div>
                        <div class="flex flex-col gap-1">
                              <p class="font-bold text-base md:text-lg">Top-Rated Office</p>
                              <p class="text-sm leading-6 text-gray-600">
                                    Pengelolaan sarpras dilakukan secara rapi, terstruktur, dan sesuai standar administrasi yang baik.
                              </p>
                        </div>
                  </div>

                  <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center shrink-0 w-14 h-14 md:w-[70px] md:h-[70px] rounded-2xl bg-white">
                              <img src="/images/icons/coffee.svg" class="w-6 h-6 md:w-[34px] md:h-[34px]">
                        </div>
                        <div class="flex flex-col gap-1">
                              <p class="font-bold text-base md:text-lg">Extra Snacks Available</p>
                              <p class="text-sm leading-6 text-gray-600">
                                    Mendukung pencatatan fasilitas tambahan seperti inventaris penunjang dan perlengkapan operasional.
                              </p>
                        </div>
                  </div>

                  <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center shrink-0 w-14 h-14 md:w-[70px] md:h-[70px] rounded-2xl bg-white">
                              <img src="/images/icons/home-trend-up.svg" class="w-6 h-6 md:w-[34px] md:h-[34px]">
                        </div>
                        <div class="flex flex-col gap-1">
                              <p class="font-bold text-base md:text-lg">Sustain for Business</p>
                              <p class="text-sm leading-6 text-gray-600">
                                    Membantu menjaga, memantau, dan mengoptimalkan penggunaan sarana dan prasarana secara berkelanjutan.
                              </p>
                        </div>
                  </div>

            </div>
      </div>
</section>

<section id="Cities" class="flex flex-col gap-8 mt-40 px-5">
      <div class="w-full max-w-[1200px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="font-bold text-3xl md:text-4xl leading-tight text-center md:text-left">
                  Category Aset<br>Pilih Sesuai Category
            </h2>
            <div class="relative w-full md:w-auto min-w-[200px]">
                  <select id="categoryFilter" class="w-full rounded-full py-3 px-5 pr-10 bg-white font-semibold shadow-md border border-gray-200 appearance-none cursor-pointer transition duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                  </select>
                  <!-- Icon panah bawah -->
                  <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                  </div>
            </div>
      </div>

      <div class="w-full max-w-[1200px] mx-auto">
            <div
                  id="assetsContainer"
                  class="flex gap-4 px-2
                        overflow-x-auto
                        snap-x snap-mandatory
                        scroll-smooth
                        sm:grid sm:grid-cols-2
                        md:grid-cols-3
                        lg:grid-cols-4
                        sm:overflow-visible
                        pb-4">
                  @foreach($assets as $asset)
                  <div
                        class="asset-item snap-center shrink-0
                              w-[220px]
                              sm:w-auto"
                        data-category="{{ $asset->category_id }}">
                        <a href="{{ route('asset.show', $asset->slug) }}"
                              class="block rounded-2xl overflow-hidden
                                    shadow-lg hover:shadow-2xl
                                    transition-all duration-300
                                    hover:scale-105">
                              <div class="relative w-full h-[280px] sm:h-[300px]">
                                    <img
                                          src="{{ $asset->photo ? asset('storage/' . $asset->photo) : '/images/thumbnails/thumbnails-1.png' }}"
                                          class="absolute w-full h-full object-cover"
                                          alt="{{ $asset->name }}">
                                    <div
                                          class="absolute bottom-0 w-full p-4
                                                bg-gradient-to-t
                                                from-black/80 via-black/40 to-transparent
                                                text-white flex flex-col gap-1">
                                          <h3 class="font-bold text-base md:text-lg line-clamp-2">
                                                {{ $asset->name }}
                                          </h3>
                                          <p class="text-xs md:text-sm text-gray-200">
                                                {{ $asset->kode_aset }}
                                          </p>
                                          <p class="text-xs md:text-sm font-semibold">
                                                {{ $asset->category->name ?? 'N/A' }}
                                          </p>
                                    </div>
                              </div>
                        </a>
                  </div>
                  @endforeach
            </div>
      </div>
</section>

<section
      id="Fresh-Space"
      class="flex flex-col gap-8 w-full max-w-[1130px]
           mx-auto mt-20 md:mt-[100px] mb-24 md:mb-[120px]">

      <!-- TITLE -->
      <h2
            class="font-bold
               text-[24px] sm:text-[28px] md:text-[32px]
               leading-tight md:leading-[48px]
               text-center px-4">
            Browse Our Fresh Space.<br>
            For Your Better Productivity.
      </h2>

      <!-- CARD LIST -->
      <div
            class="flex gap-6 px-4 m-5
               overflow-x-auto scroll-smooth
               snap-x snap-mandatory
               md:grid md:grid-cols-2 lg:grid-cols-3
               md:overflow-visible">

            @forelse($assets as $asset)
            <a
                  href="{{ route('asset.show', $asset->slug) }}"
                  class="card asset-item
                   snap-start shrink-0
                   w-[260px] sm:w-[280px]
                   md:w-auto">

                  <div
                        class="flex flex-col
                       rounded-2xl
                       border border-[#E0DEF7]
                       bg-white overflow-hidden
                       shadow-sm hover:shadow-lg
                       transition-shadow duration-300">

                        <!-- THUMBNAIL -->
                        <div class="relative w-full h-[180px] md:h-[200px]">
                              <p
                                    class="absolute top-4 left-4
                               rounded-full px-4 py-1
                               bg-[#0D903A]
                               font-bold text-xs text-[#F7F7FD]">
                                    {{ $asset->kondisi == 'baik' ? 'Baik' : ($asset->kondisi == 'rusak ringan' ? 'Rusak Ringan' : 'Rusak Berat') }}
                              </p>

                              <img
                                    src="{{ $asset->photo ? asset('storage/' . $asset->photo) : '/images/thumbnails/thumbnails-1.png' }}"
                                    class="w-full h-full object-cover"
                                    alt="{{ $asset->name }}">
                        </div>

                        <!-- DETAIL -->
                        <div class="flex flex-col p-4 md:p-5 gap-4">

                              <h3
                                    class="line-clamp-2
                               font-bold
                               text-lg md:text-[22px]
                               leading-7 md:leading-[36px]">
                                    {{ $asset->name }}
                              </h3>
                              <p class="font-semibold">{{ $asset->kode_aset }}</p>

                              <div class="flex items-center justify-between text-sm md:text-base">

                                    <div class="flex items-center">
                                          <p class="font-semibold">{{ $asset->category->name ?? 'N/A' }}</p>
                                          <img src="/images/icons/clock.svg" class="w-5 h-5">
                                    </div>
                              </div>

                              <hr class="border-[#F6F5FD]">

                              <div class="flex items-center justify-between text-sm md:text-base">
                                    <div class="flex items-center gap-1">
                                          <img src="/images/icons/location.svg" class="w-5 h-5">
                                          <p class="font-semibold">{{ $asset->lokasi }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                          <p class="font-semibold">{{ $asset->status }}</p>
                                          <img src="/images/icons/Star 1.svg" class="w-5 h-5">
                                    </div>
                              </div>

                              <hr class="border-[#F6F5FD]">

                              <div class="flex items-center justify-between text-sm md:text-base">
                                    <div class="flex items-center gap-1">
                                          <img src="/images/icons/wifi.svg" class="w-5 h-5">
                                          <p class="font-semibold">{{ $asset->status }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                          <img src="/images/icons/security-user.svg" class="w-5 h-5">
                                          <p class="font-semibold">{{ $asset->kondisi }}</p>
                                    </div>
                              </div>

                        </div>
                  </div>
            </a>
            @empty
            <div class="w-full text-center py-10">
                  <p class="text-lg font-semibold">
                        Tidak ada aset tersedia saat ini.
                  </p>
            </div>
            @endforelse

      </div>
</section>

<footer class="bg-[#0D903A] text-white mt-20">
      <div class="max-w-[1200px] mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                  <!-- Company Info -->
                  <div class="lg:col-span-2">
                        <div class="flex items-center gap-2 mb-4">
                              <img src="{{ asset('images/logo-unugiri.png') }}" alt="Logo" class="w-10 h-10">
                              <h2 class="font-bold text-2xl text-white">Sarpras</h2>
                        </div>
                        <p class="text-gray-200 mb-4">
                              Sistem Informasi Manajemen Sarana dan Prasarana yang terkelola dengan baik mendukung produktivitas, kenyamanan, dan keberlanjutan aktivitas dalam satu sistem yang terintegrasi.
                        </p>
                        <div class="flex space-x-4">
                              <a href="#" class="text-gray-200 hover:text-white transition">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                          <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                    </svg>
                              </a>
                              <a href="#" class="text-gray-200 hover:text-white transition">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                          <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                    </svg>
                              </a>
                              <a href="#" class="text-gray-200 hover:text-white transition">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                          <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                              </a>
                        </div>
                  </div>

                  <!-- Quick Links -->
                  <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                              <li><a href="{{ route('home') }}" class="text-gray-200 hover:text-white transition">Home</a></li>
                              <li><a href="{{ route('asset.front') }}" class="text-gray-200 hover:text-white transition">Aset</a></li>
                              <li><a href="{{ route('category.front') }}" class="text-gray-200 hover:text-white transition">Categories</a></li>
                        </ul>
                  </div>

                  <!-- Contact Info -->
                  <div>
                        <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                        <ul class="space-y-2 text-gray-200">
                              <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Jl. HOS Cokroaminoto No.29, Sidorejo, Salatiga, Jawa Tengah</span>
                              </li>
                              <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>(0298) 321555</span>
                              </li>
                              <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>info@unugiri.ac.id</span>
                              </li>
                        </ul>
                  </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-600 my-8"></div>

            <!-- Copyright -->
            <div class="flex flex-col md:flex-row justify-between items-center">
                  <p class="text-gray-300 text-sm">&copy; {{ date('Y') }} Sarpras. All rights reserved.</p>
                  <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-300 hover:text-white text-sm transition">Privacy Policy</a>
                        <a href="#" class="text-gray-300 hover:text-white text-sm transition">Terms of Service</a>
                        <a href="#" class="text-gray-300 hover:text-white text-sm transition">FAQ</a>
                  </div>
            </div>
      </div>
</footer>


@endsection