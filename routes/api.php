<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowingController;

/**
 * @OA\PathItem(
 *     path="/api"
 * )
 */

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

/**
 * @OA\Get(
 *     path="/api/user",
 *     summary="Get authenticated user info",
 *     description="Returns the authenticated user's information",
 *     tags={"User"},
 *     security={{"sanctum": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Authenticated user data",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     )
 * )
 */
Route::middleware('auth:sanctum')->get('/user', function () {
    return auth()->user();
});

/**
 * @OA\Post(
 *     path="/api/check-availability/{asset}",
 *     summary="Check asset availability",
 *     description="Check if an asset is available for a given date range",
 *     tags={"Borrowing"},
 *     security={{"sanctum": {}}},
 *     @OA\Parameter(
 *         name="asset",
 *         in="path",
 *         required=true,
 *         description="Asset ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"tanggal_mulai", "tanggal_selesai"},
 *             @OA\Property(property="tanggal_mulai", type="string", format="date", example="2023-12-01"),
 *             @OA\Property(property="tanggal_selesai", type="string", format="date", example="2023-12-05")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Availability check result",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="available", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Aset tersedia untuk periode tersebut.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */
// Asset availability check API route
Route::middleware(['auth:sanctum', 'throttle:api'])->post('/check-availability/{asset}', [BorrowingController::class, 'checkAvailability'])->name('api.borrowings.check.availability');