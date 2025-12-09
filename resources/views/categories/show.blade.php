@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Category Details</h1>
            <a href="{{ route('categories.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">ID</label>
                    <p class="text-gray-900">{{ $category->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Name</label>
                    <p class="text-gray-900">{{ $category->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Created At</label>
                    <p class="text-gray-900">{{ $category->created_at->format('Y-m-d H:i:s') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Updated At</label>
                    <p class="text-gray-900">{{ $category->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 mt-6">
                <a href="{{ route('categories.edit', $category->id) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
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