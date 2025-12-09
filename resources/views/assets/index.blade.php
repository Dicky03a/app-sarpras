@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Assets</h1>
        <a href="{{ route('assets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Asset
        </a>
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
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $asset->id }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
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
                        <span class="px-2 py-1 rounded-full text-xs 
                            @if($asset->kondisi == 'baik') bg-green-100 text-green-800
                            @elseif($asset->kondisi == 'rusak ringan') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $asset->kondisi }}
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        <span class="px-2 py-1 rounded-full text-xs 
                            @if($asset->status == 'tersedia') bg-green-100 text-green-800
                            @elseif($asset->status == 'dipinjam') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $asset->status }}
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        <a href="{{ route('assets.show', $asset->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                        <a href="{{ route('assets.edit', $asset->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this asset?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
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
@endsection