@extends('layouts.index')

@section('content')


<header class="flex flex-col w-full">
      <section id="Hero-Banner" class="relative flex h-[720px] -mb-[93px]">
            <div id="Hero-Text" class="relative flex flex-col w-full max-w-[650px] h-fit rounded-[30px] border border-[#E0DEF7] p-10 gap-[30px] bg-white mt-[70px] ml-[calc((100%-1130px)/2)] z-10">
                  <div class="flex items-center w-fit rounded-full py-2 px-4 gap-[10px] bg-[#000929]">
                        <img src="/images/icons/crown-white.svg" class="w-5 h-5" alt="icon">
                        <span class="font-semibold text-white">We’ve won top productivity 500 fortunes</span>
                  </div>
                  <h1 class="font-extrabold text-[50px] leading-[60px]">All Great Offices.<br>Grow Your Business.</h1>
                  <p class="text-lg leading-8 text-[#000929]">Kantor yang tepat dapat memberikan impact pekerjaan menjadi lebih baik dan sehat dalam tumbuhkan karir.</p>
                  <div class="flex items-center gap-5">
                        <a href="#" class="flex items-center rounded-full p-[20px_26px] gap-3 bg-[#0D903A]">
                              <img src="/images/icons/slider-horizontal-white.svg" class="w-[30px] h-[30px]" alt="icon">
                              <span class="font-bold text-xl leading-[30px] text-[#F7F7FD]">Explore Now</span>
                        </a>
                        <a href="#" class="flex items-center rounded-full border border-[#000929] p-[20px_26px] gap-3 bg-white">
                              <img src="/images/icons/video-octagon.svg" class="w-[30px] h-[30px]" alt="icon">
                              <span class="font-semibold text-xl leading-[30px]">Watch Story</span>
                        </a>
                  </div>
            </div>
            <div id="Hero-Image" class="absolute right-0 w-[calc(100%-((100%-1130px)/2)-305px)] h-[720px] rounded-bl-[40px] overflow-hidden">
                  <img src="/images/backgrounds/banner.webp" class="w-full h-full object-cover" alt="hero background">
            </div>
      </section>
      <div class="flex flex-col pt-[150px] pb-10 px-[120px] gap-10 bg-[#0D903A]">
            <div class="logo-contianer flex items-center justify-center flex-wrap max-w-[1130px] h-[38px] mx-auto gap-[60px]">
                  <img src="/images/logos/TESLA.svg" alt="clients logo">
                  <img src="/images/logos/Libra 2.svg" alt="clients logo">
                  <img src="/images/logos/Binance logo.svg" alt="clients logo">
                  <img src="/images/logos/Facebook 7.svg" alt="clients logo">
                  <img src="/images/logos/Microsoft 6.svg" alt="clients logo">
            </div>
            <div class="flex justify-center gap-[50px]">
                  <div class="flex flex-col gap-[2px] text-center">
                        <p class="text-xl leading-[30px] text-[#F7F7FD]">Comfortable Space</p>
                        <p class="font-bold text-[38px] leading-[57px] text-white">580M+</p>
                  </div>
                  <div class="flex flex-col gap-[2px] text-center">
                        <p class="text-xl leading-[30px] text-[#F7F7FD]">Startups Succeed</p>
                        <p class="font-bold text-[38px] leading-[57px] text-white">98%</p>
                  </div>
                  <div class="flex flex-col gap-[2px] text-center">
                        <p class="text-xl leading-[30px] text-[#F7F7FD]">Countries</p>
                        <p class="font-bold text-[38px] leading-[57px] text-white">90+</p>
                  </div>
                  <div class="flex flex-col gap-[2px] text-center">
                        <p class="text-xl leading-[30px] text-[#F7F7FD]">Supportive Events</p>
                        <p class="font-bold text-[38px] leading-[57px] text-white">139M+</p>
                  </div>
            </div>
      </div>
