@extends('layouts.user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">User Dashboard</h1>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Welcome, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600 dark:text-gray-300">You are logged in as a regular user.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Assets</h3>
            <p class="text-gray-600 dark:text-gray-300">View available assets</p>
            <a href="{{ route('assets.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View Assets</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Categories</h3>
            <p class="text-gray-600 dark:text-gray-300">Browse asset categories</p>
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View Categories</a>
        </div>
    </div>
</div>
@endsection