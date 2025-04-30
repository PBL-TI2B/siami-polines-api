<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PeriodeAuditController;
use App\Http\Controllers\API\DataUserController;
use App\Http\Controllers\Api\KriteriaController;
use App\Http\Controllers\Api\DataInstrumenUptController;
use App\Http\Controllers\Api\DataUnitController;
use App\Http\Controllers\Api\DeskripsiController;
use App\Http\Controllers\Api\TilikController;
use App\Http\Controllers\Api\ResponseTilikController;
use App\Http\Controllers\Api\UnsurController;

// endpoint register (tidak butuh login)
//Route::post('/register', [RegisterController::class, 'register']);

// endpoint login (tidak butuh login)
Route::post('/login', [AuthController::class, 'login']);

// Group route yang butuh login (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // update profile
    Route::put('/user/update', [AuthController::class, 'update']);

    // logout
    Route::delete('/logout', [AuthController::class, 'logout']);
});

Route::prefix('periode-audits')->group(function () {
    Route::get('/', [PeriodeAuditController::class, 'index']);
    Route::post('/', [PeriodeAuditController::class, 'store']);
    Route::get('/active', [PeriodeAuditController::class, 'active']);
    Route::post('/open', [PeriodeAuditController::class, 'open']);
    Route::get('/{id}', [PeriodeAuditController::class, 'show']);
    Route::put('/{id}', [PeriodeAuditController::class, 'update']);
    Route::put('/{id}/close', [PeriodeAuditController::class, 'close']);
    Route::delete('/{id}', [PeriodeAuditController::class, 'destroy']);
});

// Route::post('/sasaran-strategis', [SasaranStrategisController::class, 'store']);

Route::apiResource('data-user', DataUserController::class);

// Route GET semua kriteria
Route::get('/kriteria', [KriteriaController::class, 'index']);
// Route GET satu kriteria berdasarkan ID
Route::get('/kriteria/{id}', [KriteriaController::class, 'show']);
// Route POST satu kriteria berdasarkan ID
Route::post('/kriteria', [KriteriaController::class, 'store']);
// Route PUT satu kriteria berdasarkan ID
Route::put('/kriteria/{id}', [KriteriaController::class, 'update']);
// Route DELETE untuk hapus kriteria
Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy']);

Route::apiResource('data-instrumen', DataInstrumenUptController::class);

Route::get('deskripsi', [DeskripsiController::class, 'index']);  // Mengambil semua deskripsi
Route::get('deskripsi/kriteria/{kriteria_id}', [DeskripsiController::class, 'showByKriteria']);  // Mengambil deskripsi berdasarkan kriteria_id
Route::post('deskripsi', [DeskripsiController::class, 'store']);  // Menambahkan route untuk POST
Route::put('deskripsi/{id}', [DeskripsiController::class, 'update']);
Route::delete('deskripsi/{id}', [DeskripsiController::class, 'destroy']);

// GET semua data unsur
Route::get('unsur', [UnsurController::class, 'index']);
// GET unsur berdasarkan ID
Route::get('unsur/{id}', [UnsurController::class, 'show']);


//Route::middleware(['auth:api', 'can:manage-users'])->group(function () {
    //Route::apiResource('users', DataUserController::class);
//});

// Route CRUD Tilik
Route::get('/tilik', [TilikController::class, 'index']); // List semua
Route::post('/tilik', [TilikController::class, 'store']); // Simpan baru
Route::get('/tilik/{id}', [TilikController::class, 'show']); // Detail by ID
Route::put('/tilik/{id}', [TilikController::class, 'update']); // Update by ID
Route::delete('/tilik/{id}', [TilikController::class, 'destroy']); // Delete by ID

Route::apiResource('response-tilik', ResponseTilikController::class);

Route::prefix('unit-kerja')->group(function() {
    Route::get('/', [DataUnitController::class, 'readAll']);
    Route::get('/{unit}', [DataUnitController::class, 'readByUnit']);
    Route::post('/{unit}', [DataUnitController::class, 'store']);
    Route::put('/{id}', [DataUnitController::class, 'update']);
    Route::delete('/{id}', [DataUnitController::class, 'destroy']);
});