</header>
<section id="Benefits" class="flex items-center justify-center w-[1015px] mx-auto gap-[100px] mt-[100px]">
      <h2 class="font-bold text-[32px] leading-[48px] text-nowrap">We Might Good <br>For Your Business</h2>
      <div class="grid grid-cols-2 gap-[30px]">
            <div class="flex items-center gap-4">
                  <div class="flex items-center justify-center shrink-0 w-[70px] h-[70px] rounded-[23px] bg-white overflow-hidden">
                        <img src="/images/icons/security-user.svg" class="w-[34px] h-[34px]" alt="icon">
                  </div>
                  <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-lg leading-[27px]">Privacy-First Design</p>
                        <p class="text-sm leading-[24px]">Lorem available without even higher tax that cost much</p>
                  </div>
            </div>
            <div class="flex items-center gap-4">
                  <div class="flex items-center justify-center shrink-0 w-[70px] h-[70px] rounded-[23px] bg-white overflow-hidden">
                        <img src="/images/icons/group.svg" class="w-[34px] h-[34px]" alt="icon">
                  </div>
                  <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-lg leading-[27px]">Easy Move Access</p>
                        <p class="text-sm leading-[24px]">Lorem available without even higher tax that cost much</p>
                  </div>
            </div>
            <div class="flex items-center gap-4">
                  <div class="flex items-center justify-center shrink-0 w-[70px] h-[70px] rounded-[23px] bg-white overflow-hidden">
                        <img src="/images/icons/3dcube.svg" class="w-[34px] h-[34px]" alt="icon">
                  </div>
                  <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-lg leading-[27px]">Flexibility Spaces</p>
                        <p class="text-sm leading-[24px]">Lorem available without even higher tax that cost much</p>
                  </div>
            </div>
            <div class="flex items-center gap-4">
                  <div class="flex items-center justify-center shrink-0 w-[70px] h-[70px] rounded-[23px] bg-white overflow-hidden">
                        <img src="/images/icons/cup.svg" class="w-[34px] h-[34px]" alt="icon">
                  </div>
                  <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-lg leading-[27px]">Top-Rated Office</p>
                        <p class="text-sm leading-[24px]">Lorem available without even higher tax that cost much</p>
                  </div>
            </div>
            <div class="flex items-center gap-4">
                  <div class="flex items-center justify-center shrink-0 w-[70px] h-[70px] rounded-[23px] bg-white overflow-hidden">
                        <img src="/images/icons/coffee.svg" class="w-[34px] h-[34px]" alt="icon">
                  </div>
                  <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-lg leading-[27px]">Extra Snacks Available</p>
                        <p class="text-sm leading-[24px]">Lorem available without even higher tax that cost much</p>
                  </div>
            </div>
            <div class="flex items-center gap-4">
                  <div class="flex items-center justify-center shrink-0 w-[70px] h-[70px] rounded-[23px] bg-white overflow-hidden">
                        <img src="/images/icons/home-trend-up.svg" class="w-[34px] h-[34px]" alt="icon">
                  </div>
                  <div class="flex flex-col gap-[5px]">
                        <p class="font-bold text-lg leading-[27px]">Sustain for Business</p>
                        <p class="text-sm leading-[24px]">Lorem available without even higher tax that cost much</p>
                  </div>
            </div>
      </div>
</section>



<section id="Cities" class="flex flex-col gap-8 mt-24">
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

      <div class="swiper w-full mt-8 px-6">
            <div class="swiper-wrapper flex gap-6 justify-center" id="assetsContainer">
                  @foreach($assets as $asset)
                  <div class="swiper-slide asset-item" data-category="{{ $asset->category_id }}">
                        <a href="{{ route('asset.show', $asset->slug) }}" class="card block rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                              <div class="relative w-[230px] h-[300px]">
                                    <img src="/images/thumbnails/thumbnails-2.png" class="absolute w-full h-full object-cover" alt="{{ $asset->name }}">
                                    <div class="absolute bottom-0 w-full p-5 bg-gradient-to-t from-black/80 via-black/20 to-transparent text-white flex flex-col gap-1">
                                          <h3 class="font-bold text-lg">{{ $asset->name }}</h3>
                                          <p class="text-sm">{{ $asset->kode_aset }}</p>
                                          <p class="text-sm font-semibold">{{ $asset->category->name ?? 'N/A' }}</p>
                                    </div>
                              </div>
                        </a>
                  </div>
                  @endforeach
            </div>
      </div>

