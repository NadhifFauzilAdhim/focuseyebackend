<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaptureHistory extends Model
{
    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'analytic_id',
        'image_path',
        'capture_time'
    ];

    /**
     * @var array
     */
    protected $appends = ['image_url'];

    /**
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }
        return '';
    }

    /**
     * Relasi ke model Analytic.
     */
    public function analytic(): BelongsTo
    {
        return $this->belongsTo(Analytic::class);
    }
}
