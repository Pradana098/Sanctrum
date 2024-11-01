<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Validator; 


class AuthController extends Controller
{
    //
    // Fungsi untuk registrasi pengguna baru
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Hash password
        ]);

        // Membuat token autentikasi
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengembalikan token
        return response()->json(['token' => $token], 201);
    }

    // Fungsi untuk login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Verifikasi password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Membuat token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengembalikan token
        return response()->json(['token' => $token], 200);
    }

    public function registerAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Admin registered successfully!', 'admin' => $admin], 201);
    }

    public function registerMahasiswa(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'nim' => 'required|string|max:20|unique:mahasiswas',
        'jurusan' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $mahasiswa = Mahasiswa::create([
        'nama' => $request->nama,
        'nim' => $request->nim,
        'jurusan' => $request->jurusan,
    ]);

    return response()->json(['message' => 'Mahasiswa registered successfully!', 'mahasiswa' => $mahasiswa], 201);
}

public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Menghapus semua token
        return response()->json(['message' => 'Logged out successfully']);
    }


}
