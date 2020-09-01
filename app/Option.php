<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function wager()
    {
        return $this->belongsTo('App\Wager');
    }

    public function bets()
    {
        return $this->hasMany('App\Bet');
    }
}
