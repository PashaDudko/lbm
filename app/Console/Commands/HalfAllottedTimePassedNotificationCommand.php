<?php

namespace App\Console\Commands;

use App\Http\Repository\WagerRepository;
use App\Http\Services\Wager\WagerAllottedTimeCheckerService;
use App\Wager;
use Illuminate\Console\Command;

class HalfAllottedTimePassedNotificationCommand extends Command
{
    /**
     * @var WagerRepository
     */
    public $wagerRepository;

    /**
     * @var WagerAllottedTimeCheckerService
     */
    public $wagerAllottedTimeCheckerService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:half-allotted-time-passed-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send notification to wager owner
                            if half of wager's allotted time has passed
                            and there is still no bet";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        WagerRepository $wagerRepository,
        WagerAllottedTimeCheckerService $wagerAllottedTimeCheckerService
    )
    {
        parent::__construct();
        $this->wagerRepository = $wagerRepository;
        $this->wagerAllottedTimeCheckerService = $wagerAllottedTimeCheckerService;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Retrieving active wagers, that have no bet
        and for which half of the allocated time has already passed");
        $items = $this->wagerRepository->getActiveWagersWithNoBet();
        $this->info(count($items) . " item(s) found");
//        $wagers = Wager::find(1);
        //dd($wagers); // проблемма! если сырым запросом - то объект не класа Вейджер ?? Почему??
//        foreach ($wagers as $wager) {
        foreach ($items as $item) {
            $wager = Wager::find($item->id);
//            dd($wager);
            if ($this->wagerAllottedTimeCheckerService->halfAllotedTimePassedCheck($wager)) {
                $fd = fopen('half_allotted_time_notification.txt', 'a+');
                $str = "Half of the allotted time for
                    wager {$wager->id} with condition: {$wager->condition}
                    has passed, and there is not any participant still.
                    You can PAY to advertise your wager!" . "\n";
                fwrite($fd, $str);
                fclose($fd);
                // Запись в файл - это временно, потом переписать на нотификейшн($wager);
//            https://laravel.com/docs/7.x/notifications
            }
        }
    }
}
