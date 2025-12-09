@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Asset Categories</h1>
        <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Category
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
                        Created At
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $category->id }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $category->name }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $category->created_at->format('Y-m-d H:i:s') }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        <a href="{{ route('categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 text-center">
                        No categories found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection