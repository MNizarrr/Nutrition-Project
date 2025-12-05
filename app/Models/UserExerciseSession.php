<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExerciseSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'physical_activity_id',
        'duration_minutes',
        'calories_burned',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function physicalActivity()
    {
        return $this->belongsTo(PhysicalActivity::class);
    }
}
