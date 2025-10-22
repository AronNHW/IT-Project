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
        Schema::table('prestasis', function (Blueprint $table) {
            // Change ENUM to a more flexible STRING and allow for 'Provinsi/Wilayah'
            $table->string('tingkat_kegiatan', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasis', function (Blueprint $table) {
            // Revert back to ENUM, though this might cause data loss if new values were added.
            $table->enum('tingkat_kegiatan', ['Internal (Kampus)', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'])->change();
        });
    }
};
