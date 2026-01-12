@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Categori</h1>
        <a href="{{ route('categories.create') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center transition duration-200">
            Buat Categori Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
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
                            Di Buat
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            {{ $category->id }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 font-medium">
                            {{ $category->name }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            {{ $category->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                            <div class="flex gap-2">
                                <a href="{{ route('categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">View</a>
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </div>
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

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @forelse($categories as $category)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-gray-900">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Dibuat: {{ $category->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">ID: {{ $category->id }}</span>
            </div>

            <div class="flex gap-2 pt-3 border-t border-gray-200">
                <a href="{{ route('categories.show', $category->id) }}" class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2 px-3 rounded transition duration-150">
                    View
                </a>
                <a href="{{ route('categories.edit', $category->id) }}" class="flex-1 text-center bg-yellow-50 hover:bg-yellow-100 text-yellow-600 font-medium py-2 px-3 rounded transition duration-150">
                    Edit
                </a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
            <p class="text-gray-500">No categories found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection