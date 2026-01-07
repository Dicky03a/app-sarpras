@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Laporan Kerusakan</h1>
            <a href="{{ route('reportdamages.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Dasar</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">ID Laporan</label>
                    <p class="text-gray-900">#{{ $reportDamage->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Status</label>
                    <p class="text-gray-900">
                        <span class="px-2 py-1 rounded-full
                            @if($reportDamage->status == 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                            @elseif($reportDamage->status == 'selesai') bg-green-100 text-green-800
                            @endif">
                            @if($reportDamage->status == 'menunggu_verifikasi') Menunggu Verifikasi
                            @elseif($reportDamage->status == 'selesai') Selesai
                            @endif
                        </span>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Pelapor</label>
                    <p class="text-gray-900">{{ $reportDamage->user->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Aset</label>
                    <p class="text-gray-900">{{ $reportDamage->asset->name ?? 'N/A' }} ({{ $reportDamage->asset->kode_aset ?? 'N/A' }})</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 mb-2 font-semibold">Deskripsi Kerusakan</label>
                    <p class="text-gray-900">{{ $reportDamage->deskripsi_kerusakan }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Tanggal Lapor</label>
                    <p class="text-gray-900">{{ $reportDamage->tanggal_lapor ? $reportDamage->tanggal_lapor->format('d F Y H:i') : 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Tanggal Buat</label>
                    <p class="text-gray-900">{{ optional($reportDamage->executed_at)->format('d M Y') ?? 'Belum diproses admin' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Tanggal Update</label>
                    <p class="text-gray-900">
                        {{ optional($reportDamage->updated_at)->format('d F Y H:i') ?? 'Belum ada perubahan' }}
                    </p>

                </div>
            </div>
        </div>

        <!-- Photo Section -->
        @if($reportDamage->foto_kerusakan)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Foto Kerusakan</h2>

            <div class="flex flex-col">
                <a href="{{ asset('storage/' . $reportDamage->foto_kerusakan) }}"
                    target="_blank"
                    class="text-blue-600 hover:text-blue-900 underline mb-2 inline-block">
                    Lihat Foto: {{ basename($reportDamage->foto_kerusakan) }}
                </a>
                <img src="{{ asset('storage/' . $reportDamage->foto_kerusakan) }}"
                    alt="Foto Kerusakan"
                    class="max-w-full h-auto rounded border"
                    style="max-height: 400px;">
            </div>
        </div>
        @endif

        <!-- Verification Information (only show if verified) -->
        @if($reportDamage->status == 'selesai')
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Verifikasi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Kondisi Aset Setelah Verifikasi</label>
                    <p class="text-gray-900">
                        <span class="px-2 py-1 rounded-full
                            @if($reportDamage->kondisi_setelah_verifikasi == 'baik') bg-green-100 text-green-800
                            @elseif($reportDamage->kondisi_setelah_verifikasi == 'rusak_ringan') bg-yellow-100 text-yellow-800
                            @elseif($reportDamage->kondisi_setelah_verifikasi == 'rusak_berat') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $reportDamage->kondisi_setelah_verifikasi)) }}
                        </span>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Admin Verifikasi</label>
                    <p class="text-gray-900">{{ $reportDamage->admin->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 mb-2 font-semibold">Pesan Tindak Lanjut</label>
                    <p class="text-gray-900">{{ $reportDamage->pesan_tindak_lanjut }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Tanggal Verifikasi</label>
                    <p class="text-gray-900">{{ $reportDamage->tanggal_verifikasi ? $reportDamage->tanggal_verifikasi->format('d F Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                @if($reportDamage->status == 'menunggu_verifikasi')
                <a href="{{ route('reportdamages.verify.form', $reportDamage->id) }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Verifikasi Laporan
                </a>
                @endif

                @if($reportDamage?->id)
                <a href="{{ route('reportdamages.edit', $reportDamage) }}"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                @endif



                <form action="{{ route('reportdamages.destroy', $reportDamage->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Yakin ingin menghapus laporan ini?')"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Hapus
                    </button>
                </form>


            </div>
        </div>
    </div>
</div>
@endsection