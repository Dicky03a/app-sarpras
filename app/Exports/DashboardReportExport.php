<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardReportExport implements FromView, WithStyles, WithTitle
{
    use Exportable;

    protected $timeFilter;
    protected $startDateParam;
    protected $endDateParam;

    public function __construct($timeFilter = 'week', $startDateParam = null, $endDateParam = null)
    {
        $this->timeFilter = $timeFilter;
        $this->startDateParam = $startDateParam;
        $this->endDateParam = $endDateParam;
    }

    public function view(): View
    {
        $dateRange = $this->getDateRange();
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $data = [
            'totalAssets' => $this->getTotalAssets(),
            'availableAssets' => $this->getAvailableAssets(),
            'borrowedAssets' => $this->getBorrowedAssets(),
            'damagedAssets' => $this->getDamagedAssets(),
            'monthlyBorrowings' => $this->getMonthlyBorrowings(),
            'rejectedBorrowings' => $this->getRejectedBorrowings($startDate, $endDate),
            'recentBorrowings' => $this->getRecentBorrowings($startDate, $endDate),
            'mostBorrowedAssets' => $this->getMostBorrowedAssets($startDate, $endDate),
            'dateRange' => $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'),
            'exportDate' => Carbon::now()->format('d M Y H:i:s')
        ];

        return view('admin.excel.dashboard-report', $data);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:F1' => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Sarpras';
    }

    private function getDateRange()
    {
        $endDate = Carbon::now()->endOfDay();

        if ($this->timeFilter === 'custom' && $this->startDateParam && $this->endDateParam) {
            $startDate = Carbon::parse($this->startDateParam)->startOfDay();
            $endDate = Carbon::parse($this->endDateParam)->endOfDay();
        } else {
            $startDate = match ($this->timeFilter) {
                'today' => Carbon::today()->startOfDay(),
                'week' => Carbon::now()->subDays(7)->startOfDay(),
                'month' => Carbon::now()->startOfMonth()->startOfDay(),
                'year' => Carbon::now()->startOfYear()->startOfDay(),
                default => Carbon::now()->subDays(7)->startOfDay()
            };
        }

        return ['start' => $startDate, 'end' => $endDate];
    }

    private function getTotalAssets()
    {
        return DB::table('assets')->count();
    }

    private function getAvailableAssets()
    {
        return DB::table('assets')
            ->leftJoin('borrowings', function ($join) {
                $join->on('assets.id', '=', 'borrowings.asset_id')
                    ->whereIn('borrowings.status', ['disetujui', 'dipinjam'])
                    ->where(function ($query) {
                        $query->whereNull('borrowings.tanggal_selesai')
                            ->orWhere('borrowings.tanggal_selesai', '>=', Carbon::now()->toDateString());
                    });
            })
            ->whereNull('borrowings.id')
            ->where('assets.kondisi', 'baik')
            ->count();
    }

    private function getBorrowedAssets()
    {
        return DB::table('borrowings')
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->where(function ($query) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', Carbon::now()->toDateString());
            })
            ->count();
    }

    private function getDamagedAssets()
    {
        return DB::table('assets')
            ->whereIn('kondisi', ['rusak ringan', 'rusak berat'])
            ->count();
    }

    private function getMonthlyBorrowings()
    {
        return DB::table('borrowings')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    private function getRejectedBorrowings($startDate, $endDate)
    {
        return DB::table('borrowings')
            ->where('status', 'ditolak')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    private function getRecentBorrowings($startDate, $endDate)
    {
        return DB::table('borrowings')
            ->join('users', 'borrowings.user_id', '=', 'users.id')
            ->join('assets', 'borrowings.asset_id', '=', 'assets.id')
            ->select(
                'users.name as user_name',
                'assets.name as asset_name',
                'borrowings.tanggal_mulai as borrow_date',
                'borrowings.tanggal_selesai as return_date',
                'borrowings.status',
                'borrowings.created_at'
            )
            ->whereBetween('borrowings.created_at', [$startDate, $endDate])
            ->orderBy('borrowings.created_at', 'desc')
            ->get()
            ->map(function ($borrowing) {
                $statusMap = [
                    'pending' => 'Pending',
                    'disetujui' => 'Disetujui',
                    'ditolak' => 'Ditolak',
                    'dipinjam' => 'Dipinjam',
                    'selesai' => 'Selesai'
                ];
                $borrowing->status = $statusMap[$borrowing->status] ?? ucfirst($borrowing->status);
                return $borrowing;
            });
    }

    private function getMostBorrowedAssets($startDate, $endDate)
    {
        return DB::table('borrowings')
            ->join('assets', 'borrowings.asset_id', '=', 'assets.id')
            ->select(
                'assets.name',
                'assets.kondisi as condition',
                DB::raw('COUNT(borrowings.id) as borrow_count')
            )
            ->whereBetween('borrowings.created_at', [$startDate, $endDate])
            ->groupBy('assets.id', 'assets.name', 'assets.kondisi')
            ->orderByDesc('borrow_count')
            ->get()
            ->map(function ($item) {
                $conditionMap = [
                    'baik' => 'Baik',
                    'rusak ringan' => 'Rusak Ringan',
                    'rusak berat' => 'Rusak Berat'
                ];
                return [
                    'name' => $item->name,
                    'condition' => $conditionMap[$item->condition] ?? ucfirst($item->condition),
                    'borrow_count' => $item->borrow_count
                ];
            })
            ->toArray();
    }
}
