<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CbtSession extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database
    protected $table = 'cbt_sessions';
    protected $fillable = [
        'nama_cbt',
        'tanggal',
        'durasi',
        'token',
        'tahun',
        'status'
    ];

    public function soal()
    {
        return $this->hasMany(SoalCbt::class);
    }

    public function seleksi()
    {
        return $this->hasMany(Seleksi::class);
    }
}