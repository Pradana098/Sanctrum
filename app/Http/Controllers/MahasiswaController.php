<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa; // Pastikan untuk mengimpor model Mahasiswa
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // Menampilkan daftar mahasiswa
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return response()->json($mahasiswas);
    }

    // Menyimpan mahasiswa baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:mahasiswas',
            'jurusan' => 'required|string|max:255',
        ]);

        // Membuat mahasiswa baru
        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json($mahasiswa, 201);
    }

    // Menampilkan detail mahasiswa
    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        return response()->json($mahasiswa);
    }

    // Mengupdate mahasiswa
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        // Validasi data
        $request->validate([
            'nama' => 'string|max:255',
            'nim' => 'string|max:255|unique:mahasiswas,nim,' . $mahasiswa->id,
            'jurusan' => 'string|max:255',
        ]);

        // Update mahasiswa
        $mahasiswa->update($request->all());

        return response()->json($mahasiswa);
    }

    // Menghapus mahasiswa
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        $mahasiswa->delete();

        return response()->json(['message' => 'Mahasiswa deleted successfully']);
    }

    public function getAllData(Request $request)
    {
        // Hanya allow admin untuk mengakses data
        $this->authorize('viewAny', Mahasiswa::class);

        $mahasiswas = Mahasiswa::all();
        return response()->json($mahasiswas);
    }
}
