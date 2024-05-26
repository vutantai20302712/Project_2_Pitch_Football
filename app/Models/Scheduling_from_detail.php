<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduling_from_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'scheduling_form_id', 'price','pitch_id', 'time_id'
    ];
    public function timeFrame()
    {
        return $this->belongsTo(Time_frame::class, 'time_id');
    }
}
