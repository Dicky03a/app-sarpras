<!doctype html>
<html lang="en">

<head>
      <meta charset="UTF-8" />
      <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
      <meta http-equiv="X-UA-Compatible" content="ie=edge" />
      @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

      @include('layouts.navbar')
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

</body>

</html>