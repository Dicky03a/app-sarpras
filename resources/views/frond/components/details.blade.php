@extends("layouts.index")

@section('content')
<section
      id="Details"
      class="relative max-w-[1130px] mx-auto mb-20 z-10
           mt-10 md:mt-20
           flex flex-col lg:flex-row
           gap-6 lg:gap-[30px]
           px-4 md:px-0">
      {{-- MAIN CONTENT --}}
      <div class="flex flex-col w-full rounded-[20px] border border-[#E0DEF7] p-5 md:p-[30px] gap-6 md:gap-[30px] bg-white">
            <p class="w-fit rounded-full px-4 py-1.5 bg-[#0D903A] font-bold text-sm text-[#F7F7FD]">
                  {{ $asset->kondisi == 'baik' ? 'Baik' : ($asset->kondisi == 'rusak ringan' ? 'Rusak Ringan' : 'Rusak Berat') }}
            </p>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                  <h1 class="font-extrabold text-2xl md:text-[32px] leading-tight md:leading-[44px]">
                        {{ $asset->name }}
                  </h1>

                  <div class="flex items-center gap-2">
                        <img src="/images/icons/location.svg" class="w-5 h-5 md:w-6 md:h-6" alt="icon">
                        <p class="font-semibold text-sm md:text-base">{{ $asset->lokasi }}</p>
                  </div>
            </div>

            <p class="leading-relaxed md:leading-[30px] text-sm md:text-base">
                  {{ $asset->deskripsi }}
            </p>

            <hr class="border-[#F6F5FD]">

            <h2 class="font-bold text-lg">Spesifikasi Aset</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-y-[30px]">
                  @php
                  $specs = [
                  ['icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                  </svg>','label'=>'Kode Aset','value'=>$asset->kode_aset],
                  ['icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                  </svg>','label'=>'Kategori','value'=>$asset->category->name ?? 'N/A'],
                  ['icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>','label'=>'Status','value'=>$asset->status],
                  ['icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                  </svg>','label'=>'Kondisi','value'=>$asset->kondisi],
                  ['icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                  </svg>','label'=>'Lokasi','value'=>$asset->lokasi],
                  ['icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                  </svg>','label'=>'Dibuat','value'=>$asset->created_at->format('d M Y')],
                  ];
                  @endphp

                  @foreach($specs as $item)
                  <div class="flex items-center gap-4">
                        <div class="w-8 h-8 md:w-[34px] md:h-[34px] text-[#000929]">
                              {!! $item['icon'] !!}
                        </div>
                        <div>
                              <p class="font-bold text-base md:text-lg">{{ $item['label'] }}</p>
                              <p class="text-sm">{{ $item['value'] }}</p>
                        </div>
                  </div>
                  @endforeach
            </div>

            <hr class="border-[#F6F5FD]">

            <div>
                  <h2 class="font-bold">Lokasi Aset</h2>
                  <p class="text-sm md:text-base">{{ $asset->name }}</p>
                  <p class="text-sm md:text-base">{{ $asset->lokasi }}</p>
            </div>
      </div>

      {{-- SIDEBAR --}}
      <div class="w-full lg:w-[392px] flex flex-col gap-6 lg:gap-[30px]">
            <div class="flex flex-col rounded-[20px] border border-[#E0DEF7] p-5 md:p-[30px] gap-6 bg-white">
                  <p class="font-bold text-lg md:text-xl leading-relaxed">
                        @if($asset->status === 'tersedia')
                        Aset ini <span class="text-[#0D903A]">tersedia</span> untuk dipinjam.
                        @elseif($asset->status === 'dipinjam')
                        Aset ini <span class="text-[#FF2D2D]">sedang dipinjam</span>.
                        @else
                        Aset ini <span class="text-[#FF2D2D]">rusak</span> dan tidak tersedia.
                        @endif
                  </p>

                  <hr class="border-[#F6F5FD]">

                  <div class="flex flex-col gap-4">
                        @for($i=0;$i<3;$i++)
                              <div class="flex items-center gap-3">
                              <img src="/images/icons/verify.svg" class="w-6 h-6 md:w-[30px] md:h-[30px]" alt="icon">
                              <p class="font-semibold text-sm md:text-base">
                                    {{ ['Informasi aset yang akurat','Penanganan profesional','Pemeliharaan rutin'][$i] }}
                              </p>
                  </div>
                  @endfor
            </div>

            <hr class="border-[#F6F5FD]">

            <a
                  href="{{ route('borrowings.create', $asset->id) }}"
                  class="flex items-center justify-center w-full rounded-full bg-[#000929] text-white
                             py-4 gap-3 font-semibold text-sm md:text-base">
                  <img src="/images/icons/save-add.svg" class="w-5 h-5 md:w-6 md:h-6" alt="icon">
                  Pinjam Sekarang
            </a>
      </div>

      {{-- CONTACT --}}
      <div class="flex flex-col rounded-[20px] border border-[#E0DEF7] p-5 md:p-[30px] gap-5 bg-white">
            <h2 class="font-bold">Kontak Administrator</h2>

            <div class="flex items-center justify-between gap-3">
                  <div class="flex items-center gap-4">
                        <div class="w-12 h-12 md:w-[60px] md:h-[60px] rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-7 h-7 md:w-9 md:h-9">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                              </svg>
                        </div>
                        <div>
                              <p class="font-bold">Admin Utama</p>
                              <p class="text-sm">Admin Aset</p>
                        </div>
                  </div>

                  <div class="flex gap-2">
                        <img src="/images/icons/call-green.svg" class="w-8 h-8 md:w-10 md:h-10" alt="">
                        <img src="/images/icons/chat-green.svg" class="w-8 h-8 md:w-10 md:h-10" alt="">
                  </div>
            </div>
      </div>
      </div>
</section>
@endsection