<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time_frame extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'start_time', 'end_time'
    ];

    // Khai báo mối quan hệ với bảng scheduling_from_details
    public function schedulingFromDetails()
    {
        return $this->hasMany(Scheduling_from_detail::class);
    }
}
