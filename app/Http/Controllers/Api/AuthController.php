<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login pengguna dan mengembalikan token, role, dan dashboard_url
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->with('role')->first();

            if (!$user) {
                Log::warning('Login gagal: Email tidak ditemukan', ['email' => $request->email]);
                return response()->json([
                    'message' => 'Email atau password salah.'
                ], 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                Log::warning('Login gagal: Password salah', ['email' => $request->email]);
                return response()->json([
                    'message' => 'Email atau password salah.'
                ], 401);
            }

            if (!$user->role) {
                Log::error('Login gagal: Pengguna tidak memiliki peran', [
                    'email' => $request->email,
                    'user_id' => $user->user_id,
                ]);
                return response()->json([
                    'message' => 'Peran pengguna tidak ditemukan.'
                ], 403);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            Log::info('Pengguna berhasil login', [
                'email' => $user->email,
                'user_id' => $user->user_id,
                'role_id' => $user->role->role_id,
                'role_name' => $user->role->nama_role,
            ]);

            return response()->json([
                'message' => "Login berhasil, Anda login sebagai {$user->role->nama_role}",
                'token' => $token,
                'dashboard_url' => "/{$user->role->prefix}/dashboard",
                'role' => $user->role->prefix,
                'user' => [
                    'user_id' => $user->user_id,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'nip' => $user->nip,
                    'role_id' => $user->role->role_id,
                    'unit_kerja_id' => $user->unit_kerja_id,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Login gagal: Kesalahan tak terduga', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Registrasi pengguna baru
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|integer|exists:roles,role_id',
                'unit_kerja_id' => 'required|integer|exists:unit_kerja,unit_kerja_id',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'nama' => 'required|string|max:100',
                'nip' => 'required|unique:users,nip',
            ]);

            if ($validator->fails()) {
                Log::warning('Registrasi gagal: Kesalahan validasi', [
                    'errors' => $validator->errors()->toArray(),
                    'input' => $request->except('password'),
                ]);
                return response()->json([
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::create([
                'role_id' => $request->role_id,
                'unit_kerja_id' => $request->unit_kerja_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'nip' => $request->nip,
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            Log::info('Pengguna berhasil registrasi', [
                'email' => $user->email,
                'user_id' => $user->user_id,
                'role_id' => $user->role_id,
                'unit_kerja_id' => $user->unit_kerja_id,
            ]);

            return response()->json([
                'message' => 'Registrasi berhasil.',
                'user' => [
                    'user_id' => $user->user_id,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'nip' => $user->nip,
                    'role_id' => $user->role_id,
                    'unit_kerja_id' => $user->unit_kerja_id,
                ],
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Registrasi gagal: Kesalahan tak terduga', [
                'input' => $request->except('password'),
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Memperbarui profil pengguna
     */
    public function update(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                Log::warning('Update gagal: Pengguna tidak terautentikasi', []);
                return response()->json([
                    'message' => 'Pengguna tidak terautentikasi.',
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'role_id' => 'integer|exists:roles,role_id',
                'unit_kerja_id' => 'integer|exists:unit_kerja,unit_kerja_id',
                'email' => 'email|unique:users,email,' . $user->user_id . ',user_id',
                'password' => 'min:6',
                'nama' => 'string|max:100',
                'nip' => 'unique:users,nip,' . $user->user_id . ',user_id',
            ]);

            if ($validator->fails()) {
                Log::warning('Update gagal: Kesalahan validasi', [
                    'errors' => $validator->errors()->toArray(),
                    'user_id' => $user->user_id,
                ]);
                return response()->json([
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->only(['role_id', 'unit_kerja_id', 'email', 'password', 'nama', 'nip']);

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            if (empty($data)) {
                Log::warning('Update gagal: Tidak ada data untuk diperbarui', [
                    'user_id' => $user->user_id,
                    'input' => $request->all(),
                ]);
                return response()->json([
                    'message' => 'Tidak ada data yang dikirim untuk diperbarui.',
                ], 400);
            }

            $user->update($data);

            Log::info('Profil pengguna berhasil diperbarui', [
                'user_id' => $user->user_id,
                'email' => $user->email,
            ]);

            return response()->json([
                'message' => 'Profil berhasil diperbarui.',
                'user' => [
                    'user_id' => $user->user_id,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'nip' => $user->nip,
                    'role_id' => $user->role_id,
                    'unit_kerja_id' => $user->unit_kerja_id,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Update gagal: Kesalahan tak terduga', [
                'user_id' => $user->user_id ?? 'unknown',
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout pengguna dan mencabut token
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                Log::warning('Logout gagal: Pengguna tidak terautentikasi', []);
                return response()->json([
                    'message' => 'Pengguna tidak terautentikasi.',
                ], 401);
            }

            $user->tokens()->delete();

            Log::info('Pengguna berhasil logout', [
                'user_id' => $user->user_id,
                'email' => $user->email,
            ]);

            return response()->json([
                'message' => 'Logout berhasil.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Logout gagal: Kesalahan tak terduga', [
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
            ], 500);
        }
    }
}
