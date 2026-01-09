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


      </section>


</body>

</html>