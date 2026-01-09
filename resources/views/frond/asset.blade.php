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
                                          src="{{ $asset->image ?? '/images/thumbnails/thumbnails-1.png' }}"
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

</body>

</html>