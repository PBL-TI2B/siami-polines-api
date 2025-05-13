<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class DataUserController extends Controller
{
    /**
     * Display a listing of the users with their role and unitKerja.
     */
    public function index(): JsonResponse
    {
        try {
            $users = User::with(['role', 'unitKerja'])->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Data user berhasil diambil',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = Validator::make($request->all(), [
                'role_id' => 'required|integer|exists:roles,role_id',
                'unit_kerja_id' => 'required|integer|exists:unit_kerja,unit_kerja_id',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|unique:users,nip'
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validated->errors()
                ], 422);
            }

            $user = User::create([
                'role_id' => $request->role_id,
                'unit_kerja_id' => $request->unit_kerja_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'nip' => $request->nip
            ]);

            $user->load(['role', 'unitKerja']);

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dibuat',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified user with their role and unitKerja.
     */
    public function show($id): JsonResponse
    {
        try {
            $user = User::with(['role', 'unitKerja'])->find($id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data user berhasil diambil',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            $validated = Validator::make($request->all(), [
                'role_id' => 'required|integer|exists:roles,role_id',
                'unit_kerja_id' => 'required|integer|exists:unit_kerja,unit_kerja_id',
                'email' => 'required|email|unique:users,email,'.$id.',user_id',
                'password' => 'nullable|string|min:6',
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|unique:users,nip,'.$id.',user_id'
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validated->errors()
                ], 422);
            }

            $user->update([
                'role_id' => $request->role_id,
                'unit_kerja_id' => $request->unit_kerja_id,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'nama' => $request->nama,
                'nip' => $request->nip
            ]);

            $user->load(['role', 'unitKerja']);

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil diperbarui',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            if ($user->auditor1Auditings()->exists() ||
                $user->auditor2Auditings()->exists() ||
                $user->auditee1Auditings()->exists() ||
                $user->auditee2Auditings()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak dapat menghapus user yang terlibat dalam audit'
                ], 422);
            }

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete users.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        try {
            $ids = $request->input('selected_users', []);

            if (empty($ids)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada user yang dipilih'
                ], 422);
            }

            $users = User::whereIn('user_id', $ids)->get();

            foreach ($users as $user) {
                if ($user->auditor1Auditings()->exists() ||
                    $user->auditor2Auditings()->exists() ||
                    $user->auditee1Auditings()->exists() ||
                    $user->auditee2Auditings()->exists()) {
                    continue; // Skip users involved in audits
                }

                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $user->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User yang dipilih berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
