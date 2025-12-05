<?php

namespace App\Http\Controllers\referensi;

use App\Http\Controllers\Controller;
use App\Models\referensi\ref_kabupaten;
use Illuminate\Http\Request;

class kabupaten extends Controller
{
    private $pesanValidasi = [
        'required' => 'Kolom Nama wajib diisi.',
        'string' => 'Nama harus berupa teks.',
    ];
    public function index()
    {
        $datas = ref_kabupaten::all();

        return response()->json([
            'status' => true,
            'data' => $datas
        ]);
    }
    public function simpanData(Request $request)
    {
        try {
            $request->validate([
                'kabupaten_nama' => 'required|string|max:255',
            ], $this->pesanValidasi);

            $post = [];
            foreach ($request->all() as $key => $value) {
                $post[$key] = trim($value);
            }

            ref_kabupaten::create($post);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }
    }
    public function updateData(Request $request, $id)
    {
        $datas = ref_kabupaten::find($id);

        if (!$datas) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        try {
            $request->validate([
                'kabupaten_nama' => 'required|string|max:255',
            ], $this->pesanValidasi);

            $post = [];
            foreach ($request->all() as $key => $value) {
                $post[$key] = trim($value);
            }

            $datas->update($post);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }
    }
    public function hapusData($id)
    {
        $datas = ref_kabupaten::find($id);

        if (!$datas) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        try {
            $datas->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }
    }
}
