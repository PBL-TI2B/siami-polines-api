<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PeriodeAuditController;
use App\Http\Controllers\SasaranStrategisController;
use App\Http\Controllers\API\DataUserController;
use App\Http\Controllers\Api\KriteriaController;
use App\Http\Controllers\Api\DataInstrumenUptController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// enpdoint register /api/register
// Route::post('/register', [RegisterController::class, 'register']);

// endpoint login /api/login
Route::post('/login', [AuthController::class, 'login']);

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

Route::post('/sasaran-strategis', [SasaranStrategisController::class, 'store']);

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

Route::prefix('data-instrumen')->group(function () {
    //Route::get('/data-instrumen-upt', [DataInstrumenUptController::class, 'index']);
    Route::post('/', [DataInstrumenUptController::class, 'store']);
    Route::get('/', [DataInstrumenUptController::class, 'getData']);
});

//Route::middleware(['auth:api', 'can:manage-users'])->group(function () {
    //Route::apiResource('users', DataUserController::class);
//});
