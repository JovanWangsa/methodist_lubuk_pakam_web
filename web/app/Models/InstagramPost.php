<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramPost extends Model
{
    protected $table = 'instagram_posts';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'posted_at' => 'datetime',
        ];
    }
}
