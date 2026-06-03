<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;
    protected $fillable = [ 'match_id','resultat','admin_id'];

  
    public function matche()
    {
        return $this->belongsTo(Matche::class, 'match_id', 'id');
    }

     public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
