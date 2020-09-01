<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wager extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['start_date, finish_date, deleted_at'];

    public function settings()
    {
        return $this->hasOne('App\WagerSettings');
    }

    public function options()
    {
        return $this->hasMany('App\Option');
    }

    public function betsEntries()
    {
        return $this->hasMany('App\BetEntry');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
