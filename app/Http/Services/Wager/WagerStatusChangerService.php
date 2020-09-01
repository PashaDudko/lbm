<?php

namespace App\Http\Services\Wager;

use App\Wager;
use App\WagerSettings;
use Carbon\Carbon;

class WagerStatusChangerService
{
    public function changeWagerStatus(Wager $wager)
    {
        if ($this->wagerStatusCanBeChanged($wager)) {
            $currentStatus = $wager->settings->status;
            $key = array_search($currentStatus, WagerSettings::WAGER_STATUSES);
            $key += ($wager->settings->enabled) ? 1 : -1;
            $nextStatus = WagerSettings::WAGER_STATUSES[$key];
            $methodName = 'from' . ucfirst($currentStatus) . 'To' . ucfirst($nextStatus);

            if (method_exists('App\Http\Services\Wager\WagerStatusChangerService', $methodName)){
                return  $this->$methodName($wager, $nextStatus);
            } else {
                return 'There is no method for change current wager status to next one';
            }
        } else {
            return "Status of wager {$wager->id} can't be changed"; // переписать на Exaption !
        }
    }

    private function wagerStatusCanBeChanged(Wager $wager): bool
    {
        if ($wager->settings->status == 'created' && $wager->settings->enabled && Carbon::now() >= Carbon::parse($wager->start_date)){
            return true;
        }

        if ($wager->settings->status == 'active' && !$wager->settings->enabled && Carbon::now() <= Carbon::parse($wager->finish_date)){
            return true;
        }

        if ($wager->settings->status == 'active' && $wager->settings->enabled &&
            (Carbon::now() >= Carbon::parse($wager->finish_date) || $this->betsLimitReached($wager))
        ){
            return true;
        }

/*        if ($wager->status == 'active' && прошло время для перовго бета){
            return true;
        }*/

        return false;
    }

    private function betsLimitReached(Wager $wager): bool
    {
        if (isset($wager->settings->betsLimit) && count($wager->betsEntries) >= $wager->settings->betsLimit) {
            return true;
        }

        return false;
    }

    /**
     * @param Wager $wager
     * @param string $status
     * @return object
     */
    private function saveStatus(Wager $wager, string $status): object
    {
        $wager->settings->status = $status;
        $wager->settings->save();

        return $wager;
    }

    private function fromCreatedToActive(Wager $wager, string $status): object
    {
        return $this->saveStatus($wager, $status);
    }

    private function fromActiveToFinished(Wager $wager, string $status): object
    {
        return $this->saveStatus($wager, $status);
    }

    private function fromActiveToCreated(Wager $wager, string $status): object
    {
        //return $this->saveStatus($wager, $status);
    }

    private function fromActiveToDraft(Wager $wager, string $status): object // если прошло 2 часа, а на вейджер никто не ответил
    {
        //return $this->saveStatus($wager, $status);
    }
}
