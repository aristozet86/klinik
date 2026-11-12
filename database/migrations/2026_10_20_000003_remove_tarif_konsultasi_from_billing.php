<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->integer('tarif_konsultasi')->default(0)->nullable()->change();
        });

        Schema::table('visits', function (Blueprint $table) {
            $table->integer('biaya_konsultasi')->default(0)->change();
        });

        DB::table('visits')->update([
            'biaya_konsultasi' => 0,
            'total_biaya' => DB::raw('biaya_tindakan + biaya_obat'),
        ]);

        DB::table('doctors')->update([
            'tarif_konsultasi' => 0,
        ]);
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->integer('tarif_konsultasi')->default(50000)->nullable(false)->change();
        });
    }
};
