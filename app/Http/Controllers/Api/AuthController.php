<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        $role = strtolower($user->role->nama_role);
        $dashboardUrl = "/{$role}/dashboard";

        return response()->json([
            'message' => "Login berhasil, Anda login sebagai {$user->role->nama_role}",
            'token' => $token,
            'dashboard_url' => $dashboardUrl,
            'role' => $role
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer',
            'unit_kerja_id' => 'required|integer',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama' => 'required|string|max:100',
            'nip' => 'required|unique:users,nip',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
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

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'user' => $user,
            'token' => $token
        ]);
    }
    public function update(Request $request)
    {
        $request->merge(json_decode($request->getContent(), true));

        $user = $request->user(); // User yang login

        $validator = Validator::make($request->all(), [
            'role_id' => 'integer',
            'unit_kerja_id' => 'integer',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6',
            'nama' => 'string|max:100',
            'nip' => 'unique:users,nip,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['role_id', 'unit_kerja_id', 'email', 'password', 'nama', 'nip']);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (empty($data)) {
            return response()->json([
                'message' => 'Tidak ada data yang dikirim untuk diperbarui.'
            ], 400);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user->refresh()
        ]);
    }
    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'User tidak terautentikasi'], 401);
        }

        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout berhasil.'
        ]);
    }
}
