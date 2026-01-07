<?php

use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicDamageReportController;
use App\Http\Controllers\ReportDamageController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/category', [FrontController::class, 'category'])->name('category.front');
Route::get('/asset', [FrontController::class, 'asset'])->name('asset.front');
Route::get('/asset/{slug}', [FrontController::class, 'showAsset'])->name('asset.show');

// Dashboard route for backward compatibility with tests and general usage
Route::get('/dashboard', function () {
    if (auth()->check()) {
        // Use helper function to determine redirect destination based on user role
        return redirect(getDashboardRedirect(auth()->user()));
    }

    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // User dashboard - accessible by all authenticated users
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/requests', [UserDashboardController::class, 'requests'])->name('user.requests');
    Route::get('/user/borrowings/{borrowing}', [UserDashboardController::class, 'showBorrowing'])->name('user.borrowings.show');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Borrowing user routes - accessible by all authenticated users
    Route::get('/borrowings/create/{asset}', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');

    // Admin routes - only accessible by users with admin or superadmin role
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');


        Route::resource('/categories', AssetCategoryController::class)->names([
            'index' => 'categories.index',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'show' => 'categories.show',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'destroy' => 'categories.destroy',
        ]);

        Route::resource('/assets', AssetController::class)->names([
            'index' => 'assets.index',
            'create' => 'assets.create',
            'store' => 'assets.store',
            'show' => 'assets.show',
            'edit' => 'assets.edit',
            'update' => 'assets.update',
            'destroy' => 'assets.destroy',
        ]);

        // Borrowing administration routes
        Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::get('/borrowings/{borrowing}', [BorrowingController::class, 'show'])->name('borrowings.show');
        Route::get('/borrowings/{borrowing}/move', [BorrowingController::class, 'showMoveForm'])->name('borrowings.move.form');
        Route::put('/borrowings/{borrowing}/move', [BorrowingController::class, 'move'])->name('borrowings.move');
        Route::get('/borrowings/direct/create', [BorrowingController::class, 'createDirect'])->name('borrowings.create.direct');
        Route::post('/borrowings/direct', [BorrowingController::class, 'storeDirect'])->name('borrowings.store.direct');
        Route::put('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
        Route::put('/borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
        Route::put('/borrowings/{borrowing}/mark-as-borrowed', [BorrowingController::class, 'markAsBorrowed'])->name('borrowings.markAsBorrowed');
        Route::put('/borrowings/{borrowing}/mark-as-returned', [BorrowingController::class, 'markAsReturned'])->name('borrowings.markAsReturned');

        // Report Damage routes
        Route::resource('/reportdamages', ReportDamageController::class)->names([
            'index' => 'reportdamages.index',
            'create' => 'reportdamages.create',
            'store' => 'reportdamages.store',
            'show' => 'reportdamages.show',
            'edit' => 'reportdamages.edit',
            'update' => 'reportdamages.update',
            'destroy' => 'reportdamages.destroy',
        ]);

        // Additional routes for damage report verification
        Route::get('/reportdamages/{reportDamage}/verify', [ReportDamageController::class, 'showVerify'])->name('reportdamages.verify.form');
        Route::put('/reportdamages/{reportDamage}/verify', [ReportDamageController::class, 'verify'])->name('reportdamages.verify');
    });

    // User dashboard routes for damage reports
    Route::get('/user/report-damages', [ReportDamageController::class, 'userReports'])->name('user.report.damages');
    Route::get('/user/report-damages/{reportDamage}', [ReportDamageController::class, 'userReportDetail'])->name('user.report.damage.detail');
});

// Public routes for damage reports
Route::get('/public/report-damage', [PublicDamageReportController::class, 'showForm'])->name('public.report.damage.form');
Route::post('/public/report-damage', [PublicDamageReportController::class, 'store'])->name('public.report.damage.store');
Route::match(['get', 'post'], '/public/report-damage-status', [PublicDamageReportController::class, 'getStatus'])->name('public.report.damage.status');

require __DIR__ . '/auth.php';
