<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherFeedback extends Model
{
        use HasFactory, SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'student_id',
        'feedback',
        'rating',
        'created_at',
    ];
}
