<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory;


    protected $fillable = [
        'home_team',
        'away_team',
        'home_team_avatar',
        'away_team_avatar',
        'match_date',
        'competition',
        'groupe',
        'phase',
        'journee',
    ];
    protected static function booted()
    {
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('match_date', 'desc');
        });
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class, 'match_id', 'id');
    }
    public function resultat()
    {
        return $this->hasOne(Resultat::class, 'match_id');
    }

    
    public function resultats()
    {
        return $this->hasMany(Resultat::class, 'match_id');
    }


}

