<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbUnitInfo extends Model
{
    protected $table = 'ppdb_unit_info';

    protected $guarded = ['id'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
