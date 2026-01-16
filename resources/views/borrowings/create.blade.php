@extends('layouts.index')

@section('content')
<section class="relative max-w-[1130px] mx-auto mb-20 z-10 mt-10 md:mt-20 px-4 md:px-0">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-[30px]">
        {{-- MAIN FORM --}}
        <div class="flex-1 bg-white rounded-[20px] border border-[#E0DEF7] p-5 md:p-[30px]">
            <div class="mb-6 md:mb-8">
                <h1 class="font-extrabold text-2xl md:text-[32px] leading-tight md:leading-[44px] mb-2">
                    Form Peminjaman Aset
                </h1>
                <p class="text-sm md:text-base text-gray-600">
                    Lengkapi formulir di bawah ini untuk mengajukan peminjaman aset
                </p>
            </div>

            <form action="{{ route('borrowings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="asset_id" value="{{ $asset->id }}">

                {{-- Tanggal Peminjaman --}}
                <div class="mb-6 md:mb-8">
                    <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-[#000929]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        Periode Peminjaman
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                        <div>
                            <label for="tanggal_mulai" class="block font-semibold text-sm mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                       class="w-full px-4 py-3 border border-[#E0DEF7] rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent transition"
                                       min="{{ date('Y-m-d') }}" 
                                       value="{{ old('tanggal_mulai') }}"
                                       required>
                            </div>
                            @error('tanggal_mulai')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_selesai" class="block font-semibold text-sm mb-2">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                       class="w-full px-4 py-3 border border-[#E0DEF7] rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent transition"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('tanggal_selesai') }}"
                                       required>
                            </div>
                            @error('tanggal_selesai')
                                <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-[#F6F5FD] mb-6 md:mb-8">

                {{-- Keperluan --}}
                <div class="mb-6 md:mb-8">
                    <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-[#000929]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Detail Peminjaman
                    </h2>

                    <div>
                        <label for="keperluan" class="block font-semibold text-sm mb-2">
                            Keperluan Peminjaman <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keperluan" id="keperluan" rows="5"
                                  class="w-full px-4 py-3 border border-[#E0DEF7] rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent transition resize-none"
                                  placeholder="Jelaskan secara detail keperluan Anda meminjam aset ini. Contoh: untuk kegiatan seminar, penelitian, atau keperluan lainnya..."
                                  required>{{ old('keperluan') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1.5">Minimal 20 karakter</p>
                        @error('keperluan')
                            <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <hr class="border-[#F6F5FD] mb-6 md:mb-8">

                {{-- Upload Dokumen --}}
                <div class="mb-6 md:mb-8">
                    <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-[#000929]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                        </svg>
                        Lampiran Dokumen
                    </h2>

                    <div>
                        <label for="lampiran_bukti" class="block font-semibold text-sm mb-2">
                            Surat Izin / Dokumen Pendukung <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="lampiran_bukti" id="lampiran_bukti"
                                   class="w-full px-4 py-3 border border-[#E0DEF7] rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent transition
                                          file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                                          file:bg-[#000929] file:text-white hover:file:bg-[#000929]/90 file:cursor-pointer"
                                   accept="image/*,.pdf,.doc,.docx" required>
                        </div>
                        <div class="mt-2 flex items-start gap-2 text-xs text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 mt-0.5 flex-shrink-0">
                                <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z" clip-rule="evenodd" />
                            </svg>
                            <span>Format yang diterima: JPG, PNG, PDF, DOC, DOCX. Ukuran maksimal 5MB</span>
                        </div>
                        @error('lampiran_bukti')
                            <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4">
                    <a href="{{ url()->previous() }}" 
                       class="flex-1 sm:flex-none px-6 py-3.5 bg-white border-2 border-[#E0DEF7] text-[#000929] rounded-full font-semibold text-center hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 px-8 py-3.5 bg-[#000929] text-white rounded-full font-semibold hover:bg-[#000929]/90 transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>

        {{-- SIDEBAR - Asset Info --}}
        <div class="w-full lg:w-[392px] flex flex-col gap-6 lg:gap-[30px]">
            <div class="bg-white rounded-[20px] border border-[#E0DEF7] p-5 md:p-[30px]">
                <h2 class="font-bold text-lg mb-4">Detail Aset</h2>
                
                {{-- Asset Image --}}
                @if($asset->foto)
                <div class="w-full h-48 rounded-xl overflow-hidden mb-4">
                    <img src="{{ Storage::url($asset->foto) }}" 
                         alt="{{ $asset->name }}" 
                         class="w-full h-full object-cover">
                </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Nama Aset</p>
                        <p class="font-bold text-base">{{ $asset->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 mb-1">Kode Aset</p>
                        <p class="font-semibold">{{ $asset->kode_aset }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 mb-1">Kategori</p>
                        <p class="font-semibold">{{ $asset->category->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status</p>
                        @if($asset->status === 'tersedia')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 rounded-full text-sm font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                                </svg>
                                Tersedia
                            </span>
                        @elseif($asset->status === 'dipinjam')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-full text-sm font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                Sedang Dipinjam
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-full text-sm font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                Rusak
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 mb-1">Kondisi</p>
                        <p class="font-semibold capitalize">{{ $asset->kondisi }}</p>
                    </div>
                </div>
            </div>

            {{-- Info Card --}}
            <div class="bg-gradient-to-br from-[#000929] to-[#0D903A] rounded-[20px] p-5 md:p-6 text-white">
                <div class="flex items-start gap-3 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 flex-shrink-0">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Informasi Penting</h3>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-start gap-2">
                                <span class="text-green-300">•</span>
                                <span>Pastikan tanggal peminjaman sudah sesuai</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-green-300">•</span>
                                <span>Upload dokumen pendukung yang valid</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-green-300">•</span>
                                <span>Pengajuan akan diproses maksimal 1x24 jam</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        const tanggalMulai = new Date(this.value);
        tanggalMulai.setDate(tanggalMulai.getDate() + 1);

        const nextDay = tanggalMulai.toISOString().split('T')[0];
        document.getElementById('tanggal_selesai').min = nextDay;
        
        // Clear tanggal selesai if it's before the new minimum
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        if (tanggalSelesai.value && tanggalSelesai.value < nextDay) {
            tanggalSelesai.value = '';
        }
    });

    // File upload preview
    document.getElementById('lampiran_bukti').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            console.log('File selected:', fileName);
        }
    });
</script>
@endsection