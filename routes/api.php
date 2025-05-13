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
use App\Http\Controllers\Api\PenjadwalanController;
use App\Http\Controllers\Api\TilikController;
use App\Http\Controllers\Api\ResponseTilikController;
use App\Http\Controllers\Api\UnsurController;
use App\Http\Controllers\Api\AuditingController;
use App\Http\Controllers\Api\SidebarMenuController;
use App\Http\Controllers\Api\SasaranStrategisController;
use App\Http\Controllers\Api\IndikatorKinerjaController;
use App\Http\Controllers\Api\AktivitasController;
use App\Http\Controllers\Api\SetIntrumenController;

//route autentikasi
// endpoint login (tidak butuh regist)
Route::post('/login', [AuthController::class, 'login']);

// Endpoint untuk mendapatkan menu sidebar
Route::get('/sidebar-menu', [SidebarMenuController::class, 'getSidebarMenus']);
Route::post('/sidebar-menu', [SidebarMenuController::class, 'createMenu']);
Route::put('/sidebar-menu/{menuId}', [SidebarMenuController::class, 'updateMenu']);
Route::delete('/sidebar-menu/{menuId}', [SidebarMenuController::class, 'deleteMenu']);

// Group route yang butuh login (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // update profile
    Route::put('/user/update', [AuthController::class, 'update']);

    // logout
    Route::delete('/logout', [AuthController::class, 'logout']);
});

// route auditing -> tabel auditing
Route::prefix('auditings')->group(function () {
    Route::get('/', [AuditingController::class, 'index']);           // Menampilkan semua data auditing
    Route::post('/', [AuditingController::class, 'store']);          // Menyimpan data auditing baru
    Route::get('{id}', [AuditingController::class, 'show']);         // Menampilkan detail auditing berdasarkan ID
    Route::put('{id}', [AuditingController::class, 'update']);       // Mengupdate data auditing
    Route::delete('{id}', [AuditingController::class, 'destroy']);   // Menghapus data auditing
});

// route unit-kerja -> tabel unit_kerja
Route::prefix('unit-kerja')->group(function() {
    Route::get('/', [DataUnitController::class, 'readAll']);
    Route::get('/{unit}', [DataUnitController::class, 'readByUnit']);
    Route::post('/{unit}', [DataUnitController::class, 'store']);
    Route::put('/{id}', [DataUnitController::class, 'update']);
    Route::delete('/{id}', [DataUnitController::class, 'destroy']);
});

// route kriteria -> tabel kriteria
Route::prefix('kriteria')->controller(KriteriaController::class)->group(function () {
    Route::get('/', 'index');          // GET semua kriteria
    Route::get('/{id}', 'show');       // GET satu kriteria berdasarkan ID
    Route::post('/', 'store');         // POST satu kriteria
    Route::put('/{id}', 'update');     // PUT satu kriteria berdasarkan ID
    Route::delete('/{id}', 'destroy'); // DELETE satu kriteria berdasarkan ID
});

// route deskripsi -> tabel deskripsi
Route::prefix('deskripsi')->controller(DeskripsiController::class)->group(function () {
    Route::get('/', 'index'); // Mengambil semua deskripsi
    Route::get('/kriteria/{kriteria_id}', 'showByKriteria'); // Berdasarkan kriteria_id
    Route::post('/', 'store'); // Menambahkan deskripsi
    Route::put('/{id}', 'update'); // Memperbarui deskripsi
    Route::delete('/{id}', 'destroy'); // Menghapus deskripsi
});

// route periode audit -> tabel periode
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

// route unsur -> tabel unsur
Route::prefix('unsur')->controller(UnsurController::class)->group(function () {
    Route::get('/', 'index');         // Mengambil semua unsur
    Route::get('/{id}', 'show');      // Mengambil satu unsur berdasarkan ID
    Route::post('/', 'store');        // Menambahkan unsur
    Route::put('/{id}', 'update');    // Memperbarui unsur
    Route::delete('/{id}', 'destroy');// Menghapus unsur
});

//route tilik -> tabel tilik
Route::prefix('tilik')->controller(TilikController::class)->group(function () {
    Route::get('/', 'index');          // List semua
    Route::post('/', 'store');         // Simpan baru
    Route::get('/{id}', 'show');       // Detail by ID
    Route::put('/{id}', 'update');     // Update by ID
    Route::delete('/{id}', 'destroy'); // Delete by ID
});

Route::prefix('sasaran-strategis')->controller(SasaranStrategisController::class)->group(function () {
    Route::get('/', 'index');          // List semua
    Route::post('/', 'store');         // Simpan baru
    Route::get('/{id}', 'show');       // Detail by ID
    Route::put('/{id}', 'update');     // Update by ID
    Route::delete('/{id}', 'destroy'); // Delete by ID
});

Route::prefix('indikator-kinerja')->controller(IndikatorKinerjaController::class)->group(function () {
    Route::get('/', 'index');          // List semua
    Route::post('/', 'store');         // Simpan baru
    Route::get('/{id}', 'show');       // Detail by ID
    Route::put('/{id}', 'update');     // Update by ID
    Route::delete('/{id}', 'destroy'); // Delete by ID
});

Route::prefix('aktivitas')->controller(AktivitasController::class)->group(function () {
    Route::get('/', 'index');          // List semua
    Route::post('/', 'store');         // Simpan baru
    Route::get('/{id}', 'show');       // Detail by ID
    Route::put('/{id}', 'update');     // Update by ID
    Route::delete('/{id}', 'destroy'); // Delete by ID
});

Route::prefix('data-user')->controller(DataUserController::class)->group(function () {
    Route::get('/', 'index');               // List all users
    Route::post('/', 'store');              // Create a new user
    Route::get('/{id}', 'show');            // Get by ID
    Route::put('/{id}', 'update');          // Update by ID
    Route::delete('/{id}', 'destroy');      // Delete by ID
    Route::delete('/bulk-destroy', 'bulkDelete'); // Bulk delete users
});

Route::prefix('jenis-units')->controller(JenisUnitController::class)->group(function () {
    Route::get('/', 'index');           // List semua
    Route::post('/', 'store');          // Simpan baru
    Route::get('/{id}', 'show');        // Detail by ID
    Route::put('/{id}', 'update');      // Update by ID
    Route::delete('/{id}', 'destroy');  // Delete by ID
});


// dibawah ini route gatauuu >_<

// Route::post('/sasaran-strategis', [SasaranStrategisController::class, 'store']);
Route::apiResource('data-instrumen', DataInstrumenUptController::class);
//Route::middleware(['auth:api', 'can:manage-users'])->group(function () {
    //Route::apiResource('users', DataUserController::class);
//});
Route::apiResource('response-tilik', ResponseTilikController::class);

Route::prefix('penjadwalan')->group(function(){
    Route::post('/', [PenjadwalanController::class, 'store']);
    Route::get('/', [PenjadwalanController::class, 'readAll']);
    Route::put('/{id}', [PenjadwalanController::class, 'edit']);
    Route::delete('/', [PenjadwalanController::class, 'delete']);
});

Route::prefix('set-instrumen')->group(function(){
    Route::post('/', [SetIntrumenController::class, 'store']);
    Route::get('/', [SetIntrumenController::class, 'readAll']);
    Route::put('/{id}', [SetIntrumenController::class, 'update']);
    Route::delete('/{id}', [SetIntrumenController::class, 'destroy']);
});
