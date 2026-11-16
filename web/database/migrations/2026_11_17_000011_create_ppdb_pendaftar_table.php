<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_pendaftar', function (Blueprint $table) {
            $table->id();
            $table->uuid('token')->unique();
            $table->string('no_pendaftaran', 30)->nullable()->unique();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('email');
            $table->string('nama_depan', 100);
            $table->string('nama_belakang', 100)->nullable();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('no_hp', 20);
            $table->string('golongan_darah', 2)->nullable(); // A, B, AB, O
            $table->unsignedSmallInteger('tinggi_cm')->nullable();
            $table->unsignedSmallInteger('berat_kg')->nullable();
            $table->string('tinggal_bersama', 20); // orang_tua, wali, lainnya
            $table->string('tinggal_bersama_ket')->nullable();
            $table->string('naik_ke_kelas', 5); // tk, sd, smp, sma
            $table->string('asal_sekolah', 150)->nullable();
            $table->string('status', 20)->default('draf')->index(); // draf, terkirim, diverifikasi, diterima, ditolak
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_pendaftar');
    }
};
