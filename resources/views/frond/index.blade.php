@extends('layouts.index')

@section('content')


<header class="flex flex-col w-full">

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
                  <img src="/images/backgrounds/banner.webp"
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
                  We Might Good <br>
                  For Your Business
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
                                    Lorem available without even higher tax that cost much
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
                                    Lorem available without even higher tax that cost much
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
                                    Lorem available without even higher tax that cost much
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
                                    Lorem available without even higher tax that cost much
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
                                    Lorem available without even higher tax that cost much
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
                                    Lorem available without even higher tax that cost much
                              </p>
                        </div>
                  </div>

            </div>
      </div>
</section>

<section id="Cities" class="flex flex-col gap-8 mt-24 mx-5">
      <div class="w-full max-w-[1130px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="font-bold text-3xl md:text-4xl leading-tight text-center md:text-left">
                  Category Aset<br>Pilih Sesuai Category
            </h2>
            <div class="relative w-full md:w-auto">
                  <select id="categoryFilter" class="rounded-full py-3 px-5 bg-white font-semibold shadow-md border border-gray-200 appearance-none cursor-pointer transition duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
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

      <div class="w-full">

            <div
                  id="assetsContainer"
                  class="flex gap-6 px-6
               overflow-x-auto
               snap-x snap-mandatory
               scroll-smooth
               md:grid md:grid-cols-3 lg:grid-cols-4
               md:overflow-visible">

                  @foreach($assets as $asset)
                  <div
                        class="asset-item snap-start shrink-0
                   md:shrink md:w-auto"
                        data-category="{{ $asset->category_id }}">

                        <a href="{{ route('asset.show', $asset->slug) }}"
                              class="block rounded-2xl overflow-hidden
                       shadow-lg hover:shadow-2xl
                       transition-shadow duration-300">

                              <div class="relative w-[220px] sm:w-[240px] md:w-full h-[300px]">
                                    <img
                                          src="{{ $asset->photo ? asset('storage/' . $asset->photo) : '/images/thumbnails/thumbnails-1.png' }}"
                                          class="absolute w-full h-full object-cover"
                                          alt="{{ $asset->name }}">

                                    <div
                                          class="absolute bottom-0 w-full p-4
                               bg-gradient-to-t
                               from-black/80 via-black/40 to-transparent
                               text-white flex flex-col gap-1">

                                          <h3 class="font-bold text-base md:text-lg">
                                                {{ $asset->name }}
                                          </h3>

                                          <p class="text-xs md:text-sm">
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

                              <div class="flex items-center justify-between text-sm md:text-base">
                                    <p class="font-semibold">{{ $asset->kode_aset }}</p>
                                    <div class="flex items-center gap-1">
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





@endsection