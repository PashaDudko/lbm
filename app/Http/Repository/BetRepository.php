<?php

namespace App\Http\Repository;

use App\Wager;
use Illuminate\Support\Facades\DB;

class BetRepository
{
    public function getBetEntries(Wager $wager, string $uuid ) // добавить static ?
    {
        $results = DB::select('SELECT b.id FROM wagers as w
                                     JOIN bets as b
                                     ON w.id = b.wager_id
                                     WHERE w.id = :id AND b.uuid = :uuid',
            [
                'id' => $wager->id,
                'uuid' => $uuid
            ]);

        return $results;
    }

}
