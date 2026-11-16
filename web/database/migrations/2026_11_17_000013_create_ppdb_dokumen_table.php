<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('ppdb_pendaftar')->cascadeOnDelete();
            $table->string('jenis', 10); // kk, akta
            $table->string('path');
            $table->string('mime', 100);
            $table->unsignedInteger('ukuran');
            $table->timestamps();
            $table->unique(['pendaftar_id', 'jenis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_dokumen');
    }
};
