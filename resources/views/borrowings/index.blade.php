@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Borrowing Requests</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('borrowings.create.direct') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Create Direct Borrowing
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        User
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Asset
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Dates
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Purpose
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Admin
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $borrowing)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $borrowing->id }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $borrowing->user->name ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $borrowing->asset->name ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $borrowing->tanggal_mulai->format('d/m/Y') }} - {{ $borrowing->tanggal_selesai->format('d/m/Y') }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 max-w-xs truncate">
                        {{ $borrowing->keperluan }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        <span class="px-2 py-1 rounded-full text-xs
                            @if($borrowing->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($borrowing->status == 'disetujui') bg-green-100 text-green-800
                            @elseif($borrowing->status == 'ditolak') bg-red-100 text-red-800
                            @elseif($borrowing->status == 'dipinjam') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $borrowing->status }}
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $borrowing->admin->name ?? '-' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        <a href="{{ route('borrowings.show', $borrowing->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>

                        @if($borrowing->status == 'pending')
                        <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Approve this borrowing request?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                            <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approve</button>
                        </form>
                        <a href="#" class="text-red-600 hover:text-red-900 modal-trigger"
                            data-id="{{ $borrowing->id }}"
                            data-name="{{ $borrowing->user->name ?? 'N/A' }}"
                            data-asset="{{ $borrowing->asset->name ?? 'N/A' }}">Reject</a>
                        @elseif($borrowing->status == 'disetujui')
                        <form action="{{ route('borrowings.markAsBorrowed', $borrowing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Mark this borrowing as active?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                            <button type="submit" class="text-blue-600 hover:text-blue-900 mr-2">Mark as Borrowed</button>
                        </form>
                        @elseif($borrowing->status == 'dipinjam')
                        <form action="{{ route('borrowings.markAsReturned', $borrowing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Mark this borrowing as returned?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="admin_id" value="{{ auth()->id() }}">
                            <button type="submit" class="text-purple-600 hover:text-purple-900 mr-2">Mark as Returned</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 text-center">
                        No borrowing requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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