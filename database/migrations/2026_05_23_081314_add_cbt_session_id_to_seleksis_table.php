<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seleksis', function (Blueprint $table) {
            // Menambahkan kolom foreign key setelah kolom user_id
            $table->foreignId('cbt_session_id')
                  ->nullable()
                  ->after('user_id') 
                  ->constrained('cbt_sessions')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('seleksis', function (Blueprint $table) {
            // Menghapus foreign key dan kolom jika rollback
            $table->dropForeign(['cbt_session_id']);
            $table->dropColumn('cbt_session_id');
        });
    }
};