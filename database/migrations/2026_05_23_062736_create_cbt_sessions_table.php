<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cbt_sessions', function (Blueprint $table) {
            $table->id();

            $table->string('nama_cbt');
            $table->dateTime('tanggal');
            $table->integer('durasi');

            $table->string('token')->unique();
            $table->year('tahun');

            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbt_sessions');
    }
};