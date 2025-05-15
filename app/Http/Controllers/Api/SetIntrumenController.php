<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SetInstrumen;
use App\Models\Kriteria;
use App\Models\Deskripsi;
use App\Models\Unsur;
use Illuminate\Http\Request;

class SetIntrumenController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input untuk setiap item dalam array
            $validatedData = $request->validate([
                '*.unit_kerja_id' => 'required|integer|exists:unit_kerja,unit_kerja_id',
                '*.aktivitas_id' => 'nullable|integer|exists:aktivitas,aktivitas_id',
                '*.unsur.isi_unsur' => 'required|string|max:255',
                '*.unsur.deskripsi.isi_deskripsi' => 'required|string|max:255', // Perbaikan notasi
                '*.unsur.deskripsi.kriteria.nama_kriteria' => 'required|string|exists:kriteria,nama_kriteria',
            ]);

            $payload = $request->all();

            foreach ($payload as $item) {
                $unitKerjaId = $item['unit_kerja_id'];
                $aktivitasId = $item['aktivitas_id'] ?? null;
                $isiUnsur = $item['unsur']['isi_unsur'];
                $isiDeskripsi = $item['unsur']['deskripsi']['isi_deskripsi']; // Perbaikan akses
                $namaKriteria = $item['unsur']['deskripsi']['kriteria']['nama_kriteria']; // Perbaikan akses

                // Cari atau buat kriteria
                $kriteria = Kriteria::firstOrCreate(
                    ['nama_kriteria' => $namaKriteria],
                    ['nama_kriteria' => $namaKriteria]
                );

                // Cari atau buat deskripsi
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

                // Cari atau buat unsur
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

                // Buat entri SetInstrumen
                SetInstrumen::create([
                    'unit_kerja_id' => $unitKerjaId,
                    'aktivitas_id' => $aktivitasId,
                    'unsur_id' => $unsur->unsur_id,
                ]);
            }

            return response()->json([
                'message' => 'Set Instrumen berhasil diupload',
                'data' => $payload
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function readAll() {
        $setInstrumen = SetInstrumen::with([
            'unitKerja',
            'aktivitas',
            'unsur.deskripsi.kriteria' // include relasi berantai agar eager loading optimal
        ])->get();

        return response()->json([
            'message' => 'Data SetInstrumen berhasil ditampilkan',
            'data' => $setInstrumen,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'unit_kerja_id' => 'nullable|integer|exists:unit_kerja,unit_kerja_id',
                'aktivitas_id' => 'nullable|integer|exists:aktivitas,aktivitas_id',
                'unsur_id' => 'nullable|integer|exists:unsur,unsur_id',
            ]);

            $setInstrumen = SetInstrumen::where('set_instrumen_unit_kerja_id', $id)->first();
            if (!$setInstrumen) {
                return response()->json(['message' => 'Data auditing tidak ditemukan'], 404);
            }

            $setInstrumen->update([
                'unit_kerja_id' => $request->unit_kerja_id,
                'aktivitas_id' => $request->aktivitas_id,
                'unsur_id' => $request->unsur_id,
            ]);

            return response()->json([
                'message' => 'Set Instrumen berhasil diperbarui',
                'data' => $setInstrumen
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
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
