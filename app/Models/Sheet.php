<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    protected $table = 'sheet';

    public function signature()
    {
        return $this->belongsTo('App\Models\Signature', 'site_id');
    }

    public function pilots()
    {
        return $this->hasMany('App\Models\Pilot');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'sheet_id', 'id');
    }
}
