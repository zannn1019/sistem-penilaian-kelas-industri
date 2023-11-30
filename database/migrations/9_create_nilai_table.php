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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('id_tugas')->constrained('tugas')->cascadeOnDelete();
            $table->integer('nilai');
            $table->string("tahun_ajar");
            $table->enum("semester", ['ganjil', 'genap']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
