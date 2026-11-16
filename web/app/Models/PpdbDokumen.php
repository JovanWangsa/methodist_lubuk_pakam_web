<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbDokumen extends Model
{
    protected $table = 'ppdb_dokumen';

    protected $guarded = ['id'];

    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(PpdbPendaftar::class, 'pendaftar_id');
    }
}