</section>

<section id="Fresh-Space" class="flex flex-col gap-[30px] w-full max-w-[1130px] mx-auto mt-[100px] mb-[120px]">
      <h2 class="font-bold text-[32px] leading-[48px] text-nowrap text-center">Browse Our Fresh Space.<br>For Your Better Productivity.</h2>
      <div class="grid grid-cols-3 gap-[30px]">
            @forelse($assets as $asset)
            <a href="{{ route('asset.show', $asset->slug) }}" class="card">
                  <div class="flex flex-col rounded-[20px] border border-[#E0DEF7] bg-white overflow-hidden">
                        <div class="thumbnail-container relative w-full h-[200px]">
                              <p class="absolute top-5 left-5 w-fit rounded-full p-[6px_16px] bg-[#0D903A] font-bold text-sm leading-[21px] text-[#F7F7FD]">
                                    {{ $asset->kondisi == 'baik' ? 'Baik' : ($asset->kondisi == 'rusak ringan' ? 'Rusak Ringan' : 'Rusak Berat') }}
                              </p>
                              <img src="{{ $asset->image ?? '/images/thumbnails/thumbnails-1.png' }}" class="w-full h-full object-cover" alt="{{ $asset->name }}">
                        </div>
                        <div class="card-detail-container flex flex-col p-5 pb-[30px] gap-4">
                              <h3 class="line-clamp-2 font-bold text-[22px] leading-[36px] h-[72px]">{{ $asset->name }}</h3>
                              <div class="flex items-center justify-between">
                                    <p class="font-semibold text-xl leading-[30px]">{{ $asset->kode_aset }}</p>
                                    <div class="flex items-center justify-end gap-[6px]">
                                          <p class="font-semibold">{{ $asset->category->name ?? 'N/A' }}</p>
                                          <img src="/images/icons/clock.svg" class="w-6 h-6" alt="icon">
                                    </div>
                              </div>
                              <hr class="border-[#F6F5FD]">
                              <div class="flex items-center justify-between">
                                    <div class="flex items-center justify-end gap-[6px]">
                                          <img src="/images/icons/location.svg" class="w-6 h-6" alt="icon">
                                          <p class="font-semibold">{{ $asset->lokasi }}</p>
                                    </div>
                                    <div class="flex items-center justify-end gap-[6px]">
                                          <p class="font-semibold">{{ $asset->status }}</p>
                                          <img src="/images/icons/Star 1.svg" class="w-6 h-6" alt="icon">
                                    </div>
                              </div>
                              <hr class="border-[#F6F5FD]">
                              <div class="flex items-center justify-between">
                                    <div class="flex items-center justify-end gap-[6px]">
                                          <img src="/images/icons/wifi.svg" class="w-6 h-6" alt="icon">
                                          <p class="font-semibold">{{ $asset->status }}</p>
                                    </div>
                                    <div class="flex items-center justify-end gap-[6px]">
                                          <img src="/images/icons/security-user.svg" class="w-6 h-6" alt="icon">
                                          <p class="font-semibold">{{ $asset->kondisi }}</p>
                                    </div>
                              </div>
                        </div>
                  </div>
            </a>
            @empty
            <div class="col-span-3 text-center py-10">
                  <p class="text-xl font-semibold">Tidak ada aset tersedia saat ini.</p>
            </div>
            @endforelse
      </div>
</section>

<script>
      document.addEventListener('DOMContentLoaded', function() {
            const categoryFilter = document.getElementById('categoryFilter');
            const assetItems = document.querySelectorAll('.asset-item');

            categoryFilter.addEventListener('change', function() {
                  const selectedCategoryId = this.value;

                  assetItems.forEach(item => {
                        item.style.display = (selectedCategoryId === '' || item.getAttribute('data-category') == selectedCategoryId) ?
                              'block' :
                              'none';
                  });
            });
      });
</script>



@endsection