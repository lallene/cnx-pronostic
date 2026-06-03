<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamificationEvent extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'xp',
        'points',
        'seen',
    ];
}
