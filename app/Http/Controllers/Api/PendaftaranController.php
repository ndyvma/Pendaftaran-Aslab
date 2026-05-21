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
        // 1. SIMPAN PROFIL (Key di sebelah kanan disesuaikan dengan fields kiriman Flutter)
        $profil = Profil::create([
            'user_id' => $request->user_id,
            'nim' => $request->nim,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat_lengkap' => $request->alamat,          // SINKRON DENGAN FLUTTER
            'tahun_kelulusan' => $request->tahun_lulus_sma, // SINKRON DENGAN FLUTTER
            'alasan_daftar' => $request->alasan_daftar,
            'no_wa' => $request->no_hp,           // SINKRON DENGAN FLUTTER
            'email' => $request->email
        ]);

        // 2. UPLOAD FILE (Diberi pengaman hasFile agar tidak crash jika pendaftar mengosongkan file di emulator)
        $ktm = $request->hasFile('KTM') ? $request->file('KTM')->store('dokumen', 'public') : null;
        $foto = $request->hasFile('Foto') ? $request->file('Foto')->store('dokumen', 'public') : null;
        $ijazah = $request->hasFile('Ijazah') ? $request->file('Ijazah')->store('dokumen', 'public') : null;
        $cv = $request->hasFile('CV') ? $request->file('CV')->store('dokumen', 'public') : null;
        $screenshotIg = $request->hasFile('ScreenshotIG') ? $request->file('ScreenshotIG')->store('dokumen', 'public') : null;

        // 3. SIMPAN DOKUMEN & PORTFOLIO (Menyimpan semua jalur berkas fisik dan link secara lengkap)
        $dokumen = Dokumen::create([
            'user_id' => $request->user_id,
            'CV' => $cv,
            'KTM' => $ktm,
            'Foto' => $foto,         // Menangkap field Foto dari Flutter
            'Ijazah' => $ijazah,       // Menangkap field Ijazah dari Flutter
            'ScreenshotIG' => $screenshotIg, // Menangkap field ScreenshotIG dari Flutter
            'deskripsi_project' => $request->deskripsi_project,
            'link_github' => $request->link_github,
            'link_linkedin' => $request->link_linkedin,
            'link_portfolio' => $request->link_portfolio
        ]);

        // 4. MENGEMBALIKAN RESPONS JSON SUKSES (Pasti dikenali Flutter dengan status 201)
        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil disimpan lengkap!',
            'profil' => $profil,
            'dokumen' => $dokumen
        ], 201);
    }
}