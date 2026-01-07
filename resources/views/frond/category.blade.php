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

      <div class="w-full mt-8">

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
                                          src="/images/thumbnails/thumbnails-2.png"
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


</body>

</html>