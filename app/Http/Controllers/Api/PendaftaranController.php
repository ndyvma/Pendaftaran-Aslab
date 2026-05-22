<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Dokumen;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {

        // SIMPAN PROFIL
        $profil = Profil::create([

            'user_id' => $request->user_id,
            'nama_lengkap' => $request->nama_lengkap,
            'nim' => $request->nim,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat_lengkap' => $request->alamat,
            'tahun_kelulusan' => $request->tahun_lulus_sma,
            'alasan_daftar' => $request->alasan_daftar,
            'no_wa' => $request->no_hp,
            'email' => $request->email

        ]);

        // UPLOAD FILE
        $cv = $request->hasFile('CV')
            ? $request->file('CV')->store('dokumen', 'public')
            : null;

        $ktm = $request->hasFile('KTM')
            ? $request->file('KTM')->store('dokumen', 'public')
            : null;

        $foto = $request->hasFile('Foto')
            ? $request->file('Foto')->store('dokumen', 'public')
            : null;

        $ijazah = $request->hasFile('Ijazah')
            ? $request->file('Ijazah')->store('dokumen', 'public')
            : null;

        $ssIg = $request->hasFile('ScreenshotIG')
            ? $request->file('ScreenshotIG')->store('dokumen', 'public')
            : null;

        // SIMPAN DOKUMEN
        $dokumen = Dokumen::create([

            'user_id' => $request->user_id,

            'file_cv' => $cv,
            'file_ktm' => $ktm,
            'file_foto' => $foto,
            'file_ijazah' => $ijazah,
            'file_ss_ig' => $ssIg,

            'deskripsi_project' => $request->deskripsi_project,
            'link_github' => $request->link_github,
            'link_linkedin' => $request->link_linkedin,
            'link_portfolio' => $request->link_portfolio

        ]);

        return response()->json([

            'success' => true,
            'message' => 'Pendaftaran berhasil',

            'profil' => $profil,
            'dokumen' => $dokumen

        ], 201);
    }

        public function index()
    {
        $pendaftaran = Profil::with(['dokumen', 'seleksi'])->get();

        return response()->json([
            'success' => true,
            'data' => $pendaftaran
        ]);
    }
}