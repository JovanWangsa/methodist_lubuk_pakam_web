<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpdbPendaftar extends Model
{
    use SoftDeletes;

    protected $table = 'ppdb_pendaftar';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'submitted_at' => 'datetime',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function orangTua(): HasMany
    {
        return $this->hasMany(PpdbOrangTua::class, 'pendaftar_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(PpdbDokumen::class, 'pendaftar_id');
    }
}
