<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auditing; 
use App\Models\Kriteria;
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
            $query = LaporanTemuan::with('kriteria'); // Eager load kriteria untuk nama_kriteria

            if ($auditingId) {
                $query->where('auditing_id', $auditingId);
            }

            $laporanTemuans = $query->get()->map(function ($laporan) {
                return [
                    'laporan_temuan_id' => $laporan->laporan_temuan_id,
                    'auditing_id' => $laporan->auditing_id,
                    'kriteria_id' => $laporan->kriteria_id,
                    'nama_kriteria' => $laporan->kriteria->nama_kriteria ?? 'Tidak ada kriteria',
                    'uraian_temuan' => $laporan->uraian_temuan,
                    'kategori_temuan' => $laporan->kategori_temuan,
                    'saran_perbaikan' => $laporan->saran_perbaikan,
                ];
            });

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
            'findings.*.uraian_temuan' => 'required|string|max:1000',
            'findings.*.kategori_temuan' => 'required|in:NC,AOC,OFI',
            'findings.*.saran_perbaikan' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'Audit ID is required.',
            'auditing_id.exists' => 'Invalid audit ID.',
            'findings.required' => 'At least one finding is required.',
            'findings.*.kriteria_id.required' => 'Standard ID is required for each finding.',
            'findings.*.kriteria_id.exists' => 'Invalid standard ID for finding.',
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
                // Ensure the kriteria relationship is loaded after creation for 'nama_kriteria'
                // This is generally handled by the next call or re-fetching if needed.
                // For immediate response, you can explicitly load it or get the name.
                $laporanTemuan = LaporanTemuan::create([
                    'auditing_id' => $request->auditing_id,
                    'kriteria_id' => $finding['kriteria_id'],
                    'uraian_temuan' => $finding['uraian_temuan'],
                    'kategori_temuan' => $finding['kategori_temuan'],
                    'saran_perbaikan' => $finding['saran_perbaikan'] ?? null,
                ]);

                // To include nama_kriteria, we might need to eager load or find it
                $kriteriaName = Kriteria::find($laporanTemuan->kriteria_id)->nama_kriteria ?? 'Tidak ada kriteria';

                $createdFindings[] = [
                    'laporan_temuan_id' => $laporanTemuan->laporan_temuan_id,
                    'auditing_id' => $laporanTemuan->auditing_id,
                    'kriteria_id' => $laporanTemuan->kriteria_id,
                    'nama_kriteria' => $kriteriaName, // Get kriteria name here
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
            $laporanTemuan = LaporanTemuan::with('kriteria')->findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Laporan temuan retrieved successfully.',
                'data' => [
                    'laporan_temuan_id' => $laporanTemuan->laporan_temuan_id,
                    'auditing_id' => $laporanTemuan->auditing_id,
                    'kriteria_id' => $laporanTemuan->kriteria_id,
                    'nama_kriteria' => $laporanTemuan->kriteria->nama_kriteria ?? 'Tidak ada kriteria',
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
     * This method now updates a SINGLE LaporanTemuan record identified by $id.
     * The request body should contain the fields for that single finding.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // No 'findings' array here, validate individual fields
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'kriteria_id' => 'required|exists:kriteria,kriteria_id',
            'uraian_temuan' => 'required|string|max:1000',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'Audit ID is required.',
            'auditing_id.exists' => 'Invalid audit ID.',
            'kriteria_id.required' => 'Standard ID is required.',
            'kriteria_id.exists' => 'Invalid standard ID.',
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
            // Find the specific LaporanTemuan record by its primary key
            $laporanTemuan = LaporanTemuan::with('kriteria')->findOrFail($id);

            // Update its attributes
            $laporanTemuan->update([
                'auditing_id' => $request->auditing_id,
                'kriteria_id' => $request->kriteria_id,
                'uraian_temuan' => $request->uraian_temuan,
                'kategori_temuan' => $request->kategori_temuan,
                'saran_perbaikan' => $request->saran_perbaikan ?? null,
            ]);

            // Return the updated resource
            return response()->json([
                'status' => true,
                'message' => 'Laporan temuan updated successfully.',
                'data' => [
                    'laporan_temuan_id' => $laporanTemuan->laporan_temuan_id,
                    'auditing_id' => $laporanTemuan->auditing_id,
                    'kriteria_id' => $laporanTemuan->kriteria_id,
                    'nama_kriteria' => $laporanTemuan->kriteria->nama_kriteria ?? 'Tidak ada kriteria',
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
            // Find by primaryKey 'laporan_temuan_id'
            $laporanTemuan = LaporanTemuan::findOrFail($id); // No need to eager load kriteria for deletion
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
