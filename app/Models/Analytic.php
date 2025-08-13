<?php

namespace App\Models;

use Dotenv\Repository\Adapter\GuardedWriter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analytic extends Model
{
    protected $guarded = [''];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function captureHistory()
    {
        return $this->hasMany(CaptureHistory::class);
    }
}
