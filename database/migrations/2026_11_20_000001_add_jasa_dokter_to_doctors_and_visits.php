<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah jasa_dokter ke tabel doctors
        Schema::table('doctors', function (Blueprint $table) {
            $table->integer('jasa_dokter')->default(0)->after('status')
                  ->comment('Jasa dokter per kunjungan (Rp)');
        });

        // Tambah jasa_dokter ke tabel visits
        Schema::table('visits', function (Blueprint $table) {
            $table->integer('jasa_dokter')->default(0)->after('biaya_obat')
                  ->comment('Jasa dokter yang dibayarkan ke dokter');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('jasa_dokter');
        });
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('jasa_dokter');
        });
    }
};
