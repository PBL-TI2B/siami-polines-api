<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DataUserController extends Controller
{
    /**
     * Display a listing of the users with their role and unitKerja.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $users = User::with(['role', 'unitKerja'])->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Users retrieved successfully',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|integer|exists:roles,role_id',
                'unit_kerja_id' => 'required|integer|exists:unit_kerja,unit_kerja_id',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|unique:users,nip'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
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
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified user with their role and unitKerja.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $user = User::with(['role', 'unitKerja'])->find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User retrieved successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'role_id' => 'required|integer|exists:roles,role_id',
                'unit_kerja_id' => 'required|integer|exists:unit_kerja,unit_kerja_id',
                'email' => 'required|email|unique:users,email,'.$id.',user_id',
                'password' => 'nullable|string|min:6',
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|unique:users,nip,'.$id.',user_id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
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
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            if ($user->auditor1Auditings()->exists() ||
                $user->auditor2Auditings()->exists() ||
                $user->auditee1Auditings()->exists() ||
                $user->auditee2Auditings()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot delete user, associated with auditing records'
                ], 422);
            }

            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_users', []);

        \Log::info('Bulk destroy IDs: ', $ids);

        if (!empty($ids)) {
            $users = User::whereIn('id', $ids)->get();
            foreach ($users as $user) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $user->delete();
            }
            return redirect()->route('data-user.index')->with('success', 'Users berhasil dihapus');
        }

        return redirect()->route('data-user.index')->with('error', 'Tidak ada user yang dipilih.');
    }
}
