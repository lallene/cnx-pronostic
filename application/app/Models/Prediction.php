<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = ['prediction', 'user_id', 'match_id'];

    public function User(){

        return $this->belongsTo( User::class);
    }

    public function match()
    {
        return $this->belongsTo(Matche::class, 'match_id');
    }

}
