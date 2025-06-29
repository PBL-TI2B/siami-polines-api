<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auditing;
use App\Models\Kriteria;
use App\Models\ResponseTilik;
use App\Models\LaporanTemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LaporanTemuanController extends Controller
{
    /**
     * Display a listing of laporan temuan.
     */
    public function index(Request $request)
    {
        try {
            $auditingId = $request->query('auditing_id');

            // Use with() to eager load all necessary relationships
            $query = LaporanTemuan::with([
                'kriteria',
                'response_tilik',
                'auditing'
            ]);

            if ($auditingId) {
                $query->where('auditing_id', $auditingId);
            }

            $laporanTemuans = $query->get();

            return response()->json([
                'status' => true,
                'message' => 'Laporan temuan retrieved successfully.',
                'data' => $laporanTemuans,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching laporan temuan: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve laporan temuan.',
            ], 500);
        }
    }

    /**
     * Store a new laporan temuan.
     * This method correctly handles creating multiple findings in a single request.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'findings' => 'required|array|min:1',
            'findings.*.kriteria_id' => 'required|exists:kriteria,kriteria_id',
            'findings.*.response_tilik_id' => 'nullable|exists:response_tilik,response_tilik_id',
            'findings.*.uraian_temuan' => 'required|string|max:1000',
            'findings.*.kategori_temuan' => 'required|in:NC,AOC,OFI',
            'findings.*.saran_perbaikan' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'Audit ID is required.',
            'auditing_id.exists' => 'Invalid audit ID.',
            'findings.required' => 'At least one finding is required.',
            'findings.*.kriteria_id.required' => 'Standard ID is required for each finding.',
            'findings.*.kriteria_id.exists' => 'Invalid standard ID for finding.',
            'findings.*.response_tilik_id.exists' => 'Invalid response tilik ID for finding.',
            'findings.*.uraian_temuan.required' => 'Finding description is required.',
            'findings.*.kategori_temuan.required' => 'Finding category is required.',
            'findings.*.kategori_temuan.in' => 'Finding category must be NC, AOC, or OFI.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed for storing laporan temuan: ' . json_encode($validator->errors()));
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $createdFindings = [];
            foreach ($request->findings as $finding) {
                // 1. Create the LaporanTemuan record
                $laporanTemuan = LaporanTemuan::create([
                    'auditing_id' => $request->auditing_id,
                    'kriteria_id' => $finding['kriteria_id'],
                    'response_tilik_id' => $finding['response_tilik_id'] ?? null,
                    'uraian_temuan' => $finding['uraian_temuan'],
                    'kategori_temuan' => $finding['kategori_temuan'],
                    'saran_perbaikan' => $finding['saran_perbaikan'] ?? null,
                ]);

                // 2. Load the relationships after creation
                $laporanTemuan->load('kriteria', 'response_tilik');

                // 3. Prepare the data for the response
                $createdFindings[] = [
                    'laporan_temuan_id' => $laporanTemuan->laporan_temuan_id,
                    'auditing_id' => $laporanTemuan->auditing_id,
                    'kriteria_id' => $laporanTemuan->kriteria_id,
                    'nama_kriteria' => $laporanTemuan->kriteria->nama_kriteria ?? 'Tidak ada kriteria',
                    'response_tilik_id' => $laporanTemuan->response_tilik_id,
                    'standar' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->standar_nasional ?? 'Tidak ada standar') : 'Tidak ada standar',
                    'analisis_penyebab' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->akar_penyebab_penunjang ?? 'Tidak ada penyebab') : 'Tidak ada penyebab',
                    'tindakan_perbaikan' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->rencana_perbaikan_tindak_lanjut ?? 'Tidak ada rencana perbaikan') : 'Tidak ada rencana perbaikan',
                    'uraian_temuan' => $laporanTemuan->uraian_temuan,
                    'kategori_temuan' => $laporanTemuan->kategori_temuan,
                    'saran_perbaikan' => $laporanTemuan->saran_perbaikan,
                ];
            }

            return response()->json([
                'status' => true,
                'message' => 'Laporan temuan created successfully.',
                'data' => $createdFindings,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error storing laporan temuan: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to create laporan temuan.',
            ], 500);
        }
    }

    /**
     * Display the specified laporan temuan.
     */
    public function show($id)
    {
        try {
            // Find by primaryKey 'laporan_temuan_id'
            $laporanTemuan = LaporanTemuan::with('kriteria', 'response_tilik')->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Laporan temuan retrieved successfully.',
                'data' => [
                    'laporan_temuan_id' => $laporanTemuan->laporan_temuan_id,
                    'auditing_id' => $laporanTemuan->auditing_id,
                    'kriteria_id' => $laporanTemuan->kriteria_id,
                    'nama_kriteria' => $laporanTemuan->kriteria->nama_kriteria ?? 'Tidak ada kriteria',
                    'response_tilik_id' => $laporanTemuan->response_tilik_id,
                    'standar' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->standar_nasional ?? 'Tidak ada standar') : 'Tidak ada standar',
                    'analisis_penyebab' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->akar_penyebab_penunjang ?? 'Tidak ada penyebab') : 'Tidak ada penyebab',
                    'tindakan_perbaikan' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->rencana_perbaikan_tindak_lanjut ?? 'Tidak ada rencana perbaikan') : 'Tidak ada rencana perbaikan',
                    'uraian_temuan' => $laporanTemuan->uraian_temuan,
                    'kategori_temuan' => $laporanTemuan->kategori_temuan,
                    'saran_perbaikan' => $laporanTemuan->saran_perbaikan,
                ],
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Laporan temuan not found: ' . $id);
            return response()->json([
                'status' => false,
                'message' => 'Laporan temuan not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching laporan temuan: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve laporan temuan.',
            ], 500);
        }
    }

    /**
     * Update the specified laporan temuan.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'kriteria_id' => 'required|exists:kriteria,kriteria_id',
            'response_tilik_id' => 'nullable|exists:response_tilik,response_tilik_id',
            'uraian_temuan' => 'required|string|max:1000',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'Audit ID is required.',
            'auditing_id.exists' => 'Invalid audit ID.',
            'kriteria_id.required' => 'Standard ID is required.',
            'kriteria_id.exists' => 'Invalid standard ID.',
            'response_tilik_id.exists' => 'Invalid response tilik ID.',
            'uraian_temuan.required' => 'Finding description is required.',
            'kategori_temuan.required' => 'Finding category is required.',
            'kategori_temuan.in' => 'Finding category must be NC, AOC, or OFI.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed for updating laporan temuan: ' . json_encode($validator->errors()));
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $laporanTemuan = LaporanTemuan::with('kriteria', 'response_tilik')->findOrFail($id);

            $laporanTemuan->update([
                'auditing_id' => $request->auditing_id,
                'kriteria_id' => $request->kriteria_id,
                'response_tilik_id' => $request->response_tilik_id ?? null,
                'uraian_temuan' => $request->uraian_temuan,
                'kategori_temuan' => $request->kategori_temuan,
                'saran_perbaikan' => $request->saran_perbaikan ?? null,
            ]);

            // Reload relationships after update
            $laporanTemuan->load('kriteria', 'response_tilik');

            return response()->json([
                'status' => true,
                'message' => 'Laporan temuan updated successfully.',
                'data' => [
                    'laporan_temuan_id' => $laporanTemuan->laporan_temuan_id,
                    'auditing_id' => $laporanTemuan->auditing_id,
                    'kriteria_id' => $laporanTemuan->kriteria_id,
                    'nama_kriteria' => $laporanTemuan->kriteria->nama_kriteria ?? 'Tidak ada kriteria',
                    'response_tilik_id' => $laporanTemuan->response_tilik_id,
                    'standar' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->standar_nasional ?? 'Tidak ada standar') : 'Tidak ada standar',
                    'analisis_penyebab' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->akar_penyebab_penunjang ?? 'Tidak ada penyebab') : 'Tidak ada penyebab',
                    'tindakan_perbaikan' => $laporanTemuan->response_tilik ? ($laporanTemuan->response_tilik->rencana_perbaikan_tindak_lanjut ?? 'Tidak ada rencana perbaikan') : 'Tidak ada rencana perbaikan',
                    'uraian_temuan' => $laporanTemuan->uraian_temuan,
                    'kategori_temuan' => $laporanTemuan->kategori_temuan,
                    'saran_perbaikan' => $laporanTemuan->saran_perbaikan,
                ],
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Laporan temuan not found for update: ' . $id);
            return response()->json([
                'status' => false,
                'message' => 'Laporan temuan not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating laporan temuan: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to update laporan temuan.',
            ], 500);
        }
    }

    /**
     * Remove the specified laporan temuan.
     */
    public function destroy($id)
    {
        try {
            $laporanTemuan = LaporanTemuan::findOrFail($id);
            $laporanTemuan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Laporan temuan deleted successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Laporan temuan not found for deletion: ' . $id);
            return response()->json([
                'status' => false,
                'message' => 'Laporan temuan not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting laporan temuan: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete laporan temuan.',
            ], 500);
        }
    }
}
