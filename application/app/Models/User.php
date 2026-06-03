<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;


use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'id_wd',
            'name',
            'pseudo',
            'avatar',
            'email',
            'password',
            'projet_service',
            'fonction',
            'manager',
            'xp',
            'level',
            'current_streak',
            'best_streak',
            'password_first_connection'
    ];
    protected $appends = ['avatar_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')->withTimestamps();
    }


    protected function avatarUrl(): Attribute
    {
        return Attribute::get(fn () => $this->avatar 
            ? asset($this->avatar) 
            : asset('avatars/avatar.webp')
        );
    }

    public function score()
    {
        return $this->hasOne(\App\Models\UserScore::class);
    }

}

