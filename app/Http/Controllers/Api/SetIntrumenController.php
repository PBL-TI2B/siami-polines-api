<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SetInstrumen;
use App\Models\Kriteria;
use App\Models\Deskripsi;
use App\Models\Unsur;
use App\Models\JenisUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SetIntrumenController extends Controller
{
    public function store(Request $request)
    {
        try {
            
            // Validasi input untuk setiap item dalam array
            $validatedData = $request->validate([
                '*.jenis_unit_id' => 'required|integer|exists:jenis_units,jenis_unit_id',
                '*.aktivitas_id' => 'nullable|integer|exists:aktivitas,aktivitas_id',
                '*.unsur.isi_unsur' => 'required|string|max:255',
                '*.unsur.deskripsi.isi_deskripsi' => 'required|string|max:255',
                '*.unsur.deskripsi.kriteria.nama_kriteria' => 'required|string|max:255',
            ]);

            $payload = $request->all();
            $createdRecords = [];

            DB::transaction(function () use ($payload, &$createdRecords) {
                foreach ($payload as $item) {
                    $jenisUnitId = $item['jenis_unit_id'];
                    $aktivitasId = $item['aktivitas_id'] ?? null;
                    $isiUnsur = $item['unsur']['isi_unsur'];
                    $isiDeskripsi = $item['unsur']['deskripsi']['isi_deskripsi'];
                    $namaKriteria = $item['unsur']['deskripsi']['kriteria']['nama_kriteria'];

                    $kriteria = Kriteria::firstOrCreate(
                        ['nama_kriteria' => $namaKriteria],
                        ['nama_kriteria' => $namaKriteria]
                    );

                    $deskripsi = Deskripsi::firstOrCreate(
                        [
                            'isi_deskripsi' => $isiDeskripsi,
                            'kriteria_id' => $kriteria->kriteria_id
                        ],
                        [
                            'isi_deskripsi' => $isiDeskripsi,
                            'kriteria_id' => $kriteria->kriteria_id
                        ]
                    );

                    $unsur = Unsur::firstOrCreate(
                        [
                            'isi_unsur' => $isiUnsur,
                            'deskripsi_id' => $deskripsi->deskripsi_id
                        ],
                        [
                            'isi_unsur' => $isiUnsur,
                            'deskripsi_id' => $deskripsi->deskripsi_id
                        ]
                    );

                    $setInstrumen = new SetInstrumen([
                        'jenis_unit_id' => $jenisUnitId,
                        'aktivitas_id' => $aktivitasId,
                        'unsur_id' => $unsur->unsur_id,
                    ]);
                    $setInstrumen->save();

                    $createdRecords[] = $setInstrumen;
                }
            });

            return response()->json([
                'message' => 'Set Instrumen berhasil diupload',
                'data' => $createdRecords
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'error' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in store:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses data',
                'error' => 'Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }

    public function readAll() {
        $setInstrumen = SetInstrumen::with([
            'jenisunit',
            'aktivitas',
            'unsur.deskripsi.kriteria' // include relasi berantai agar eager loading optimal
        ])->get();

        return response()->json([
            'message' => 'Data SetInstrumen berhasil ditampilkan',
            'data' => $setInstrumen,
        ], 200);
    }

    public function show($id)
    {
        try {
            Log::info("Fetching SetInstrumen with set_instrumen_unit_kerja_id: {$id}");

            // Mengambil SetInstrumen dengan relasi menggunakan eager loading
            $setInstrumen = SetInstrumen::with(['jenisunit', 'aktivitas', 'unsur.deskripsi.kriteria'])
                ->findOrFail($id);

            return response()->json([
                'message' => 'Set Instrumen berhasil diambil',
                'data' => $setInstrumen
            ], 200);
        } catch (ModelNotFoundException $e) {
            Log::warning("SetInstrumen not found for set_instrumen_unit_kerja_id: {$id}");
            return response()->json([
                'status' => 'error',
                'message' => 'Set Instrumen tidak ditemukan',
                'error' => 'Data dengan ID tersebut tidak ada.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error in show:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => 'Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info("Updating SetInstrumen with set_instrumen_unit_kerja_id: {$id}", ['payload' => $request->all()]);

            // Validasi input untuk objek tunggal
            $validatedData = $request->validate([
                'jenis_unit_id' => 'required|integer|exists:jenis_units,jenis_unit_id',
                'aktivitas_id' => 'nullable|integer|exists:aktivitas,aktivitas_id',
                'unsur.isi_unsur' => 'required|string|max:255',
                'unsur.deskripsi.isi_deskripsi' => 'required|string|max:255',
                'unsur.deskripsi.kriteria.nama_kriteria' => 'required|string|max:255',
            ]);

            $payload = $request->all();
            $updatedRecord = null;

            DB::transaction(function () use ($payload, $id, &$updatedRecord) {
                // Temukan SetInstrumen yang akan diperbarui
                $setInstrumen = SetInstrumen::findOrFail($id);

                $jenisUnitId = $payload['jenis_unit_id'];
                $aktivitasId = $payload['aktivitas_id'] ?? null;
                $isiUnsur = $payload['unsur']['isi_unsur'];
                $isiDeskripsi = $payload['unsur']['deskripsi']['isi_deskripsi'];
                $namaKriteria = $payload['unsur']['deskripsi']['kriteria']['nama_kriteria'];

                Log::info("Processing update for jenis_unit_id: {$jenisUnitId}");

                // Temukan atau buat Kriteria
                $kriteria = Kriteria::firstOrCreate(
                    ['nama_kriteria' => $namaKriteria],
                    ['nama_kriteria' => $namaKriteria]
                );

                // Temukan Deskripsi terkait atau perbarui
                $deskripsi = Deskripsi::where('deskripsi_id', $setInstrumen->unsur->deskripsi_id)->first();
                if ($deskripsi) {
                    $deskripsi->update([
                        'isi_deskripsi' => $isiDeskripsi,
                        'kriteria_id' => $kriteria->kriteria_id
                    ]);
                } else {
                    $deskripsi = Deskripsi::create([
                        'isi_deskripsi' => $isiDeskripsi,
                        'kriteria_id' => $kriteria->kriteria_id
                    ]);
                }

                // Temukan Unsur terkait atau perbarui
                $unsur = Unsur::where('unsur_id', $setInstrumen->unsur_id)->first();
                if ($unsur) {
                    $unsur->update([
                        'isi_unsur' => $isiUnsur,
                        'deskripsi_id' => $deskripsi->deskripsi_id
                    ]);
                } else {
                    $unsur = Unsur::create([
                        'isi_unsur' => $isiUnsur,
                        'deskripsi_id' => $deskripsi->deskripsi_id
                    ]);
                }

                // Perbarui SetInstrumen
                $setInstrumen->update([
                    'jenis_unit_id' => $jenisUnitId,
                    'aktivitas_id' => $aktivitasId,
                    'unsur_id' => $unsur->unsur_id,
                ]);

                $updatedRecord = $setInstrumen;
            });

            return response()->json([
                'message' => 'Set Instrumen berhasil diperbarui',
                'data' => $updatedRecord
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'error' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            Log::warning("SetInstrumen not found for set_instrumen_unit_kerja_id: {$id}");
            return response()->json([
                'status' => 'error',
                'message' => 'Set Instrumen tidak ditemukan',
                'error' => 'Data dengan ID tersebut tidak ada.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error in update:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses data',
                'error' => 'Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }

    public function destroy($id) {
        $setInstrumen = SetInstrumen::where('set_instrumen_unit_kerja_id', $id)->first();

        if(!$setInstrumen) {
            return response()->json([
                'message' => 'Instrumen tidak ditemukan'
            ], 404);
        }

        $setInstrumen->delete();
        return response()->json([
            'message' => 'Instrumen berhasil dihapus'
        ]);
    }
}
