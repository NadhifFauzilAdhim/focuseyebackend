<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $fillable = ['schedule_id', 'name', 'description', 'start_date', 'end_date'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
