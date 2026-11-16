<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // tk, sd, smp, sma
            $table->string('nama', 100);
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->text('deskripsi_singkat')->nullable();
            $table->string('gambar')->nullable();
            $table->string('npsn', 20)->nullable();
            $table->string('akreditasi', 20)->nullable();
            $table->string('alamat')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('sambutan')->nullable();
            $table->string('nama_kepsek', 150)->nullable();
            $table->string('foto_kepsek')->nullable();
            $table->longText('kurikulum')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
