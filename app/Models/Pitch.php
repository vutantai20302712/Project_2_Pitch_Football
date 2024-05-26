<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    public function yardCategory()
    {
        return $this->belongsTo(Yard_category::class, 'yard_category');
    }
}
