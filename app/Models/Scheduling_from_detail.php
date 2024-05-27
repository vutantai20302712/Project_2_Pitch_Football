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
    protected $primaryKey = ['scheduling_form_id', 'pitch_id', 'time_id'];
    public $incrementing = false;

    public function form()
    {
        return $this->belongsTo(Scheduling_from::class, 'scheduling_form_id');
    }

    public function pitch()
    {
        return $this->belongsTo(Pitch::class, 'pitch_id');
    }
}
