<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaptureHistory extends Model
{
    protected $guarded = [];

    public function analytic() : BelongsTo
    {
        return $this->belongsTo(Analytic::class);
    }
}
