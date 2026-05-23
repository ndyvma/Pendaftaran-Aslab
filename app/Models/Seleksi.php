<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seleksi extends Model
{
    protected $fillable = [
        'user_id',
        'status_seleksi',
        'keterangan',
        'cbt_session_id',
        'tanggal_update',
        'cbt_session_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cbtSession()
    {
        return $this->belongsTo(CbtSession::class, 'cbt_session_id');
    }
}