@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Ringkasan Sistem Sarpras</h1>
        <p class="text-gray-600 mt-2">Laporan dan aktivitas peminjaman aset</p>

        <div class="mt-6 flex flex-wrap items-center gap-4">
            <div class="relative">
                <select id="time-filter" class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
                    <option value="today" {{ request('time_filter') == 'today' ? 'selected' : '' }}>Hari ini</option>
                    <option value="week" {{ request('time_filter', 'week') == 'week' ? 'selected' : '' }}>7 hari terakhir</option>
                    <option value="month" {{ request('time_filter') == 'month' ? 'selected' : '' }}>Bulan ini</option>
                    <option value="year" {{ request('time_filter') == 'year' ? 'selected' : '' }}>Tahun ini</option>
                    <option value="custom" {{ request('time_filter') == 'custom' ? 'selected' : '' }}>Custom range</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button id="export-pdf" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export PDF
                </button>
                <button id="export-excel" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
        <!-- Total Assets Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Aset</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalAssets ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Available Assets Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Aset Tersedia</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $availableAssets ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Borrowed Assets Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="rounded-lg bg-yellow-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Sedang Dipinjam</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $borrowedAssets ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Damaged Assets Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="rounded-lg bg-red-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Aset Rusak</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $damagedAssets ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Monthly Borrowings Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="rounded-lg bg-indigo-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Peminjaman Bulan Ini</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $monthlyBorrowings ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Rejected Borrowings Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Peminjaman Ditolak</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $rejectedBorrowings ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Monthly Borrowing Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Peminjaman Bulanan</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="monthlyBorrowingChart"></canvas>
            </div>
        </div>

        <!-- Borrowing Status Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Peminjaman</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="borrowingStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Borrowings Table -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Peminjaman Terbaru</h3>
                <a href="{{ route('borrowings.index') ?? '/borrowings' }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentBorrowings ?? [] as $borrowing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $borrowing->user_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $borrowing->asset_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($borrowing->tanggal_mulai ?? $borrowing->borrow_date)->format('d-m-Y') }} -
                                {{ \Carbon\Carbon::parse($borrowing->tanggal_selesai ?? $borrowing->return_date)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($borrowing->status == 'approved') bg-green-100 text-green-800
                                    @elseif($borrowing->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($borrowing->status == 'borrowed') bg-blue-100 text-blue-800
                                    @elseif($borrowing->status == 'returned') bg-indigo-100 text-indigo-800
                                    @elseif($borrowing->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2">Tidak ada data peminjaman</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Most Borrowed Assets Table -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aset Paling Sering Dipinjam</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Aset</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($mostBorrowedAssets ?? [] as $asset)
                        <tr class="hover:bg-gray-50">
                            <td>{{ $asset->name ?? 'N/A' }}</td>
                            <td>{{ $asset->borrow_count ?? 0 }} kali</td>
                            <td>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
        @if($asset->condition == 'baik') bg-green-100 text-green-800
        @elseif($asset->condition == 'rusak ringan') bg-yellow-100 text-yellow-800
        @else bg-red-100 text-red-800
        @endif">
                                    {{ ucfirst($asset->condition ?? '-') }}
                                </span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="mt-2">Tidak ada data aset</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('assets.create') ?? '/assets/create' }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Aset
            </a>
            <a href="{{ route('borrowings.create.direct') ?? '/borrowings/create' }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Buat Peminjaman
            </a>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart configuration
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        };

        // Monthly Borrowing Chart
        const monthlyCtx = document.getElementById('monthlyBorrowingChart');
        if (monthlyCtx) {
            const monthlyData = @json($monthlyBorrowingsData ?? ['labels' => [], 'values' => []]);
            new Chart(monthlyCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: monthlyData.labels || [],
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: monthlyData.values || [],
                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    ...chartConfig,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Borrowing Status Chart
        const statusCtx = document.getElementById('borrowingStatusChart');
        if (statusCtx) {
            const statusData = @json($borrowingStatusData ?? ['labels' => [], 'values' => []]);
            new Chart(statusCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: statusData.labels || [],
                    datasets: [{
                        data: statusData.values || [],
                        backgroundColor: [
                            '#FBBF24',
                            '#10B981',
                            '#3B82F6',
                            '#8B5CF6',
                            '#EF4444'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: chartConfig
            });
        }

        // Time filter handler
        const timeFilter = document.getElementById('time-filter');
        if (timeFilter) {
            timeFilter.addEventListener('change', function() {
                const value = this.value;
                if (value === 'custom') {
                    showCustomDateModal();
                } else {
                    window.location.href = '?time_filter=' + value;
                }
            });
        }

        // Export PDF handler
        const exportPdf = document.getElementById('export-pdf');
        if (exportPdf) {
            exportPdf.addEventListener('click', function() {
                const params = getExportParams();
                window.location.href = '{{ route("dashboard.export.pdf") }}' + params;
            });
        }

        // Export Excel handler
        const exportExcel = document.getElementById('export-excel');
        if (exportExcel) {
            exportExcel.addEventListener('click', function() {
                const params = getExportParams();
                window.location.href = '{{ route("dashboard.export.excel") }}' + params;
            });
        }

        function getExportParams() {
            const timeFilter = document.getElementById('time-filter').value;
            const urlParams = new URLSearchParams(window.location.search);
            const startDate = urlParams.get('start_date');
            const endDate = urlParams.get('end_date');

            let params = '?time_filter=' + timeFilter;
            if (startDate && endDate) {
                params += '&start_date=' + startDate + '&end_date=' + endDate;
            }
            return params;
        }

        function showCustomDateModal() {
            const modal = createModal();
            document.body.appendChild(modal);

            // Set date constraints
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('startDate').max = today;
            document.getElementById('endDate').max = today;

            // Set default values
            const lastWeek = new Date();
            lastWeek.setDate(lastWeek.getDate() - 7);
            document.getElementById('startDate').value = lastWeek.toISOString().split('T')[0];
            document.getElementById('endDate').value = today;

            // Event listeners
            document.getElementById('closeModalBtn').addEventListener('click', () => modal.remove());
            document.getElementById('cancelCustomDateBtn').addEventListener('click', () => modal.remove());
            document.getElementById('applyCustomDateBtn').addEventListener('click', applyCustomDate);
            modal.addEventListener('click', (e) => e.target === modal && modal.remove());
        }

        function createModal() {
            const div = document.createElement('div');
            div.id = 'customDateModal';
            div.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center';
            div.innerHTML = `
            <div class="relative bg-white rounded-lg shadow-xl w-96 p-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Pilih Rentang Tanggal</h3>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                        <input type="date" id="startDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Akhir</label>
                        <input type="date" id="endDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button id="cancelCustomDateBtn" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none transition-colors duration-200">
                            Batal
                        </button>
                        <button id="applyCustomDateBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none transition                        <button id="applyCustomDateBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none transition-colors duration-200">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>
        `;
            return div;
        }

        function applyCustomDate() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            if (!startDate || !endDate) {
                alert('Silakan pilih tanggal mulai dan akhir');
                return;
            }

            if (startDate > endDate) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                return;
            }

            const params = new URLSearchParams({
                time_filter: 'custom',
                start_date: startDate,
                end_date: endDate
            });

            window.location.href = '?' + params.toString();
        }
    });
</script>
@endsection