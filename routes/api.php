<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\CbtController;
use App\Http\Controllers\Api\SeleksiController;
use App\Http\Controllers\Api\WawancaraController;
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\PendaftaranController;


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/profil', [ProfilController::class, 'store']);

Route::get('/profil/{id}', [ProfilController::class, 'show']);

Route::put('/profil/{id}', [ProfilController::class, 'update']);

Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::post('/soal', [CbtController::class, 'storeSoal']);
Route::get('/soal/{user_id}', [CbtController::class, 'getSoal']);

Route::post('/seleksi', [SeleksiController::class, 'updateStatus']);

Route::post('/wawancara', [WawancaraController::class, 'store']);
Route::get('/wawancara/{user_id}', [WawancaraController::class, 'show']);

Route::post('/notifikasi', [NotifikasiController::class, 'store']);
Route::get('/notifikasi/{user_id}', [NotifikasiController::class, 'getNotif']);

Route::get('/pengumuman', [SeleksiController::class, 'pengumuman']);

Route::get('/seleksi/{user_id}', [SeleksiController::class, 'getSeleksi']);

Route::post('/pendaftaran', [PendaftaranController::class, 'store']);

Route::get('/pendaftaran', [PendaftaranController::class, 'index']);
use App\Http\Controllers\Api\CbtSessionController;

Route::get('/kartu-ujian/{user_id}', [CbtSessionController::class, 'kartuUjian']);
Route::post('/cbt-session', [CbtSessionController::class, 'store']);

Route::post('/assign-cbt/{user_id}', [SeleksiController::class, 'assignCbt']);

