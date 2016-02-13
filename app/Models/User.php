<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'character_id', 'character_owner_hash'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];


    public function sites(){
        return $this->belongsToMany('App\Models\Signature', 'user_id');
    }

    public function comments(){
        return $this->belongsToMany('App\Models\Comment', 'user_id');
    }
}
