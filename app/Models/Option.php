<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    public function scopeKey($query, $key)
    {
        return $query->where('key', $key)->get();
    }
}
