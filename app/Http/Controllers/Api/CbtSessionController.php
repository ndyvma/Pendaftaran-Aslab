<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CbtSession;
use App\Models\Seleksi;

class CbtSessionController extends Controller
{
    // 🔥 AMBIL KARTU UJIAN
    public function kartuUjian($user_id)
    {
        $seleksi = Seleksi::with('cbtSession')->where('user_id', $user_id)->first();

        if (!$seleksi || !$seleksi->cbtSession) {
            return response()->json([
                'success' => false,
                'message' => 'CBT belum tersedia untuk user ini'
            ], 403);
        }

        return response()->json([
            'nama_cbt' => $seleksi->cbtSession->nama_cbt,
            'tanggal'  => $seleksi->cbtSession->tanggal,
            'durasi'   => $seleksi->cbtSession->durasi,
            'token'    => $seleksi->cbtSession->token,
            'status'   => $seleksi->status_seleksi
        ]);
    }

    // 🔥 BUAT CBT SESSION (ADMIN)
    public function store(Request $request)
    {
        $request->validate([
            'nama_cbt' => 'required|string',
            'tanggal'  => 'required|date',
            'durasi'   => 'required|integer',
            'token'    => 'required|string',
            'tahun'    => 'required|integer',
        ]);

        $cbt = CbtSession::create([
            'nama_cbt' => $request->nama_cbt,
            'tanggal'  => $request->tanggal,
            'durasi'   => $request->durasi,
            'token'    => $request->token,
            'tahun'    => $request->tahun,
            'status'   => 'aktif'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sesi CBT berhasil dibuat!',
            'data'    => $cbt
        ], 201);
    }
    
    // 🔥 ASSIGN CBT KE USER
    public function assignCbt(Request $request, $user_id)
    {
        $request->validate([
            'cbt_session_id' => 'required|exists:cbt_sessions,id',
        ]);

        $seleksi = Seleksi::where('user_id', $user_id)->first();

        if (!$seleksi) {
            return response()->json([
                'success' => false,
                'message' => 'Data seleksi untuk User ID ini tidak ditemukan.'
            ], 404);
        }

        $seleksi->cbt_session_id = $request->cbt_session_id;
        $seleksi->status_seleksi = 'CBT';
        $seleksi->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil di-assign ke CBT',
            'data'    => $seleksi
        ], 200);
    }
}