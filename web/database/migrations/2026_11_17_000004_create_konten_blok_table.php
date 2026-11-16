<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Isi setiap bagian halaman (judul, kalimat, kartu, linimasa, dst.) disimpan sebagai JSON
     * per kunci, misalnya "beranda.kemitraan" atau "sejarah.linimasa". Struktur JSON-nya
     * mengikuti desain Stitch; contoh lengkap ada di database/data/konten/.
     */
    public function up(): void
    {
        Schema::create('konten_blok', function (Blueprint $table) {
            $table->id();
            $table->string('kunci', 100)->unique();
            $table->json('data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konten_blok');
    }
};
