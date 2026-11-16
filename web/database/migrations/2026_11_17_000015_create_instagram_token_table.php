<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instagram_token', function (Blueprint $table) {
            $table->id();
            $table->text('token'); // terenkripsi oleh Express (INSTAGRAM_TOKEN_KEY)
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('refreshed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instagram_token');
    }
};
