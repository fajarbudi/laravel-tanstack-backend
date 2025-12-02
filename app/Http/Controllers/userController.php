<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    public function index()
    {
        // Ambil data dari database (contoh menggunakan model User)
        $users = \App\Models\User::all();

        // Kembalikan response dengan data yang diambil
        // return response()->json(['users' => $users]);
        return response()->json($users);
    }
    public function simpanData(Request $request)
    {
        // Validasi data yang diterima dari request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Simpan data ke database (contoh menggunakan model User)
        $user = new \App\Models\User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        // Kembalikan response sukses
        return response()->json(['message' => 'User created successfully', 'user' => $user], 200);
    }
    public function updateData(Request $request, $id)
    {
        // Validasi data yang diterima dari request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            // 'password' => 'nullable|string|min:8',
        ]);

        // Cari data user berdasarkan ID (contoh menggunakan model User)
        $user = \App\Models\User::find($id);

        // Jika data user tidak ditemukan, kembalikan response error
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update data user
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        // if ($validatedData['password']) {
        //     $user->password = bcrypt($validatedData['password']);
        // }
        $user->save();

        // Kembalikan response sukses
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
    public function hapusData($id)
    {
        // Cari data user berdasarkan ID (contoh menggunakan model User)
        $user = \App\Models\User::find($id);

        // Jika data user tidak ditemukan, kembalikan response error
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Hapus data user
        $user->delete();

        // Kembalikan response sukses
        return response()->json(['message' => 'User deleted successfully']);
    }
}
