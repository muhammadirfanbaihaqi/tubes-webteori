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
        Schema::table('addresses', function (Blueprint $table) {
            $table->text('jalan')->nullable()->after('phone'); // Tambahkan kolom 'jalan'
            $table->string('kecamatan')->nullable()->after('jalan'); // Tambahkan kolom 'kecamatan'
            $table->string('kabkota')->nullable()->after('kecamatan'); // Tambahkan kolom 'kabkota'
            $table->string('provinsi')->nullable()->after('kabkota'); // Tambahkan kolom 'provinsi'
            $table->string('kode_pos')->nullable()->after('provinsi'); // Tambahkan kolom 'kode_pos'
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['jalan', 'kecamatan', 'kabkota', 'provinsi', 'kode_pos']); // Hapus kolom-kolom yang baru ditambahkan
        });
    }
};
