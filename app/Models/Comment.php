<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function sheet()
    {
        return $this->belongsTo('App\Models\Sheet', 'sheet_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id');
    }
}
