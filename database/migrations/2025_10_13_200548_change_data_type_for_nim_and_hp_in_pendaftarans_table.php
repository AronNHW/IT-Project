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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->bigInteger('nim')->nullable()->change();
            $table->bigInteger('hp')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('no_wa')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('nim')->nullable()->change();
            $table->string('hp')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('no_wa')->nullable()->change();
        });
    }
};