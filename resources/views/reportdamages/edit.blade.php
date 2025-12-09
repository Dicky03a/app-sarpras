@extends('admin.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Report Damage</h1>

        <form action="{{ route('reportdamages.update', $reportDamage->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="user_id" class="block text-gray-700 mb-2">User</label>
                        <select name="user_id" id="user_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select a User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $reportDamage->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="asset_id" class="block text-gray-700 mb-2">Asset</label>
                        <select name="asset_id" id="asset_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select an Asset</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" {{ old('asset_id', $reportDamage->asset_id) == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->name }} ({{ $asset->kode_aset }})
                                </option>
                            @endforeach
                        </select>
                        @error('asset_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi_kerusakan" class="block text-gray-700 mb-2">Damage Description</label>
                        <textarea name="deskripsi_kerusakan" id="deskripsi_kerusakan" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  rows="4" required>{{ old('deskripsi_kerusakan', $reportDamage->deskripsi_kerusakan) }}</textarea>
                        @error('deskripsi_kerusakan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_lapor" class="block text-gray-700 mb-2">Report Date</label>
                        <input type="datetime-local" name="tanggal_lapor" id="tanggal_lapor"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('tanggal_lapor', $reportDamage->tanggal_lapor?->format('Y-m-d\TH:i')) }}" required>
                        @error('tanggal_lapor')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 mt-6">
                    <a href="{{ route('reportdamages.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Report
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection