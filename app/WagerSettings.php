<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WagerSettings extends Model
{
    const WAGER_STATUSES = [
        '0' => 'draft',
        '1' => 'created',
        '2' => 'active',
        '3' => 'finished',
        '4' => 'completed',
        '5' => 'declined',
    ];

    protected $guarded = [];

    public function wager()
    {
        return $this->belongsTo('App\Wager');
//        return $this->hasOne('App\Wager');

    }
}
