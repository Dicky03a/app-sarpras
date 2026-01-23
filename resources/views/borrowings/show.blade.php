@extends('admin.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Peminjaman</h1>
                </div>
                <a href="{{ route('borrowings.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Status Banner -->
            <div class="px-6 py-4 border-b border-gray-200 
                @if($borrowing->status == 'pending') bg-yellow-50
                @elseif($borrowing->status == 'disetujui') bg-green-50
                @elseif($borrowing->status == 'ditolak') bg-red-50
                @elseif($borrowing->status == 'dipinjam') bg-blue-50
                @else bg-gray-50 @endif">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-600">Status Peminjaman</span>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold
                        @if($borrowing->status == 'pending') bg-yellow-100 text-yellow-800 ring-1 ring-yellow-600/20
                        @elseif($borrowing->status == 'disetujui') bg-green-100 text-green-800 ring-1 ring-green-600/20
                        @elseif($borrowing->status == 'ditolak') bg-red-100 text-red-800 ring-1 ring-red-600/20
                        @elseif($borrowing->status == 'dipinjam') bg-blue-100 text-blue-800 ring-1 ring-blue-600/20
                        @else bg-gray-100 text-gray-800 ring-1 ring-gray-600/20 @endif">
                        <span class="w-2 h-2 rounded-full mr-2
                            @if($borrowing->status == 'pending') bg-yellow-600
                            @elseif($borrowing->status == 'disetujui') bg-green-600
                            @elseif($borrowing->status == 'ditolak') bg-red-600
                            @elseif($borrowing->status == 'dipinjam') bg-blue-600
                            @else bg-gray-600 @endif"></span>
                        {{ ucfirst($borrowing->status) }}
                    </span>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- User Information -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</label>
                        <div class="flex items-center mt-2">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-base font-semibold text-gray-900">{{ $borrowing->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Asset Information -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Asset</label>
                        <div class="flex items-center mt-2">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                </svg>
                            </div>
                            <p class="text-base font-semibold text-gray-900">{{ $borrowing->asset->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Start Date & Time -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam Mulai</label>
                        <div class="flex items-center mt-2">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-base text-gray-900">{{ $borrowing->start_datetime ? $borrowing->start_datetime->format('d F Y H:i') : $borrowing->tanggal_mulai->format('d F Y') . ' 00:00' }}</p>
                        </div>
                    </div>

                    <!-- End Date & Time -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam Selesai</label>
                        <div class="flex items-center mt-2">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-base text-gray-900">{{ $borrowing->end_datetime ? $borrowing->end_datetime->format('d F Y H:i') : $borrowing->tanggal_selesai->format('d F Y') . ' 23:59' }}</p>
                        </div>
                    </div>

                    <!-- Admin -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Diproses Oleh</label>
                        <p class="text-base text-gray-900 mt-2">{{ $borrowing->admin->name ?? '-' }}</p>
                    </div>

                    <!-- Created At -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Pada</label>
                        <p class="text-base text-gray-900 mt-2">{{ $borrowing->created_at->format('d F Y H:i') }}</p>
                    </div>

                    <!-- Keterangan -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</label>
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-900 leading-relaxed">{{ $borrowing->keperluan }}</p>
                        </div>
                    </div>

                    <!-- Lampiran Bukti -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Lampiran</label>
                        @if($borrowing->lampiran_bukti)
                        <div class="mt-2 border border-gray-200 rounded-lg overflow-hidden bg-white">
                            <div class="p-3 bg-gray-50 border-b border-gray-200">
                                <a href="{{ asset('storage/' . $borrowing->lampiran_bukti) }}" target="_blank"
                                    class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ basename($borrowing->lampiran_bukti) }}
                                </a>
                            </div>
                            @php
                            $ext = strtolower(pathinfo($borrowing->lampiran_bukti, PATHINFO_EXTENSION));
                            @endphp
                            <div class="p-2">
                                @if($ext == 'pdf')
                                <iframe src="{{ asset('storage/' . $borrowing->lampiran_bukti) }}#toolbar=0"
                                    class="w-full h-96 rounded" allowfullscreen></iframe>
                                @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $borrowing->lampiran_bukti) }}" alt="Lampiran Bukti"
                                    class="w-full max-h-96 object-contain rounded" />
                                @else
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm">File tipe <strong>{{ strtoupper($ext) }}</strong> tidak dapat ditampilkan</p>
                                    <p class="text-xs mt-1">Klik link di atas untuk mengunduh</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="mt-2 p-8 text-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                            <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-sm text-gray-500">Tidak ada lampiran</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Rejection Reason -->
                @if($borrowing->rejection)
                <div class="mt-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-red-900 mb-1">Alasan Penolakan</h4>
                            <p class="text-sm text-red-800">{{ $borrowing->rejection->alasan }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Riwayat Pemindahan Tempat -->
                @if($borrowing->moves->count() > 0)
                <div class="mt-6 border border-amber-200 rounded-lg overflow-hidden">
                    <div class="bg-amber-50 px-4 py-3 border-b border-amber-200">
                        <h3 class="text-base font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            Riwayat Pemindahan Tempat
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dari</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ke</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($borrowing->moves as $move)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap">{{ $move->moved_at->format('d F Y H:i') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $move->oldAsset->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $move->newAsset->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $move->alasan_pemindahan }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $move->admin->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-wrap gap-3 justify-end">
                    @if($borrowing->status == 'pending')
                    <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('Apakah Anda yakin ingin menyetujui permintaan ini?');">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Setujui Permintaan
                        </button>
                    </form>
                    <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 modal-trigger"
                        data-id="{{ $borrowing->id }}" data-name="{{ $borrowing->user->name ?? 'N/A' }}"
                        data-asset="{{ $borrowing->asset->name ?? 'N/A' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak Permintaan
                    </button>
                    @elseif($borrowing->status == 'disetujui')
                    <form action="{{ route('borrowings.markAsBorrowed', $borrowing->id) }}" method="POST"
                        onsubmit="return confirm('Tandai peminjaman ini sebagai sedang dipinjam?');">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Tandai sebagai Dipinjam
                        </button>
                    </form>
                    <a href="{{ route('borrowings.move.form', $borrowing->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Pindahkan Tempat
                    </a>
                    @elseif($borrowing->status == 'dipinjam')
                    <form action="{{ route('borrowings.markAsReturned', $borrowing->id) }}" method="POST"
                        onsubmit="return confirm('Tandai peminjaman ini sebagai sudah dikembalikan?');">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            Tandai sebagai Dikembalikan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penolakan -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4 transition-opacity">
    <div class="bg-white rounded-xl w-full max-w-lg shadow-2xl transform transition-all scale-95 hover:scale-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Tolak Permintaan Peminjaman</h3>
                <button class="close-modal text-gray-400 hover:text-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-lg p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <form id="rejectForm" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pengguna</label>
                        <p class="text-base font-semibold text-gray-900" id="modalUserName"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Asset</label>
                        <p class="text-base font-semibold text-gray-900" id="modalAssetName"></p>
                    </div>
                </div>
                <div>
                    <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alasan" name="alasan" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none transition-all"
                        placeholder="Jelaskan alasan penolakan peminjaman..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all close-modal">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                    Tolak Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('rejectModal');
        const triggers = document.querySelectorAll('.modal-trigger');
        const closeBtns = document.querySelectorAll('.close-modal');
        const rejectForm = document.getElementById('rejectForm');

        triggers.forEach(trigger => {
            trigger.addEventListener('click', e => {
                e.preventDefault();
                const id = trigger.dataset.id;
                const name = trigger.dataset.name;
                const asset = trigger.dataset.asset;
                document.getElementById('modalUserName').textContent = name;
                document.getElementById('modalAssetName').textContent = asset;
                rejectForm.action = `/borrowings/${id}/reject`;
                modal.classList.remove('hidden');
            });
        });

        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });

        window.onclick = e => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        };
    });
</script>
@endsection