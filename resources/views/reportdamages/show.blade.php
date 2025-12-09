@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Report Damage Details</h1>
            <a href="{{ route('reportdamages.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">ID</label>
                    <p class="text-gray-900">{{ $reportDamage->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">User</label>
                    <p class="text-gray-900">{{ $reportDamage->user->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Asset</label>
                    <p class="text-gray-900">{{ $reportDamage->asset->name ?? 'N/A' }} ({{ $reportDamage->asset->kode_aset ?? 'N/A' }})</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Damage Description</label>
                    <p class="text-gray-900">{{ $reportDamage->deskripsi_kerusakan }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Report Date</label>
                    <p class="text-gray-900">{{ $reportDamage->tanggal_lapor?->format('d F Y H:i') ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Created At</label>
                    <p class="text-gray-900">{{ $reportDamage->created_at->format('d F Y H:i') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Updated At</label>
                    <p class="text-gray-900">{{ $reportDamage->updated_at->format('d F Y H:i') }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('reportdamages.edit', $reportDamage->id) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('reportdamages.destroy', $reportDamage->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection