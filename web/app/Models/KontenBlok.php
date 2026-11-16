<?php

namespace App\Models;

use App\Models\Concerns\MenghapusCacheKonten;
use Illuminate\Database\Eloquent\Model;

class KontenBlok extends Model
{
    use MenghapusCacheKonten;

    protected $table = 'konten_blok';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
