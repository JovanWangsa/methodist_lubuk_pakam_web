<?php

namespace App\Models;

use App\Models\Concerns\MenghapusCacheKonten;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slide extends Model
{
    use MenghapusCacheKonten;

    protected $table = 'slides';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'atribut' => 'array',
        ];
    }

    public const LOKASI_PEMBUKA = 'pembuka';

    public const LOKASI_BERANDA = 'beranda';

    public const LOKASI_UNIT = 'unit';

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function scopeTampil(Builder $query, string $lokasi): Builder
    {
        return $query->where('lokasi', $lokasi)->where('aktif', true)->orderBy('urutan');
    }
}
