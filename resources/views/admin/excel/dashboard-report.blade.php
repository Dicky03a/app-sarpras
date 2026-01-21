<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 16px; font-weight: bold;">
                LAPORAN SISTEM SARANA DAN PRASARANA
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 12px;">
                Periode: {{ $dateRange }}
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 10px;">
                Diekspor pada: {{ $exportDate }}
            </th>
        </tr>
        <tr></tr>
    </thead>
    <tbody>
        <!-- Summary Statistics -->
        <tr>
            <td colspan="6" style="font-weight: bold; background-color: #e5e7eb;">RINGKASAN STATISTIK</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Total Aset</td>
            <td>{{ $totalAssets }}</td>
            <td></td>
            <td style="font-weight: bold;">Peminjaman Bulan Ini</td>
            <td>{{ $monthlyBorrowings }}</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Aset Tersedia</td>
            <td>{{ $availableAssets }}</td>
            <td></td>
            <td style="font-weight: bold;">Peminjaman Ditolak</td>
            <td>{{ $rejectedBorrowings }}</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Sedang Dipinjam</td>
            <td>{{ $borrowedAssets }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Aset Rusak</td>
            <td>{{ $damagedAssets }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr></tr>

        <!-- Recent Borrowings -->
        <tr>
            <td colspan="6" style="font-weight: bold; background-color: #e5e7eb;">RIWAYAT PEMINJAMAN</td>
        </tr>
        <tr style="font-weight: bold; background-color: #f3f4f6;">
            <td>Nama Peminjam</td>
            <td>Nama Aset</td>
            <td>Tanggal Mulai</td>
            <td>Tanggal Selesai</td>
            <td>Status</td>
            <td>Tanggal Dibuat</td>
        </tr>
        @forelse($recentBorrowings as $borrowing)
        <tr>
            <td>{{ $borrowing->user_name }}</td>
            <td>{{ $borrowing->asset_name }}</td>
            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d-m-Y') }}</td>
            <td>{{ $borrowing->status }}</td>
            <td>{{ \Carbon\Carbon::parse($borrowing->created_at)->format('d-m-Y H:i') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Tidak ada data peminjaman</td>
        </tr>
        @endforelse
        <tr></tr>

        <!-- Most Borrowed Assets -->
        <tr>
            <td colspan="6" style="font-weight: bold; background-color: #e5e7eb;">ASET PALING SERING DIPINJAM</td>
        </tr>
        <tr style="font-weight: bold; background-color: #f3f4f6;">
            <td>Nama Aset</td>
            <td>Kondisi</td>
            <td>Jumlah Dipinjam</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @forelse($mostBorrowedAssets as $asset)
        <tr>
            <td>{{ $asset['name'] }}</td>
            <td>{{ $asset['condition'] }}</td>
            <td>{{ $asset['borrow_count'] }} kali</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Tidak ada data aset</td>
        </tr>
        @endforelse
    </tbody>
</table>