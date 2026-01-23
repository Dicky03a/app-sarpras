@extends('admin.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 md:py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">Buat Peminjaman Baru</h1>
                <p class="text-sm text-gray-600">Lengkapi formulir di bawah untuk membuat peminjaman aset</p>
            </div>

            <form action="{{ route('borrowings.store.direct') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- User Info --}}
                <div class="mb-6">
                    <label class="block font-semibold text-sm text-gray-700 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 inline -mt-0.5">
                            <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                        </svg>
                        Peminjam (Admin Login)
                    </label>
                    <div class="px-4 py-3 border border-gray-200 rounded-xl bg-gray-50">
                        <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">

                {{-- Asset Selection --}}
                <div class="mb-6">
                    <label for="asset_id" class="block font-semibold text-sm text-gray-700 mb-2">
                        Pilih Aset <span class="text-red-500">*</span>
                    </label>
                    <select name="asset_id" id="asset_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent"
                        required>
                        <option value="">Pilih aset yang akan dipinjam</option>
                        @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->kode_aset }}) - {{ ucfirst($asset->status) }}
                        </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                    <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Date Range --}}
                <div class="mb-6">
                    <h3 class="font-bold text-sm text-gray-700 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                        </svg>
                        Periode Peminjaman
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_datetime" class="block text-sm text-gray-600 mb-2">Tanggal & Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_datetime" id="start_datetime"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent"
                                min="{{ date('Y-m-d\TH:i') }}" value="{{ old('start_datetime') }}" required>
                            @error('start_datetime')
                            <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_datetime" class="block text-sm text-gray-600 mb-2">Tanggal & Jam Selesai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="end_datetime" id="end_datetime"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent"
                                min="{{ date('Y-m-d\TH:i') }}" value="{{ old('end_datetime') }}" required>
                            @error('end_datetime')
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

                {{-- Status --}}
                <div class="mb-6">
                    <label for="status" class="block font-semibold text-sm text-gray-700 mb-2">
                        Status Peminjaman <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent"
                        required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ old('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status')
                    <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Purpose --}}
                <div class="mb-6">
                    <label for="keperluan" class="block font-semibold text-sm text-gray-700 mb-2">
                        Keperluan Peminjaman <span class="text-red-500">*</span>
                    </label>
                    <textarea name="keperluan" id="keperluan" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent resize-none"
                        placeholder="Jelaskan secara detail keperluan peminjaman aset ini..."
                        required>{{ old('keperluan') }}</textarea>
                    @error('keperluan')
                    <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Document Upload --}}
                <div class="mb-8">
                    <label for="lampiran_bukti" class="block font-semibold text-sm text-gray-700 mb-2">
                        Dokumen Pendukung
                    </label>
                    <input type="file" name="lampiran_bukti" id="lampiran_bukti"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#000929] focus:border-transparent
                               file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                               file:bg-[#000929] file:text-white hover:file:bg-[#000929]/90 file:cursor-pointer"
                        accept="image/*,.pdf,.doc,.docx">
                    <p class="text-xs text-gray-500 mt-2 flex items-start gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
                            <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z" clip-rule="evenodd" />
                        </svg>
                        Format: JPG, PNG, PDF, DOC, DOCX. Maksimal 5MB
                    </p>
                    @error('lampiran_bukti')
                    <p class="text-red-600 text-sm mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('borrowings.index') }}"
                        class="flex-1 sm:flex-none px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold text-center hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-8 py-3 bg-[#0D903A] text-white rounded-xl font-semibold hover:bg-[#0D903A]/90 transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                        Buat Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('start_datetime').addEventListener('change', function() {
        const startDateTime = new Date(this.value);

        // Set minimum for end_datetime to be at least 1 hour after start
        const minEndDateTime = new Date(startDateTime.getTime() + 60 * 60 * 1000); // Add 1 hour
        document.getElementById('end_datetime').min = minEndDateTime.toISOString().slice(0, 16);

        // Clear end_datetime if it's before the new minimum
        const endDateTime = document.getElementById('end_datetime');
        if (endDateTime.value && new Date(endDateTime.value) < minEndDateTime) {
            endDateTime.value = '';
        }
    });
</script>
@endsection