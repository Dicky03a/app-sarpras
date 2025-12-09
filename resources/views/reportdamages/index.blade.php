@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Report Damages</h1>
        <a href="{{ route('reportdamages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Report
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
                        User
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Asset
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Damage Description
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Report Date
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportDamages as $reportDamage)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $reportDamage->id }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $reportDamage->user->name ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $reportDamage->asset->name ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 max-w-xs truncate">
                        {{ $reportDamage->deskripsi_kerusakan }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        {{ $reportDamage->tanggal_lapor?->format('d/m/Y H:i') ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900">
                        <a href="{{ route('reportdamages.show', $reportDamage->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                        <a href="{{ route('reportdamages.edit', $reportDamage->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                        <form action="{{ route('reportdamages.destroy', $reportDamage->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this report?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 text-center">
                        No report damages found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection