<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Seleksi;
class Profil extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'kelas',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_lengkap',
        'tahun_kelulusan',
        'alasan_daftar',
        'no_wa',
        'email',
    ];
    public function dokumen()
    {
        return $this->hasOne(Dokumen::class, 'user_id', 'user_id');
    }
    public function seleksi()
    {
        return $this->hasOne(Seleksi::class, 'user_id', 'user_id');
    }
}