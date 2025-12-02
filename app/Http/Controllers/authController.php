<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    private $pesanValidasi = [
       'name.required' => 'Kolom Nama wajib diisi.',
       'password.required' => 'Kolom Kata Sandi wajib diisi.',
       'name.string' => 'Nama harus berupa teks.',
       'password.string' => 'Kata Sandi harus berupa teks.'
    ];
    public function login(Request $request){
        try {
        $validate = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'string']
        ],$this->pesanValidasi);
        

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();

            return response()->json(
                status: 200,
                data: [
                    'message' => 'Login Berhasil'
                ]
                );
        }

        return response()->json(
            status: 200,
            data: [
                'req' => $request->all(),
                'message' => 'Akun yang anda masukkan salah, Silahkan Coba Lagi'
            ]
        );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                status: 200,
                data: [
                    'message' => $e->errors()
                ]
            );
        }
    }

    public function logout(Request $request){
        try {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(
                status: 200,
                data: [
                    'message' => 'Logout Berhasil'
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                status: 200,
                data: [
                    'message' => $e->errors()
                ]
            );
        }
    }
}
