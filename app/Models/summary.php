<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class summary extends Model
{
    protected $guarded = []; // Allow mass assignment for all attributes

    /**
     * Get the analytic associated with the summary.
     */
    public function analytic()
    {
        return $this->belongsTo(Analytic::class);
    }
}
