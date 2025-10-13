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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->nullable();
            $table->string('nama')->nullable();
            $table->integer('semester')->nullable();
            $table->string('jenis_masalah');
            $table->text('keterangan');
            $table->string('kontak_pengadu')->nullable();
            $table->string('lampiran')->nullable();
            $table->boolean('anonim')->default(false);
            $table->string('kode_tiket')->unique();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};