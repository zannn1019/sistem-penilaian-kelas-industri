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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('no_telp');
            $table->enum('role', ['admin', 'pengajar']);
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
