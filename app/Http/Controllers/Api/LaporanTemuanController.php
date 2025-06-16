<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LaporanTemuan;
use App\Models\Auditing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class LaporanTemuanController extends Controller
{
    /**
     * Display a listing of the laporan temuan.
     */
    public function index(): JsonResponse
    {
        $laporanTemuans = LaporanTemuan::with('kriterias', 'auditing')->get();
        return response()->json([
            'status' => true,
            'data' => $laporanTemuans,
            'message' => 'Daftar laporan temuan berhasil diambil',
        ], 200);
    }

    /**
     * Store a newly created laporan temuan in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'standar.kriteria_id' => 'required|array',
            'standar.kriteria_id.*' => 'exists:kriterias,kriteria_id',
            'standar.uraian_temuan' => 'required|array',
            'standar.uraian_temuan.*' => 'string|max:1000',
            'standar.kategori_temuan' => 'required|array',
            'standar.kategori_temuan.*' => 'in:NC,AOC,OFI',
            'standar.saran_perbaikan' => 'nullable|array',
            'standar.saran_perbaikan.*' => 'string|max:1000',
        ], [
            'auditing_id.required' => 'ID auditing wajib diisi.',
            'standar.kriteria_id.required' => 'Kriteria wajib dipilih.',
            'standar.kriteria_id.*.exists' => 'Kriteria tidak valid.',
            'standar.uraian_temuan.required' => 'Uraian temuan wajib diisi.',
            'standar.uraian_temuan.*.max' => 'Uraian temuan maksimal 1000 karakter.',
            'standar.kategori_temuan.required' => 'Kategori temuan wajib dipilih.',
            'standar.kategori_temuan.*.in' => 'Kategori temuan harus salah satu dari NC, AOC, atau OFI.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['auditing_id']);
        $standar = $request->input('standar');

        $uraianTemuans = array_map(fn($item) => str_replace(',', ';', trim($item)), $standar['uraian_temuan']);
        $kategoriTemuans = $standar['kategori_temuan'];
        $saranPerbaikans = array_map(fn($item) => !empty($item) ? str_replace(',', ';', trim($item)) : '', $standar['saran_perbaikan'] ?? []);

        DB::transaction(function () use ($data, $uraianTemuans, $kategoriTemuans, $saranPerbaikans, $standar) {
            $laporan = LaporanTemuan::create([
                'auditing_id' => $data['auditing_id'],
                'uraian_temuan' => implode(',', $uraianTemuans),
                'kategori_temuan' => implode(',', $kategoriTemuans),
                'saran_perbaikan' => implode(',', $saranPerbaikans),
            ]);

            $laporan->kriterias()->sync($standar['kriteria_id']);
        });

        return response()->json([
            'status' => true,
            'message' => 'Laporan temuan berhasil disimpan',
            'data' => LaporanTemuan::with('kriterias', 'auditing')->find($laporan->laporan_temuan_id),
        ], 201);
    }

    /**
     * Display the specified laporan temuan.
     */
    public function show($id): JsonResponse
    {
        $laporan = LaporanTemuan::with('kriterias', 'auditing')->find($id);

        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Laporan temuan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $laporan,
            'message' => 'Detail laporan temuan berhasil diambil',
        ], 200);
    }

    /**
     * Update the specified laporan temuan in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $laporan = LaporanTemuan::find($id);

        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Laporan temuan tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'standar.kriteria_id' => 'required|array',
            'standar.kriteria_id.*' => 'exists:kriterias,kriteria_id',
            'standar.uraian_temuan' => 'required|array',
            'standar.uraian_temuan.*' => 'string|max:1000',
            'standar.kategori_temuan' => 'required|array',
            'standar.kategori_temuan.*' => 'in:NC,AOC,OFI',
            'standar.saran_perbaikan' => 'nullable|array',
            'standar.saran_perbaikan.*' => 'string|max:1000',
        ], [
            'auditing_id.required' => 'ID auditing wajib diisi.',
            'standar.kriteria_id.required' => 'Kriteria wajib dipilih.',
            'standar.kriteria_id.*.exists' => 'Kriteria tidak valid.',
            'standar.uraian_temuan.required' => 'Uraian temuan wajib diisi.',
            'standar.uraian_temuan.*.max' => 'Uraian temuan maksimal 1000 karakter.',
            'standar.kategori_temuan.required' => 'Kategori temuan wajib dipilih.',
            'standar.kategori_temuan.*.in' => 'Kategori temuan harus salah satu dari NC, AOC, atau OFI.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $standar = $request->input('standar');

        $uraianTemuans = array_map(fn($item) => str_replace(',', ';', trim($item)), $standar['uraian_temuan']);
        $kategoriTemuans = $standar['kategori_temuan'];
        $saranPerbaikans = array_map(fn($item) => !empty($item) ? str_replace(',', ';', trim($item)) : '', $standar['saran_perbaikan'] ?? []);

        DB::transaction(function () use ($laporan, $uraianTemuans, $kategoriTemuans, $saranPerbaikans, $standar) {
            $laporan->update([
                'auditing_id' => $laporan->auditing_id,
                'uraian_temuan' => implode(',', $uraianTemuans),
                'kategori_temuan' => implode(',', $kategoriTemuans),
                'saran_perbaikan' => implode(',', $saranPerbaikans),
            ]);

            $laporan->kriterias()->sync($standar['kriteria_id']);
        });

        return response()->json([
            'status' => true,
            'message' => 'Laporan temuan berhasil diperbarui',
            'data' => LaporanTemuan::with('kriterias', 'auditing')->find($laporan->laporan_temuan_id),
        ], 200);
    }

    /**
     * Remove the specified laporan temuan from storage.
     */
    public function destroy($id): JsonResponse
    {
        $laporan = LaporanTemuan::find($id);

        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Laporan temuan tidak ditemukan',
            ], 404);
        }

        $laporan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Laporan temuan berhasil dihapus',
        ], 200);
    }
}

