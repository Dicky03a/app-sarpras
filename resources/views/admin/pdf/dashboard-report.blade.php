<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sistem Sarpras</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
        }

        .header h1 {
            font-size: 18px;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-row {
            display: table-row;
        }

        .summary-card {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .card-inner {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 12px;
            background-color: #f9fafb;
        }

        .card-title {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .card-value {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding: 8px 10px;
            background-color: #2563eb;
            color: white;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead tr {
            background-color: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
        }

        td {
            padding: 6px 6px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 10px;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-borrowed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-returned {
            background-color: #e9d5ff;
            color: #6b21a8;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .condition-good {
            background-color: #d1fae5;
            color: #065f46;
        }

        .condition-light {
            background-color: #fef3c7;
            color: #92400e;
        }

        .condition-heavy {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6b7280;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN SISTEM SARANA DAN PRASARANA</h1>
        <p>Periode: {{ $dateRange }}</p>
        <p>Diekspor pada: {{ $exportDate }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-grid">
        <div class="summary-row">
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-title">Total Aset</div>
                    <div class="card-value">{{ $totalAssets }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-title">Aset Tersedia</div>
                    <div class="card-value">{{ $availableAssets }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-title">Sedang Dipinjam</div>
                    <div class="card-value">{{ $borrowedAssets }}</div>
                </div>
            </div>
        </div>
        <div class="summary-row">
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-title">Aset Rusak</div>
                    <div class="card-value">{{ $damagedAssets }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-title">Peminjaman Bulan Ini</div>
                    <div class="card-value">{{ $monthlyBorrowings }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-title">Peminjaman Ditolak</div>
                    <div class="card-value">{{ $rejectedBorrowings }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Borrowings -->
    <div class="section-title">Riwayat Peminjaman</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Aset</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentBorrowings as $index => $borrowing)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $borrowing->user_name }}</td>
                <td>{{ $borrowing->asset_name }}</td>
                <td>{{ \Carbon\Carbon::parse($borrowing->tanggal_mulai ?? $borrowing->borrow_date)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($borrowing->tanggal_selesai ?? $borrowing->return_date)->format('d-m-Y') }}</td>
                <td>
                    <span class="status-badge 
                        @if($borrowing->status == 'approved' || $borrowing->status == 'Disetujui') status-approved
                        @elseif($borrowing->status == 'pending' || $borrowing->status == 'Pending') status-pending
                        @elseif($borrowing->status == 'borrowed' || $borrowing->status == 'Dipinjam') status-borrowed
                        @elseif($borrowing->status == 'returned' || $borrowing->status == 'Selesai') status-returned
                        @elseif($borrowing->status == 'rejected' || $borrowing->status == 'Ditolak') status-rejected
                        @endif">
                        {{ $borrowing->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Tidak ada data peminjaman</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Most Borrowed Assets -->
    <div class="section-title">Aset Paling Sering Dipinjam</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Kondisi</th>
                <th>Jumlah Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mostBorrowedAssets as $index => $asset)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $asset['name'] }}</td>
                <td>
                    <span class="status-badge
                        @if($asset['condition'] == 'baik' || $asset['condition'] == 'Baik') condition-good
                        @elseif($asset['condition'] == 'rusak ringan' || $asset['condition'] == 'Rusak Ringan') condition-light
                        @else condition-heavy
                        @endif">
                        {{ $asset['condition'] }}
                    </span>
                </td>
                <td>{{ $asset['borrow_count'] }} kali</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Tidak ada data aset</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Sarana dan Prasarana</p>
        <p>Dicetak pada: {{ $exportDate }}</p>
    </div>
</body>

</html>