@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Asset Details</h1>
            <a href="{{ route('assets.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">ID</label>
                    <p class="text-gray-900">{{ $asset->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Name</label>
                    <p class="text-gray-900">{{ $asset->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Code</label>
                    <p class="text-gray-900">{{ $asset->kode_aset }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Category</label>
                    <p class="text-gray-900">{{ $asset->category->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Location</label>
                    <p class="text-gray-900">{{ $asset->lokasi }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Condition</label>
                    <p class="text-gray-900">
                        <span class="px-2 py-1 rounded-full 
                            @if($asset->kondisi == 'baik') bg-green-100 text-green-800
                            @elseif($asset->kondisi == 'rusak ringan') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $asset->kondisi }}
                        </span>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Status</label>
                    <p class="text-gray-900">
                        <span class="px-2 py-1 rounded-full 
                            @if($asset->status == 'tersedia') bg-green-100 text-green-800
                            @elseif($asset->status == 'dipinjam') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $asset->status }}
                        </span>
                    </p>
                </div>

                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 mb-2 font-semibold">Description</label>
                    <p class="text-gray-900">{{ $asset->deskripsi ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Created At</label>
                    <p class="text-gray-900">{{ $asset->created_at->format('Y-m-d H:i:s') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Updated At</label>
                    <p class="text-gray-900">{{ $asset->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 mt-6">
                <a href="{{ route('assets.edit', $asset->id) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');">
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