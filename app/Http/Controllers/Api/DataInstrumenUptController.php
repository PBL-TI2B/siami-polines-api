<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IndikatorKinerja;
use App\Models\SasaranStrategis;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataInstrumenUptController extends Controller
{
    public function index()
    {
        $data=SasaranStrategis::with(['indikatorKinerja','indikatorKinerja.aktivitas'])->get();
        return response()->json($data);

    }

    public function show($id)
    {
        try {
            $sasaran = SasaranStrategis::with(['indikatorKinerja.aktivitas'])->findOrFail($id);
            return response()->json([$sasaran->toArray()], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memuat data: ' . $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            '*.nama_sasaran' => 'required|string|max:255',
            '*.indikator_kinerja' => 'required|array',
            '*.indikator_kinerja.*.isi_indikator_kinerja' => 'required|string|max:255',
            '*.indikator_kinerja.*.aktivitas' => 'required|array',
            '*.indikator_kinerja.*.aktivitas.*.nama_aktivitas' => 'required|string|max:255',
            '*.indikator_kinerja.*.aktivitas.*.satuan' => 'required|string|max:50',
            '*.indikator_kinerja.*.aktivitas.*.target' => 'nullable|numeric',
        ]);

        try {
            // Gunakan transaksi untuk memastikan data tersimpan dengan aman
            DB::beginTransaction();

            $results = [];

            // Loop untuk setiap sasaran strategis
            foreach ($validated as $sasaranData) {
                // Insert ke tabel sasaran_strategis
                $sasaranStrategis = new SasaranStrategis();
                $sasaranStrategis->nama_sasaran = $sasaranData['nama_sasaran'];
                $sasaranStrategis->save();

                // Loop untuk setiap indikator kinerja
                foreach ($sasaranData['indikator_kinerja'] as $indikatorData) {
                    // Insert ke tabel indikator_kinerja
                    $indikatorKinerja = new IndikatorKinerja();
                    $indikatorKinerja->sasaran_strategis_id = $sasaranStrategis->sasaran_strategis_id;
                    $indikatorKinerja->isi_indikator_kinerja = $indikatorData['isi_indikator_kinerja'];
                    $indikatorKinerja->save();

                    // Loop untuk setiap aktivitas dalam indikator kinerja
                    foreach ($indikatorData['aktivitas'] as $aktivitasData) {
                        // Insert ke tabel aktivitas
                        $aktivitas = new Aktivitas();
                        $aktivitas->indikator_kinerja_id = $indikatorKinerja->indikator_kinerja_id;
                        $aktivitas->nama_aktivitas = $aktivitasData['nama_aktivitas'];
                        $aktivitas->satuan = $aktivitasData['satuan'];
                        $aktivitas->target = $aktivitasData['target'];
                        $aktivitas->save();
                    }
                }

                // Simpan hasil untuk response
                $results[] = $sasaranStrategis->load('indikatorKinerja.aktivitas');
            }

            // Commit transaksi jika semua berhasil
            DB::commit();

            return response()->json([
                'message' => 'Data berhasil disimpan!',
                'data' => $results
            ], 201);

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            '*.nama_sasaran' => 'required|string|max:255',
            '*.indikator_kinerja' => 'required|array',
            '*.indikator_kinerja.*.isi_indikator_kinerja' => 'required|string|max:255',
            '*.indikator_kinerja.*.aktivitas' => 'required|array',
            '*.indikator_kinerja.*.aktivitas.*.nama_aktivitas' => 'required|string|max:255',
            '*.indikator_kinerja.*.aktivitas.*.satuan' => 'required|string|max:50',
            '*.indikator_kinerja.*.aktivitas.*.target' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Temukan SasaranStrategis
            $sasaran = SasaranStrategis::findOrFail($id);

            // Hapus semua IndikatorKinerja dan Aktivitas terkait
            $sasaran->indikatorKinerja()->delete();

            // Perbarui nama sasaran
            $sasaran->update([
                'nama_sasaran' => $request->input('0.nama_sasaran'),
            ]);

            // Tambahkan IndikatorKinerja dan Aktivitas baru
            foreach ($request->input('0.indikator_kinerja') as $indikatorData) {
                $indikator = $sasaran->indikatorKinerja()->create([
                    'isi_indikator_kinerja' => $indikatorData['isi_indikator_kinerja'],
                ]);

                foreach ($indikatorData['aktivitas'] as $aktivitasData) {
                    $indikator->aktivitas()->create([
                        'nama_aktivitas' => $aktivitasData['nama_aktivitas'],
                        'satuan' => $aktivitasData['satuan'],
                        'target' => $aktivitasData['target'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Data berhasil diperbarui',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

}