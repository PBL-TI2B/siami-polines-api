<?php

namespace App\Http\Controllers\Api;

use App\Models\JenisUnit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class JenisUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $jenisUnits = JenisUnit::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Data Jenis Unit berhasil diambil',
                'data' => $jenisUnits
            ], 200);
        } catch(\exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data Jenis Unit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nama_jenis_unit' => 'required|string|max:255',
            ]);

            $jenisUnit = JenisUnit::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Jenis Unit berhasil dibuat',
                'data' => $jenisUnit
            ], 201);
        } catch(\exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat Jenis Unit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $jenisUnit = JenisUnit::find($id);

            if (!$jenisUnit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jenis Unit tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Jenis Unit berhasil ditemukan',
                'data' => $jenisUnit
            ], 200);
        } catch(\exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data Jenis Unit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $jenisUnit = JenisUnit::find($id);

            if (!$jenisUnit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jenis Unit tidak ditemukan'
                ], 404);
            }

            $validated = $request->validate([
                'nama_jenis_unit' => 'required|string|max:255',
            ]);

            $jenisUnit->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Jenis Unit berhasil diperbarui',
                'data' => $jenisUnit
            ], 200);
        } catch(\exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui Jenis Unit',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $jenisUnit = JenisUnit::find($id);

            if (!$jenisUnit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jenis Unit tidak ditemukan'
                ], 404);
            }

            $jenisUnit->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Jenis Unit berhasil dihapus'
            ], 200);
        } catch(\exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus Jenis Unit',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
