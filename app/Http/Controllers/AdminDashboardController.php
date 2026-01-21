<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardReportExport;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        $dateRange = $this->getDateRange($request);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        // Get dashboard statistics
        $stats = $this->getDashboardStats($startDate, $endDate);

        // Get chart data
        $chartData = $this->getChartData($startDate, $endDate);

        return view('admin.dashboard', array_merge($stats, $chartData));
    }

    /**
     * Export dashboard data to PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $dateRange = $this->getDateRange($request);
            $startDate = $dateRange['start'];
            $endDate = $dateRange['end'];

            $stats = $this->getDashboardStats($startDate, $endDate);

            // Get more detailed data for export
            $exportData = $this->getExportData($startDate, $endDate);

            $data = array_merge($stats, $exportData, [
                'dateRange' => $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'),
                'exportDate' => Carbon::now()->format('d M Y H:i:s')
            ]);

            $pdf = PDF::loadView('admin.pdf.dashboard-report', $data)
                ->setPaper('a4', 'portrait')
                ->setOption('margin-top', 10)
                ->setOption('margin-bottom', 10)
                ->setOption('margin-left', 10)
                ->setOption('margin-right', 10);

            return $pdf->download('laporan-sarpras-' . Carbon::now()->format('Y-m-d-His') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengekspor PDF: ' . $e->getMessage());
        }
    }

    /**
     * Export dashboard data to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $timeFilter = $request->get('time_filter', 'week');
            $startDateParam = $request->get('start_date');
            $endDateParam = $request->get('end_date');

            return Excel::download(
                new DashboardReportExport($timeFilter, $startDateParam, $endDateParam),
                'laporan-sarpras-' . Carbon::now()->format('Y-m-d-His') . '.xlsx'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengekspor Excel: ' . $e->getMessage());
        }
    }

    /**
     * Get date range based on filter
     */
    private function getDateRange(Request $request)
    {
        $timeFilter = $request->get('time_filter', 'week');
        $startDateParam = $request->get('start_date');
        $endDateParam = $request->get('end_date');

        $endDate = Carbon::now()->endOfDay();

        if ($timeFilter === 'custom' && $startDateParam && $endDateParam) {
            $startDate = Carbon::parse($startDateParam)->startOfDay();
            $endDate = Carbon::parse($endDateParam)->endOfDay();
        } else {
            $startDate = match ($timeFilter) {
                'today' => Carbon::today()->startOfDay(),
                'week' => Carbon::now()->subDays(7)->startOfDay(),
                'month' => Carbon::now()->startOfMonth()->startOfDay(),
                'year' => Carbon::now()->startOfYear()->startOfDay(),
                default => Carbon::now()->subDays(7)->startOfDay()
            };
        }

        return ['start' => $startDate, 'end' => $endDate];
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats($startDate, $endDate)
    {
        // Total assets
        $totalAssets = DB::table('assets')->count();

        // Available assets (not borrowed and in good condition)
        $availableAssets = DB::table('assets')
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

        // Currently borrowed assets
        $borrowedAssets = DB::table('borrowings')
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->where(function ($query) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', Carbon::now()->toDateString());
            })
            ->count();

        // Damaged assets
        $damagedAssets = DB::table('assets')
            ->whereIn('kondisi', ['rusak ringan', 'rusak berat'])
            ->count();

        // Monthly borrowings
        $monthlyBorrowings = DB::table('borrowings')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Rejected borrowings (within date range)
        $rejectedBorrowings = DB::table('borrowings')
            ->where('status', 'ditolak')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Recent borrowings
        $recentBorrowings = DB::table('borrowings')
            ->join('users', 'borrowings.user_id', '=', 'users.id')
            ->join('assets', 'borrowings.asset_id', '=', 'assets.id')
            ->select(
                'borrowings.*',
                'users.name as user_name',
                'assets.name as asset_name'
            )
            ->orderBy('borrowings.created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($b) => $this->mapBorrowingStatus($b));

        // Most borrowed assets
        $mostBorrowedAssets = DB::table('borrowings')
            ->join('assets', 'borrowings.asset_id', '=', 'assets.id')
            ->select(
                'assets.name',
                'assets.kondisi as condition',
                DB::raw('COUNT(borrowings.id) as borrow_count')
            )
            ->groupBy('assets.id', 'assets.name', 'assets.kondisi')
            ->orderByDesc('borrow_count')
            ->limit(5)
            ->get()
            ->toArray();

        return compact(
            'totalAssets',
            'availableAssets',
            'borrowedAssets',
            'damagedAssets',
            'monthlyBorrowings',
            'rejectedBorrowings',
            'recentBorrowings',
            'mostBorrowedAssets'
        );
    }

    /**
     * Get chart data
     */
    private function getChartData($startDate, $endDate)
    {
        return [
            'monthlyBorrowingsData' => $this->getMonthlyBorrowingsData($startDate, $endDate),
            'borrowingStatusData' => $this->getBorrowingStatusData()
        ];
    }

    /**
     * Get export data (more detailed)
     */
    private function getExportData($startDate, $endDate)
    {
        $recentBorrowings = DB::table('borrowings')
            ->join('users', 'borrowings.user_id', '=', 'users.id')
            ->join('assets', 'borrowings.asset_id', '=', 'assets.id')
            ->select(
                'borrowings.*',
                'users.name as user_name',
                'assets.name as asset_name'
            )
            ->whereBetween('borrowings.created_at', [$startDate, $endDate])
            ->orderBy('borrowings.created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(fn($b) => $this->mapBorrowingStatus($b));

        $mostBorrowedAssets = DB::table('borrowings')
            ->join('assets', 'borrowings.asset_id', '=', 'assets.id')
            ->select(
                'assets.name',
                'assets.kondisi as condition',
                DB::raw('COUNT(borrowings.id) as borrow_count')
            )
            ->whereBetween('borrowings.created_at', [$startDate, $endDate])
            ->groupBy('assets.id', 'assets.name', 'assets.kondisi')
            ->orderByDesc('borrow_count')
            ->limit(20)
            ->get()
            ->toArray();

        return compact('recentBorrowings', 'mostBorrowedAssets');
    }

    /**
     * Map borrowing status from Indonesian to English
     */
    private function mapBorrowingStatus($borrowing)
    {
        $statusMap = [
            'pending' => 'pending',
            'disetujui' => 'approved',
            'ditolak' => 'rejected',
            'dipinjam' => 'borrowed',
            'selesai' => 'returned'
        ];

        $borrowing->status = $statusMap[$borrowing->status] ?? $borrowing->status;
        return $borrowing;
    }

    /**
     * Get monthly borrowing data for chart
     */
    private function getMonthlyBorrowingsData($startDate, $endDate)
    {
        $diffInDays = $startDate->diffInDays($endDate);

        // Group by day if range is <= 31 days, otherwise by month
        if ($diffInDays <= 31) {
            $borrowings = DB::table('borrowings')
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            $labels = $borrowings->map(fn($r) => Carbon::parse($r->date)->format('d M'))->toArray();
            $values = $borrowings->pluck('count')->toArray();
        } else {
            $borrowings = DB::table('borrowings')
                ->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            $labels = $borrowings->map(fn($r) => Carbon::createFromDate($r->year, $r->month)->format('M Y'))->toArray();
            $values = $borrowings->pluck('count')->toArray();
        }

        return compact('labels', 'values');
    }

    /**
     * Get borrowing status data for chart
     */
    private function getBorrowingStatusData()
    {
        $statusCounts = DB::table('borrowings')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $statusMap = [
            'pending' => 'Pending',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dipinjam' => 'Dipinjam',
            'selesai' => 'Selesai'
        ];

        $labels = $statusCounts->map(fn($s) => $statusMap[$s->status] ?? ucfirst($s->status))->toArray();
        $values = $statusCounts->pluck('count')->toArray();

        return compact('labels', 'values');
    }
}
