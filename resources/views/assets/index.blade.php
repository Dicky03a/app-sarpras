@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Asset</h1>
        <a href="{{ route('assets.create') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center transition duration-200">
            Buat Asset
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="hidden lg:block bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Code
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Location
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Condition
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            {{ $asset->id }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 font-medium">
                            {{ $asset->name }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 font-mono">
                            {{ $asset->kode_aset }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            {{ $asset->category->name ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            {{ $asset->lokasi }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($asset->kondisi == 'baik') bg-green-100 text-green-800
                                @elseif($asset->kondisi == 'rusak ringan') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $asset->kondisi }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($asset->status == 'tersedia') bg-green-100 text-green-800
                                @elseif($asset->status == 'dipinjam') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $asset->status }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            <div class="flex gap-2">
                                <a href="{{ route('assets.show', $asset->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">View</a>
                                <a href="{{ route('assets.edit', $asset->id) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">Edit</a>
                                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this asset?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 text-center">
                            No assets found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View (visible only on mobile/tablet) -->
    <div class="lg:hidden space-y-4">
        @forelse($assets as $asset)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-bold text-lg text-gray-900">{{ $asset->name }}</h3>
                    <p class="text-sm text-gray-600 font-mono">{{ $asset->kode_aset }}</p>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">ID: {{ $asset->id }}</span>
            </div>

            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Category:</span>
                    <span class="font-medium text-gray-900">{{ $asset->category->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Location:</span>
                    <span class="font-medium text-gray-900">{{ $asset->lokasi }}</span>
                </div>
                <div class="flex justify-between text-sm items-center">
                    <span class="text-gray-600">Condition:</span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($asset->kondisi == 'baik') bg-green-100 text-green-800
                        @elseif($asset->kondisi == 'rusak ringan') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ $asset->kondisi }}
                    </span>
                </div>
                <div class="flex justify-between text-sm items-center">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($asset->status == 'tersedia') bg-green-100 text-green-800
                        @elseif($asset->status == 'dipinjam') bg-blue-100 text-blue-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ $asset->status }}
                    </span>
                </div>
            </div>

            <div class="flex gap-2 pt-3 border-t border-gray-200">
                <a href="{{ route('assets.show', $asset->id) }}" class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2 px-3 rounded transition duration-150">
                    View
                </a>
                <a href="{{ route('assets.edit', $asset->id) }}" class="flex-1 text-center bg-yellow-50 hover:bg-yellow-100 text-yellow-600 font-medium py-2 px-3 rounded transition duration-150">
                    Edit
                </a>
                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this asset?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2 px-3 rounded transition duration-150">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500">No assets found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection