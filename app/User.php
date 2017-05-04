<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public function departments()
    {
        return $this->belongsTo('App\Department');
    }
    public function requests()
    {
        /* ForeignKey */
        return $this->hasMany('App\Request', 'owner_id');
    }

    public function comments()
    {
        /* ForeignKey */
        return $this->hasMany('App\Comment', 'user_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'department_id', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
