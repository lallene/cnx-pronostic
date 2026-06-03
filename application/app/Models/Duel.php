<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duel extends Model
{
    use HasFactory;

    protected $fillable = [
    'challenger_id',
    'opponent_id',
    'match_id',
    'xp_bet',
    'challenger_prediction',
    'opponent_prediction',
    'status',
    'winner_id',
];

public function challenger()
{
    return $this->belongsTo(User::class, 'challenger_id');
}

public function opponent()
{
    return $this->belongsTo(User::class, 'opponent_id');
}

public function match()
{
    return $this->belongsTo(Matche::class, 'match_id');
}

}
