<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhysicalActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'calories_burned_per_hour',
        'description',
    ];
}
