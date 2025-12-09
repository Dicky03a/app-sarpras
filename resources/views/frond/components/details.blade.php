@extends("layouts.index")

@section('content')
<section id="Details" class="relative flex max-w-[1130px] mx-auto gap-[30px] mb-20 z-10 mt-20">
      <div class="flex flex-col w-full rounded-[20px] border border-[#E0DEF7] p-[30px] gap-[30px] bg-white">
            <p class="w-fit rounded-full p-[6px_16px] bg-[#0D903A] font-bold text-sm leading-[21px] text-[#F7F7FD]">
                  {{ $asset->kondisi == 'baik' ? 'Baik' : ($asset->kondisi == 'rusak ringan' ? 'Rusak Ringan' : 'Rusak Berat') }}
            </p>
            <div class="flex items-center justify-between">
                  <div>
                        <h1 class="font-extrabold text-[32px] leading-[44px]">{{ $asset->name }}</h1>
                  </div>
                  <div class="flex flex-col gap-[6px]">
                        <div class="flex items-center gap-1">
                              <div class="flex items-center gap-[6px] mt-[10px]">
                                    <img src="/images/icons/location.svg" class="w-6 h-6" alt="icon">
                                    <p class="font-semibold">{{ $asset->lokasi }}</p>
                              </div>
                        </div>
                  </div>
            </div>
            <p class="leading-[30px]">{{ $asset->deskripsi }}</p>
            <hr class="border-[#F6F5FD]">
            <h2 class="font-bold">Spesifikasi Aset</h2>
            <div class="grid grid-cols-3 gap-x-5 gap-y-[30px]">
                  <div class="flex items-center gap-4">
                        <img src="/images/icons/security-user.svg" class="w-[34px] h-[34px]" alt="icon">
                        <div class="flex flex-col gap-[2px]">
                              <p class="font-bold text-lg leading-[24px]">Kode Aset</p>
                              <p class="text-sm leading-[21px]">{{ $asset->kode_aset }}</p>
                        </div>
                  </div>
                  <div class="flex items-center gap-4">
                        <img src="/images/icons/cup.svg" class="w-[34px] h-[34px]" alt="icon">
                        <div class="flex flex-col gap-[2px]">
                              <p class="font-bold text-lg leading-[24px]">Kategori</p>
                              <p class="text-sm leading-[21px]">{{ $asset->category->name ?? 'N/A' }}</p>
                        </div>
                  </div>
                  <div class="flex items-center gap-4">
                        <img src="/images/icons/home-trend-up.svg" class="w-[34px] h-[34px]" alt="icon">
                        <div class="flex flex-col gap-[2px]">
                              <p class="font-bold text-lg leading-[24px]">Status</p>
                              <p class="text-sm leading-[21px]">{{ $asset->status }}</p>
                        </div>
                  </div>
                  <div class="flex items-center gap-4">
                        <img src="/images/icons/coffee.svg" class="w-[34px] h-[34px]" alt="icon">
                        <div class="flex flex-col gap-[2px]">
                              <p class="font-bold text-lg leading-[24px]">Kondisi</p>
                              <p class="text-sm leading-[21px]">{{ $asset->kondisi }}</p>
                        </div>
                  </div>
                  <div class="flex items-center gap-4">
                        <img src="/images/icons/3dcube.svg" class="w-[34px] h-[34px]" alt="icon">
                        <div class="flex flex-col gap-[2px]">
                              <p class="font-bold text-lg leading-[24px]">Lokasi</p>
                              <p class="text-sm leading-[21px]">{{ $asset->lokasi }}</p>
                        </div>
                  </div>
                  <div class="flex items-center gap-4">
                        <img src="/images/icons/group.svg" class="w-[34px] h-[34px]" alt="icon">
                        <div class="flex flex-col gap-[2px]">
                              <p class="font-bold text-lg leading-[24px]">Dibuat</p>
                              <p class="text-sm leading-[21px]">{{ $asset->created_at->format('d M Y') }}</p>
                        </div>
                  </div>
            </div>
            <hr class="border-[#F6F5FD]">
            <div class="flex flex-col gap-[6px]">
                  <h2 class="font-bold">Lokasi Aset</h2>
                  <p>{{ $asset->name }}</p>
                  <p>{{ $asset->lokasi }}</p>
            </div>
      </div>
      <div class="w-[392px] flex flex-col shrink-0 gap-[30px]">
            <div class="flex flex-col rounded-[20px] border border-[#E0DEF7] p-[30px] gap-[30px] bg-white">
                  <div>
                        @if($asset->status === 'tersedia')
                        <p class="font-bold text-xl leading-[30px]">Aset ini <span class="text-[#0D903A]">tersedia</span> untuk dipinjam.</p>
                        @elseif($asset->status === 'dipinjam')
                        <p class="font-bold text-xl leading-[30px]">Aset ini <span class="text-[#FF2D2D]">sedang dipinjam</span>.</p>
                        @else
                        <p class="font-bold text-xl leading-[30px]">Aset ini <span class="text-[#FF2D2D]">rusak</span> dan tidak tersedia.</p>
                        @endif
                  </div>
                  <hr class="border-[#F6F5FD]">
                  <div class="flex flex-col gap-5">
                        <div class="flex items-center gap-3">
                              <img src="/images/icons/verify.svg" class="w-[30px] h-[30px]" alt="icon">
                              <p class="font-semibold leading-[28px]">Informasi aset yang akurat</p>
                        </div>
                        <div class="flex items-center gap-3">
                              <img src="/images/icons/verify.svg" class="w-[30px] h-[30px]" alt="icon">
                              <p class="font-semibold leading-[28px]">Penanganan profesional</p>
                        </div>
                        <div class="flex items-center gap-3">
                              <img src="/images/icons/verify.svg" class="w-[30px] h-[30px]" alt="icon">
                              <p class="font-semibold leading-[28px]">Pemeliharaan rutin</p>
                        </div>
                  </div>
                  <hr class="border-[#F6F5FD]">
                  <div class="flex flex-col gap-[14px]">
                        <a href="{{ route('borrowings.create', $asset->id) }}" class="flex items-center justify-center w-full rounded-full border border-[#000929] p-[16px_26px] gap-3 bg-[#000929] text-white font-semibold">
                              <img src="/images/icons/save-add.svg" class="w-6 h-6" alt="icon">
                              <span>Pinjam Sekarang</span>
                        </a>
                  </div>
            </div>
            <div class="flex flex-col rounded-[20px] border border-[#E0DEF7] p-[30px] gap-[20px] bg-white">
                  <h2 class="font-bold">Kontak Administrator</h2>
                  <div class="flex flex-col gap-[30px]">
                        <div class="flex items-center justify-between gap-3">
                              <div class="flex items-center gap-4">
                                    <div class="w-[60px] h-[60px] rounded-full overflow-hidden">
                                          <img src="/images/photos/admin-photo-1.png" class="w-full h-full object-cover" alt="photo">
                                    </div>
                                    <div class="flex flex-col gap-[2px]">
                                          <p class="font-bold">Admin Utama</p>
                                          <p class="text-sm leading-[21px]">Admin Aset</p>
                                    </div>
                              </div>
                              <div class="flex items-center gap-3">
                                    <a href="#">
                                          <img src="/images/icons/call-green.svg" class="w-10 h-10" alt="icon">
                                    </a>
                                    <a href="#">
                                          <img src="/images/icons/chat-green.svg" class="w-10 h-10" alt="icon">
                                    </a>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
      const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            spaceBetween: 10,
            slidesPerView: "auto",
            slidesOffsetAfter: 10,
            slidesOffsetBefore: 10
      });
</script>

@endsection