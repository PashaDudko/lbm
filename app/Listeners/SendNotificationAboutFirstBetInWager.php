<?php

namespace App\Listeners;

use App\Events\WagerHasFirstBet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationAboutFirstBetInWager
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WagerHasFirstBet  $event
     * @return void
     */
    public function handle(WagerHasFirstBet $event)
    {
        try {
            $fd = fopen('wager_has_first_bet.txt', 'a+');
            $str = "Congratulations, your wager: " . $event->wager->condition .
                    "is fully activated by user" . $event->wager->user['name'] .
                    " at " . $event->wager->updated_at . "\n";
            fwrite($fd, $str);
            fclose($fd);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
