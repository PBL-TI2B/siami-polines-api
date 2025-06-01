<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ResponseTilik;
use Illuminate\Http\Request;

class ResponseTilikController extends Controller
{
    public function index()
    {
        $responseTilik = ResponseTilik::with([
            'auditing',
            'tilik',
            'tilik.kriteria',
            'auditing.auditee1.role',
            'auditing.auditee1.unitkerja'
        ])->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Response Tilik',
            'data' => $responseTilik
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'tilik_id' => 'required|exists:tilik,tilik_id',
            'realisasi' => 'required|string',
            'standar_nasional' => 'required|string',
            'uraian_isian' => 'required|string',
            'akar_penyebab_penunjang' => 'required|string',
            'rencana_perbaikan_tindak_lanjut' => 'required|string',
        ]);

        $responseTilik = new ResponseTilik();
        $responseTilik->auditing_id = $request->auditing_id;
        $responseTilik->tilik_id = $request->tilik_id;
        $responseTilik->realisasi = $request->realisasi;
        $responseTilik->standar_nasional = $request->standar_nasional;
        $responseTilik->uraian_isian = $request->uraian_isian;
        $responseTilik->akar_penyebab_penunjang = $request->akar_penyebab_penunjang;
        $responseTilik->rencana_perbaikan_tindak_lanjut = $request->rencana_perbaikan_tindak_lanjut;
        $responseTilik->save();

        $responseTilik->load('auditing', 'tilik');

        return response()->json([
            'message' => 'Response Tilik berhasil ditambahkan.',
            'data' => [
                'auditing_id' => $responseTilik->auditing->auditing_id ?? null,
                'tilik_id' => $responseTilik->tilik->tilik_id ?? null,
                'realisasi' => $responseTilik->realisasi,
                'standar_nasional' => $responseTilik->standar_nasional,
                'uraian_isian' => $responseTilik->uraian_isian,
                'akar_penyebab_penunjang' => $responseTilik->akar_penyebab_penunjang,
                'rencana_perbaikan_tindak_lanjut' => $responseTilik->rencana_perbaikan_tindak_lanjut
            ]
        ], 201);
    }

    public function show($id)
    {
        $responseTilik = ResponseTilik::findOrFail($id);
        return response()->json($responseTilik);
    }

    public function update(Request $request, string $id)
    {
        $responseTilik = ResponseTilik::find($id);

        if (!$responseTilik) {
            return response()->json([
                'message' => 'Response Tilik tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'tilik_id' => 'required|exists:tilik,tilik_id',
            'realisasi' => 'required|string',
            'standar_nasional' => 'required|string',
            'uraian_isian' => 'required|string',
            'akar_penyebab_penunjang' => 'required|string',
            'rencana_perbaikan_tindak_lanjut' => 'required|string',
        ]);

        // Update data yang sudah ada
        $responseTilik->auditing_id = $request->auditing_id;
        $responseTilik->tilik_id = $request->tilik_id;
        $responseTilik->realisasi = $request->realisasi;
        $responseTilik->standar_nasional = $request->standar_nasional;
        $responseTilik->uraian_isian = $request->uraian_isian;
        $responseTilik->akar_penyebab_penunjang = $request->akar_penyebab_penunjang;
        $responseTilik->rencana_perbaikan_tindak_lanjut = $request->rencana_perbaikan_tindak_lanjut;
        $responseTilik->save();

        $responseTilik->load('auditing', 'tilik');

        return response()->json([
            'success' => true,
            'message' => 'Response Tilik berhasil diperbarui.',
            'data' => [
                'auditing_id' => $responseTilik->auditing->auditing_id ?? null,
                'tilik_id' => $responseTilik->tilik->tilik_id ?? null,
                'realisasi' => $responseTilik->realisasi,
                'standar_nasional' => $responseTilik->standar_nasional,
                'uraian_isian' => $responseTilik->uraian_isian,
                'akar_penyebab_penunjang' => $responseTilik->akar_penyebab_penunjang,
                'rencana_perbaikan_tindak_lanjut' => $responseTilik->rencana_perbaikan_tindak_lanjut
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $responseTilik = ResponseTilik::findOrFail($id);
        $responseTilik->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil dihapus'
        ]);
    }
}
