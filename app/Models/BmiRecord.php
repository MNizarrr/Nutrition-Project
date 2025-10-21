<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BmiRecord extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'bmi_value',
        'bmi_category',
        'record_date',
        'notes',
    ];
}
