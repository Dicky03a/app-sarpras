@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center">Create Direct Borrowing</h1>

        <form action="{{ route('borrowings.store.direct') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">User (Logged-in Admin)</label>
                <div class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                    {{ auth()->user()->name }} ({{ auth()->user()->email }})
                </div>
            </div>

            <div class="mb-6">
                <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-1">Select Asset *</label>
                <select name="asset_id" id="asset_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="">Select Asset</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->kode_aset }})
                        </option>
                    @endforeach
                </select>
                @error('asset_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           min="{{ date('Y-m-d') }}" required value="{{ old('tanggal_mulai') }}">
                    @error('tanggal_mulai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">End Date *</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           min="{{ date('Y-m-d') }}" required value="{{ old('tanggal_selesai') }}">
                    @error('tanggal_selesai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                <select name="status" id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ old('status') == 'disetujui' ? 'selected' : '' }}>Disetujui (Approved)</option>
                    <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam (Borrowed)</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                </select>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Purpose *</label>
                <textarea name="keperluan" id="keperluan" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Explain the purpose of borrowing this asset..." required>{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="lampiran_bukti" class="block text-sm font-medium text-gray-700 mb-1">Proof Document (Optional)</label>
                <input type="file" name="lampiran_bukti" id="lampiran_bukti"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       accept="image/*,.pdf,.doc,.docx">
                <p class="text-sm text-gray-500 mt-1">Format file: JPG, PNG, PDF, DOC, DOCX. Maksimal 5MB</p>
                @error('lampiran_bukti')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('borrowings.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Create Direct Borrowing
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

    // Asset search functionality
    document.getElementById('asset_search').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const assetSelect = document.getElementById('asset_id');
        const options = assetSelect.getElementsByTagName('option');

        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const text = option.text.toLowerCase();

            if (searchTerm === '' || text.includes(searchTerm)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    });
</script>
@endsection