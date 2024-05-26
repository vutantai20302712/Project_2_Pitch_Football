<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduling_from extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'scheduling_form_status', 'scheduling_form_date', 'payment_method', 'admin_id'
    ];
}
