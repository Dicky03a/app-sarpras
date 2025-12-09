@extends('layouts.index')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center">Form Peminjaman Aset</h1>

        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-xl font-semibold mb-2">Detail Aset</h2>
            <p><strong>Nama Aset:</strong> {{ $asset->name }}</p>
            <p><strong>Kode Aset:</strong> {{ $asset->kode_aset }}</p>
            <p><strong>Kategori:</strong> {{ $asset->category->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> 
                @if($asset->status === 'tersedia')
                    <span class="text-green-600">Tersedia</span>
                @elseif($asset->status === 'dipinjam')
                    <span class="text-red-600">Sedang Dipinjam</span>
                @else
                    <span class="text-red-600">Rusak</span>
                @endif
            </p>
        </div>

        <form action="{{ route('borrowings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="asset_id" value="{{ $asset->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai Peminjaman *</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           min="{{ date('Y-m-d') }}" required>
                    @error('tanggal_mulai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Peminjaman *</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           min="{{ date('Y-m-d') }}" required>
                    @error('tanggal_selesai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Keperluan *</label>
                <textarea name="keperluan" id="keperluan" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Jelaskan keperluan Anda meminjam aset ini..." required>{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="lampiran_bukti" class="block text-sm font-medium text-gray-700 mb-1">Lampiran Bukti / Dokumen Izin *</label>
                <input type="file" name="lampiran_bukti" id="lampiran_bukti"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       accept="image/*,.pdf,.doc,.docx" required>
                <p class="text-sm text-gray-500 mt-1">Format file: JPG, PNG, PDF, DOC, DOCX. Maksimal 5MB</p>
                @error('lampiran_bukti')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ url()->previous() }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        const tanggalMulai = new Date(this.value);
        tanggalMulai.setDate(tanggalMulai.getDate() + 1); // Set next day as minimum

        const nextDay = tanggalMulai.toISOString().split('T')[0];
        document.getElementById('tanggal_selesai').min = nextDay;
    });
</script>
@endsection