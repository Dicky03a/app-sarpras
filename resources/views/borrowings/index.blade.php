@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Peminjaman</h1>
        <a href="{{ route('borrowings.create.direct') }}" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center transition duration-200">
            Buat Peminjaman
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Asset</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dates</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Admin</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">{{ $borrowing->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 font-medium">{{ $borrowing->user->name ?? 'N/A' }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">{{ $borrowing->asset->name ?? 'N/A' }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">{{ $borrowing->tanggal_mulai->format('d/m/Y') }} - {{ $borrowing->tanggal_selesai->format('d/m/Y') }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 max-w-xs truncate">{{ $borrowing->keperluan }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($borrowing->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($borrowing->status == 'disetujui') bg-green-100 text-green-800
                                @elseif($borrowing->status == 'ditolak') bg-red-100 text-red-800
                                @elseif($borrowing->status == 'dipinjam') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $borrowing->status }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">{{ $borrowing->admin->name ?? '-' }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            <div class="flex flex-col gap-1">
                                <a href="{{ route('borrowings.show', $borrowing->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">View</a>

                                @if($borrowing->status == 'pending')
                                <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Approve this borrowing request?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Approve</button>
                                </form>
                                <a href="#" class="text-red-600 hover:text-red-900 font-medium modal-trigger"
                                    data-id="{{ $borrowing->id }}"
                                    data-name="{{ $borrowing->user->name ?? 'N/A' }}"
                                    data-asset="{{ $borrowing->asset->name ?? 'N/A' }}">Reject</a>
                                @elseif($borrowing->status == 'disetujui')
                                <form action="{{ route('borrowings.markAsBorrowed', $borrowing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Mark this borrowing as active?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="text-blue-600 hover:text-blue-900 font-medium">Mark as Borrowed</button>
                                </form>
                                @elseif($borrowing->status == 'dipinjam')
                                <form action="{{ route('borrowings.markAsReturned', $borrowing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Mark this borrowing as returned?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="text-purple-600 hover:text-purple-900 font-medium">Mark as Returned</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 text-center">No borrowing requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-4">
        @forelse($borrowings as $borrowing)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-gray-900">{{ $borrowing->user->name ?? 'N/A' }}</h3>
                    <p class="text-sm text-gray-600">{{ $borrowing->asset->name ?? 'N/A' }}</p>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">ID: {{ $borrowing->id }}</span>
            </div>

            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Tanggal:</span>
                    <span class="font-medium text-gray-900 text-right">{{ $borrowing->tanggal_mulai->format('d/m/Y') }} - {{ $borrowing->tanggal_selesai->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Keperluan:</span>
                    <span class="font-medium text-gray-900 text-right max-w-[60%] truncate">{{ $borrowing->keperluan }}</span>
                </div>
                <div class="flex justify-between text-sm items-center">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($borrowing->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($borrowing->status == 'disetujui') bg-green-100 text-green-800
                        @elseif($borrowing->status == 'ditolak') bg-red-100 text-red-800
                        @elseif($borrowing->status == 'dipinjam') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $borrowing->status }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Admin:</span>
                    <span class="font-medium text-gray-900">{{ $borrowing->admin->name ?? '-' }}</span>
                </div>
            </div>

            <div class="flex flex-col gap-2 pt-3 border-t border-gray-200">
                <a href="{{ route('borrowings.show', $borrowing->id) }}" class="w-full text-center bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2 px-3 rounded transition duration-150">
                    View Details
                </a>

                @if($borrowing->status == 'pending')
                <div class="grid grid-cols-2 gap-2">
                    <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" onsubmit="return confirm('Approve this borrowing request?');">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                        <button type="submit" class="w-full bg-green-50 hover:bg-green-100 text-green-600 font-medium py-2 px-3 rounded transition duration-150">
                            Approve
                        </button>
                    </form>
                    <a href="#" class="w-full text-center bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2 px-3 rounded transition duration-150 modal-trigger"
                        data-id="{{ $borrowing->id }}"
                        data-name="{{ $borrowing->user->name ?? 'N/A' }}"
                        data-asset="{{ $borrowing->asset->name ?? 'N/A' }}">
                        Reject
                    </a>
                </div>
                @elseif($borrowing->status == 'disetujui')
                <form action="{{ route('borrowings.markAsBorrowed', $borrowing->id) }}" method="POST" onsubmit="return confirm('Mark this borrowing as active?');">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                    <button type="submit" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2 px-3 rounded transition duration-150">
                        Mark as Borrowed
                    </button>
                </form>
                @elseif($borrowing->status == 'dipinjam')
                <form action="{{ route('borrowings.markAsReturned', $borrowing->id) }}" method="POST" onsubmit="return confirm('Mark this borrowing as returned?');">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                    <button type="submit" class="w-full bg-purple-50 hover:bg-purple-100 text-purple-600 font-medium py-2 px-3 rounded transition duration-150">
                        Mark as Returned
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500">No borrowing requests found.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
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
                    <label class="block text-gray-700 text-sm mb-2">User:</label>
                    <p class="text-gray-900 font-semibold" id="modalUserName"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Asset:</label>
                    <p class="text-gray-900 font-semibold" id="modalAssetName"></p>
                </div>

                <div class="mb-4">
                    <label for="alasan" class="block text-gray-700 text-sm mb-2">Reason for Rejection:</label>
                    <textarea name="alasan" id="alasan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        rows="3" required></textarea>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                    <button type="button" class="close-modal bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150">
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