<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_unit_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->unique()->constrained('units')->cascadeOnDelete();
            $table->longText('syarat')->nullable();
            $table->longText('jadwal')->nullable();
            $table->longText('alur')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_unit_info');
    }
};
