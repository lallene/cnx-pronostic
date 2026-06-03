<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceScore extends Model
{
    protected $fillable = [
    'service',
    'nb_users',
    'participants',
    'nb_matches_joues',
    'total_pronostics',
    'correct_predictions',
    'points',
    'participation_ratio',
    'precision_ratio',
    'global_score',
    'rank',
];
}
