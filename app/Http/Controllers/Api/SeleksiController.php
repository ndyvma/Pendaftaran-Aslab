<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seleksi;
use App\Models\User;

class SeleksiController extends Controller
{
    public function updateStatus(Request $request)
    {
        $seleksi = Seleksi::updateOrCreate(
            [
                'user_id' => $request->user_id
            ],
            [
                'status_seleksi' => $request->status_seleksi,
                'keterangan' => $request->keterangan
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status seleksi berhasil diupdate',
            'data' => $seleksi
        ]);
    }

    public function pengumuman()
    {
        $users = User::whereHas('seleksi', function ($query) {
            $query->where('status_seleksi', 'Final Lolos');
        })->with('seleksi')->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function getSeleksi($user_id)
    {
        $seleksi = Seleksi::where('user_id', $user_id)->first();

        if (!$seleksi) {
            return response()->json([
                'success' => false,
                'message' => 'Data seleksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $seleksi
        ]);
    }

    public function assignCbt(Request $request, $user_id)
    {
        // 1. Validasi input agar memastikan cbt_session_id yang dikirim itu ada di database
        $request->validate([
            'cbt_session_id' => 'required|exists:cbt_sessions,id',
        ]);

        // 2. Cari data seleksi berdasarkan user_id
        $seleksi = Seleksi::where('user_id', $user_id)->first();

        // 3. Jika data pendaftar belum ada di tabel seleksis, kirim respon 404
        if (!$seleksi) {
            return response()->json([
                'success' => false,
                'message' => 'Data seleksi untuk User ID ini tidak ditemukan.'
            ], 404);
        }

        // 4. Update data cbt_session_id dan status
        $seleksi->cbt_session_id = $request->cbt_session_id;
        $seleksi->status_seleksi = 'CBT'; 
        $seleksi->save();

        // 5. Kembalikan respon sukses berupa JSON murni
        return response()->json([
            'success' => true,
            'message' => 'Berhasil assign CBT',
            'data' => $seleksi
        ], 200);
        
        // Sisa kode duplikat di bawah return tadi sudah dihapus dari sini agar rapi!
    }
}