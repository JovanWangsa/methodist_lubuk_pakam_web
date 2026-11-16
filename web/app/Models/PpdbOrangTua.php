<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbOrangTua extends Model
{
    protected $table = 'ppdb_orang_tua';

    protected $guarded = ['id'];

    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(PpdbPendaftar::class, 'pendaftar_id');
    }
}
