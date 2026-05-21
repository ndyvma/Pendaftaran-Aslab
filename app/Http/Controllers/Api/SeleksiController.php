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

}