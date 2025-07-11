<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ResponseTilik;
use Illuminate\Http\Request;
use Exception;

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
            'realisasi' => 'string|nullable',
            'standar_nasional' => 'string|nullable',
            'uraian_isian' => 'string|nullable',
            'akar_penyebab_penunjang' => 'string|nullable',
            'rencana_perbaikan_tindak_lanjut' => 'string|nullable',
            'tindakan_pencegahan' => 'string|nullable',
        ]);

        $responseTilik = new ResponseTilik();
        $responseTilik->auditing_id = $request->auditing_id;
        $responseTilik->tilik_id = $request->tilik_id;
        $responseTilik->realisasi = $request->realisasi;
        $responseTilik->standar_nasional = $request->standar_nasional;
        $responseTilik->uraian_isian = $request->uraian_isian;
        $responseTilik->akar_penyebab_penunjang = $request->akar_penyebab_penunjang;
        $responseTilik->rencana_perbaikan_tindak_lanjut = $request->rencana_perbaikan_tindak_lanjut;
        $responseTilik->tindakan_pencegahan = $request->tindakan_pencegahan;
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
                'rencana_perbaikan_tindak_lanjut' => $responseTilik->rencana_perbaikan_tindak_lanjut,
                'tindakan_pencegahan' => $responseTilik->tindakan_pencegahan
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
            'realisasi' => 'string|nullable',
            'standar_nasional' => 'string|nullable',
            'uraian_isian' => 'string|nullable',
            'akar_penyebab_penunjang' => 'string|nullable',
            'rencana_perbaikan_tindak_lanjut' => 'string|nullable',
            'tindakan_pencegahan' => 'string|nullable',
        ]);

        // Update data yang sudah ada
        $responseTilik->auditing_id = $request->auditing_id;
        $responseTilik->tilik_id = $request->tilik_id;
        $responseTilik->realisasi = $request->realisasi;
        $responseTilik->standar_nasional = $request->standar_nasional;
        $responseTilik->uraian_isian = $request->uraian_isian;
        $responseTilik->akar_penyebab_penunjang = $request->akar_penyebab_penunjang;
        $responseTilik->rencana_perbaikan_tindak_lanjut = $request->rencana_perbaikan_tindak_lanjut;
        $responseTilik->tindakan_pencegahan = $request->tindakan_pencegahan;
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
                'rencana_perbaikan_tindak_lanjut' => $responseTilik->rencana_perbaikan_tindak_lanjut,
                'tindakan_pencegahan' => $responseTilik->tindakan_pencegahan
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

    public function getByAuditingId($auditing_id)
    {
        try {
            $responseTilik = ResponseTilik::with(['auditing', 'tilik'])
                ->where('auditing_id', $auditing_id)
                ->get();

            if ($responseTilik->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No response tilik found for the given auditing ID'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Response tilik retrieved successfully',
                'data' => $responseTilik
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve response tilik: ' . $e->getMessage()
            ], 500);
        }
    }
}
