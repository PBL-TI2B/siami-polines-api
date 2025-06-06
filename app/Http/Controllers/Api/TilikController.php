<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tilik; // Pastikan Model Tilik Anda sudah benar
use Illuminate\Http\Request; // Penting: tambahkan ini untuk mengambil request
use Illuminate\Support\Facades\Validator;
use Exception;

class TilikController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request // Tambahkan Request $request di sini
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexall()
    {
        $tilik = Tilik::with('kriteria')->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Response Tilik',
            'data' => $tilik
        ], 200);
    }

    public function index(Request $request) // Tambahkan Request $request di sini
    {
        try {
            // 1. Dapatkan parameter 'page' dan 'per_page' dari request
            // Nilai default: page=1, per_page=5 (sesuai dengan select option pertama di frontend Anda)
            $perPage = $request->input('per_page', 5); // Ambil 'per_page', default 5
            $page = $request->input('page', 1);       // Ambil 'page', default 1

            // 2. Lakukan query ke database dengan paginasi menggunakan Eloquent
            $tilikPaginated = Tilik::paginate($perPage, ['*'], 'page', $page);

            // 3. Kembalikan response dalam format JSON yang sesuai dengan ekspektasi frontend
            return response()->json([
                'success' => true,
                'message' => 'List Data Tilik',
                'data'    => $tilikPaginated->items(), // Kirim item data dari paginator
                'total'   => $tilikPaginated->total(), // Total semua item (untuk paginasi di frontend)
                'per_page' => $tilikPaginated->perPage(),
                'current_page' => $tilikPaginated->currentPage(),
                'last_page' => $tilikPaginated->lastPage(),
                // Anda bisa menambahkan metadata paginasi lain jika perlu
                // 'from' => $tilikPaginated->firstItem(),
                // 'to' => $tilikPaginated->lastItem(),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage(),
                // 'data' => null // Sebaiknya tambahkan ini jika frontend mengharapkannya saat error
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kriteria_id' => 'required|integer|exists:kriteria,kriteria_id',
                'pertanyaan' => 'required|string|max:255',
                'indikator' => 'nullable|string',
                'sumber_data' => 'nullable|string',
                'metode_perhitungan' => 'nullable|string',
                'target' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tilik = Tilik::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data Tilik Berhasil Disimpan',
                'data' => $tilik
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $tilik = Tilik::find($id);

            if ($tilik) {
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Data Tilik',
                    'data' => $tilik
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Data Tilik Tidak Ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $tilik = Tilik::find($id);

            if (!$tilik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Tilik Tidak Ditemukan',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'kriteria_id' => 'required|integer|exists:kriteria,kriteria_id',
                'pertanyaan' => 'required|string|max:255',
                'indikator' => 'nullable|string',
                'sumber_data' => 'nullable|string',
                'metode_perhitungan' => 'nullable|string',
                'target' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tilik->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data Tilik Berhasil Diupdate',
                'data' => $tilik
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $tilik = Tilik::find($id);

            if (!$tilik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Tilik Tidak Ditemukan',
                ], 404);
            }

            $tilik->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Tilik Berhasil Dihapus',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(),
            ], 500);
        }
    }
}