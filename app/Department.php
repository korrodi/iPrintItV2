<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function users()
    {
        /* ForeignKey */
        return $this->hasMany('App\User', 'owner_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
