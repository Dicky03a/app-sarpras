@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Peminjaman Details</h1>
            <a href="{{ route('borrowings.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">ID</label>
                    <p class="text-gray-900">{{ $borrowing->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Status</label>
                    <p class="text-gray-900">
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
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">User</label>
                    <p class="text-gray-900">{{ $borrowing->user->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Asset</label>
                    <p class="text-gray-900">{{ $borrowing->asset->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Start Date</label>
                    <p class="text-gray-900">{{ $borrowing->tanggal_mulai->format('d F Y') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">End Date</label>
                    <p class="text-gray-900">{{ $borrowing->tanggal_selesai->format('d F Y') }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 mb-2 font-semibold">Keterangan</label>
                    <p class="text-gray-900">{{ $borrowing->keperluan }}</p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 mb-2 font-semibold">Proof Attachment</label>
                    @if($borrowing->lampiran_bukti)
                    <div class="flex flex-col">
                        <a href="{{ asset('storage/' . $borrowing->lampiran_bukti) }}"
                            target="_blank"
                            class="text-blue-600 hover:text-blue-900 underline mb-2 inline-block">
                            View Attachment: {{ basename($borrowing->lampiran_bukti) }}
                        </a>
                        @php
                        $fileExtension = strtolower(pathinfo($borrowing->lampiran_bukti, PATHINFO_EXTENSION));
                        @endphp
                        @if($fileExtension == 'pdf')
                        <iframe src="{{ asset('storage/' . $borrowing->lampiran_bukti) }}#toolbar=0"
                            width="100%"
                            height="400px"
                            class="border rounded">
                            Your browser does not support PDF viewing.
                        </iframe>
                        @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset('storage/' . $borrowing->lampiran_bukti) }}"
                            alt="Lampiran Bukti"
                            class="max-w-full h-auto rounded border"
                            style="max-height: 400px;">
                        @else
                        <div class="p-4 bg-gray-100 rounded border">
                            <p class="text-gray-700">File type: {{ $fileExtension }}</p>
                            <p class="text-gray-700">File tidak bisa ditampilkan secara langsung. Silakan klik link untuk melihat.</p>
                        </div>
                        @endif
                    </div>
                    @else
                    <p class="text-gray-900">No attachment provided</p>
                    @endif
                </div>

                @if($borrowing->rejection)
                <div class="mb-4 md:col-span-2 bg-red-50 p-4 rounded">
                    <label class="block text-gray-700 mb-2 font-semibold">Rejection Reason</label>
                    <p class="text-gray-900">{{ $borrowing->rejection->alasan }}</p>
                </div>
                @endif

                <!-- Move History Section -->
                @if($borrowing->moves->count() > 0)
                <div class="mb-4 md:col-span-2 bg-yellow-50 p-4 rounded border border-yellow-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Riwayat Pemindahan Tempat</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pemindahan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat Lama</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat Baru</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($borrowing->moves as $move)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $move->moved_at->format('d F Y H:i') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $move->oldAsset->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $move->newAsset->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $move->alasan_pemindahan }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $move->admin->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Admin</label>
                    <p class="text-gray-900">{{ $borrowing->admin->name ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Created At</label>
                    <p class="text-gray-900">{{ $borrowing->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                @if($borrowing->status == 'pending')
                <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Approve this borrowing request?');">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Approve Request
                    </button>
                </form>

                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded modal-trigger"
                    data-id="{{ $borrowing->id }}"
                    data-name="{{ $borrowing->user->name ?? 'N/A' }}"
                    data-asset="{{ $borrowing->asset->name ?? 'N/A' }}">Reject Request</a>
                @elseif($borrowing->status == 'disetujui')
                <form action="{{ route('borrowings.markAsBorrowed', $borrowing->id) }}" method="POST" onsubmit="return confirm('Mark this borrowing as active?');">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Mark as Borrowed
                    </button>
                </form>

                <!-- Add Move Place Button for approved borrowings -->
                <a href="{{ route('borrowings.move.form', $borrowing->id) }}"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Pindahkan Tempat
                </a>
                @elseif($borrowing->status == 'dipinjam')
                <form action="{{ route('borrowings.markAsReturned', $borrowing->id) }}" method="POST" onsubmit="return confirm('Mark this borrowing as returned?');">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        Mark as Returned
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Reject Borrowing Request</h3>
                <button class="close-modal text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="rejectForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="admin_id" value="{{ auth()->id() }}">

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">User:</label>
                    <p class="text-gray-900 font-semibold" id="modalUserName"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Asset:</label>
                    <p class="text-gray-900 font-semibold" id="modalAssetName"></p>
                </div>

                <div class="mb-4">
                    <label for="alasan" class="block text-gray-700 mb-2">Reason for Rejection:</label>
                    <textarea name="alasan" id="alasan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        rows="3" required></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" class="close-modal bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('rejectModal');
        const modalTriggers = document.querySelectorAll('.modal-trigger');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const rejectForm = document.getElementById('rejectForm');

        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const borrowingId = this.getAttribute('data-id');
                const userName = this.getAttribute('data-name');
                const assetName = this.getAttribute('data-asset');

                document.getElementById('modalUserName').textContent = userName;
                document.getElementById('modalAssetName').textContent = assetName;
                rejectForm.action = '/borrowings/' + borrowingId + '/reject';

                modal.classList.remove('hidden');
            });
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endsection