@extends('admin.dashboard')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center">Form Pindah Tempat Peminjaman</h1>

        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h2 class="text-xl font-semibold mb-2">Detail Peminjaman Saat Ini</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><strong>ID Peminjaman:</strong> {{ $borrowing->id }}</p>
                <p><strong>Status:</strong> 
                    <span class="px-2 py-1 rounded-full 
                        @if($borrowing->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($borrowing->status == 'disetujui') bg-green-100 text-green-800
                        @elseif($borrowing->status == 'ditolak') bg-red-100 text-red-800
                        @elseif($borrowing->status == 'dipinjam') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $borrowing->status }}
                    </span>
                </p>
                <p><strong>Nama Peminjam:</strong> {{ $borrowing->user->name }}</p>
                <p><strong>Tempat Saat Ini:</strong> {{ $borrowing->asset->name }}</p>
                <p><strong>Tanggal Mulai:</strong> {{ $borrowing->tanggal_mulai->format('d F Y') }}</p>
                <p><strong>Tanggal Selesai:</strong> {{ $borrowing->tanggal_selesai->format('d F Y') }}</p>
                <p class="md:col-span-2"><strong>Keperluan:</strong> {{ $borrowing->keperluan }}</p>
            </div>
        </div>

        <form action="{{ route('borrowings.move', $borrowing->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="new_asset_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tempat Baru *</label>
                <select name="new_asset_id" id="new_asset_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="">Pilih tempat baru...</option>
                    @foreach($availableAssets as $asset)
                        @if($asset->id != $borrowing->asset_id)
                            <option value="{{ $asset->id }}" 
                                {{ old('new_asset_id') == $asset->id ? 'selected' : '' }}>
                                {{ $asset->name }} ({{ $asset->kode_aset }})
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('new_asset_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="alasan_pemindahan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Pemindahan *</label>
                <textarea name="alasan_pemindahan" id="alasan_pemindahan" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Jelaskan alasan pemindahan tempat peminjaman..." required>{{ old('alasan_pemindahan') }}</textarea>
                @error('alasan_pemindahan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('borrowings.show', $borrowing->id) }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        onclick="return confirm('Anda yakin ingin memindahkan peminjaman ini? Tindakan ini tidak dapat dibatalkan.')">
                    Pindahkan Tempat Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection