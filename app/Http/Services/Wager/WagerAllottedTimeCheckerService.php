<?php

namespace App\Http\Services\Wager;

use App\Wager;
use Illuminate\Support\Carbon;

class WagerAllottedTimeCheckerService
{
    /**
     * @param Wager $wager
     *
     * @return bool
     */
    public function halfAllotedTimePassedCheck(Wager $wager): bool
    {
        $now = Carbon::now();
        $halfAllottedTime = $wager->settings->allotted_time_for_first_bet / 2;
        $halfAllottedTimeEnd = Carbon::parse($wager->start_date)->add($halfAllottedTime, 'hour');

        if ($now  >= $halfAllottedTimeEnd ) {
            return true;
        }

        return false;
    }

    /**
     * @param Wager $wager
     *
     * @return bool
     */
//    public function allotedTimePassedCheck(Wager $wager): bool
//    {
//
//    }

}
