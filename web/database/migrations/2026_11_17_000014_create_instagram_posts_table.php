<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instagram_posts', function (Blueprint $table) {
            $table->id();
            $table->string('ig_media_id', 50)->unique();
            $table->text('caption')->nullable();
            $table->string('media_type', 20);
            $table->string('gambar_lokal')->nullable();
            $table->string('permalink');
            $table->timestamp('posted_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instagram_posts');
    }
};
