<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BmiActivityLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bmi_record_id',
        'physival_activity_id',
        'duration',
        'activity_date',
    ];
}
