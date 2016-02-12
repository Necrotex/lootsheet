<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    protected $table = 'pilots';
    protected $fillable = ['name', 'sheet_id', 'role']; // needed for mass assignment

    public function sheet()
    {
        return $this->belongsTo('App\Models\Sheet');
    }
}
