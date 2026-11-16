<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi', 20)->index(); // pembuka, beranda, unit
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('judul', 150)->nullable();
            $table->string('subjudul')->nullable();
            $table->string('gambar')->nullable(); // kosong = kotak abu-abu polos sampai foto asli diunggah
            $table->string('alt')->nullable();
            $table->json('atribut')->nullable(); // lencana, ikon, tombol per slide (Hal. 2)
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
