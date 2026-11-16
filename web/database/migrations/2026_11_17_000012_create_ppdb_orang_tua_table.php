<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_orang_tua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('ppdb_pendaftar')->cascadeOnDelete();
            $table->string('hubungan', 10); // ayah, ibu, wali
            $table->string('nama', 150);
            $table->text('alamat')->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('rentang_penghasilan', 30)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->timestamps();
            $table->unique(['pendaftar_id', 'hubungan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_orang_tua');
    }
};
