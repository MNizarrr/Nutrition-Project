<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NutritionGoal extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'goal_type',
        'target_value',
        'start_date',
        'end_date',
        'notes',
    ];
}
