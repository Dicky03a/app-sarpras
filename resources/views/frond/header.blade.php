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
                        <img src="{{ asset('images/Arusgiri.com.jpg') }}" class="w-4 h-4 md:w-5 md:h-5" alt="icon">
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