<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $guarded = [];

    public function answer()
    {
        return $this->belongsTo('App\Answer');
    }
}
