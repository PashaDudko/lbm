<?php

namespace App\Http\Repository;

use App\WagerSettings;
use Illuminate\Support\Facades\DB;

class WagerRepository
{
    public function getActiveWagersWithNoBet()
    {
/*        $results = DB::table('wagers')
            ->selectRaw("SELECT * FROM wagers as w
                                     JOIN wager_settings as ws
                                     ON w.id = ws.wager_id
                                     WHERE w.first_bet_in_allotted_time = false
                                     AND ws.status = 'active'
                                     AND w.first_bet_in_allotted_time = false")->get();*/

/*        $results = DB::select(DB::raw("SELECT * FROM wagers as w
                                     JOIN wager_settings as ws
                                     ON w.id = ws.wager_id
                                     WHERE w.first_bet_in_allotted_time = false
                                     AND ws.status = 'active'
                                     AND w.first_bet_in_allotted_time = false;
                                     ",*/
        /*
            [
                'statusFalse1' => false, //?
                'status' => WagerSettings::WAGER_STATUSES['2'],//?
                'statusFalse2' => false,//?

            ]));*/
              $results = DB::select('SELECT w.id FROM wagers as w
                                     JOIN wager_settings as ws
                                     ON w.id = ws.wager_id
                                     WHERE w.first_bet_at_allotted_time = :statusFalse
                                     AND ws.status = :active
                                     ',
            [
                'statusFalse' => false, //?
                'active' => WagerSettings::WAGER_STATUSES['2'],//?
//                'statusFalse2' => false,//?

            ]);


        return $results;
/*        И количество bet у этого wager = 0
(скорее всего просто через right join какой-то ^^)*/
    }

}
