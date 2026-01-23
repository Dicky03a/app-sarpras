<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function () {
    return auth()->user();
});

// Asset availability check API route
Route::middleware(['auth:sanctum', 'throttle:api'])->post('/check-availability/{asset}', [BorrowingController::class, 'checkAvailability'])->name('api.borrowings.check.availability');