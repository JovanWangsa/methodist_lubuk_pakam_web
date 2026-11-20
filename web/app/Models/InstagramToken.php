<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Token Instagram dikelola layanan Express (Sprint 4) dan dienkripsi di sana dengan kunci
 * INSTAGRAM_TOKEN_KEY milik api/.env, sehingga Laravel tidak mendekripsinya.
 */
class InstagramToken extends Model
{
    protected $table = 'instagram_token';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'token' => 'encrypted',
            'expires_at' => 'datetime',
            'refreshed_at' => 'datetime',
        ];
    }
}
