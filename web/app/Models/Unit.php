<?php

namespace App\Models;

use App\Models\Concerns\MenghapusCacheKonten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Unit extends Model
{
    use MenghapusCacheKonten;

    protected $table = 'units';

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'kode';
    }

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

    public function guru(): HasMany
    {
        return $this->hasMany(Guru::class)->orderBy('urutan');
    }

    public function informasi(): HasMany
    {
        return $this->hasMany(InformasiUnit::class);
    }

    public function ppdbInfo(): HasOne
    {
        return $this->hasOne(PpdbUnitInfo::class);
    }
}
