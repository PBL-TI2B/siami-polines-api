<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanTemuan;

class LaporanTemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporan = LaporanTemuan::all();
        return response()->json([
            'status' => 'success',
            'data' => $laporan
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'standar' => 'required|string|max:255',
            'uraian_temuan' => 'required|string',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string',
            'auditing_id' => 'required|exists:auditings,auditing_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['standar', 'uraian_temuan', 'kategori_temuan', 'saran_perbaikan', 'auditing_id']);
        $laporan = LaporanTemuan::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $laporan
        ], 201);
    }

    public function show($id)
    {
        try {
            $laporan = LaporanTemuan::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Laporan not found'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $laporan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $laporan = LaporanTemuan::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Laporan not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'standar' => 'sometimes|string|max:255',
                'uraian_temuan' => 'sometimes|string',
                'kategori_temuan' => 'sometimes|in:NC,AOC,OFI',
                'saran_perbaikan' => 'nullable|string',
                'auditing_id' => 'sometimes|exists:auditings,auditing_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->only(['standar', 'uraian_temuan', 'kategori_temuan', 'saran_perbaikan', 'auditing_id']);
            $laporan->update($data);

            return response()->json([
                'status' => 'success',
                'data' => $laporan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $laporan = LaporanTemuan::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Laporan not found'
                ], 404);
            }

            $laporan->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Laporan deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
