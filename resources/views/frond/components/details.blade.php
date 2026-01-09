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
                  ['icon'=>'security-user','label'=>'Kode Aset','value'=>$asset->kode_aset],
                  ['icon'=>'cup','label'=>'Kategori','value'=>$asset->category->name ?? 'N/A'],
                  ['icon'=>'home-trend-up','label'=>'Status','value'=>$asset->status],
                  ['icon'=>'coffee','label'=>'Kondisi','value'=>$asset->kondisi],
                  ['icon'=>'3dcube','label'=>'Lokasi','value'=>$asset->lokasi],
                  ['icon'=>'group','label'=>'Dibuat','value'=>$asset->created_at->format('d M Y')],
                  ];
                  @endphp

                  @foreach($specs as $item)
                  <div class="flex items-center gap-4">
                        <img src="/images/icons/{{ $item['icon'] }}.svg" class="w-8 h-8 md:w-[34px] md:h-[34px]" alt="icon">
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
                        <img src="/images/photos/admin-photo-1.png"
                              class="w-12 h-12 md:w-[60px] md:h-[60px] rounded-full object-cover"
                              alt="photo">
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