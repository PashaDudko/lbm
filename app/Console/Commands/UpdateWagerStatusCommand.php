<?php

namespace App\Console\Commands;

use App\Http\Services\Wager\WagerStatusChangerService;
use App\Wager;
use App\WagerSettings;
use Illuminate\Console\Command;

class UpdateWagerStatusCommand extends Command
{
    /**
     * @var WagerStatusChangerService
     */
    public $wagerStatusChangerService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-wagers-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status for some wagers';

    /**
     * UpdateWagersStatus constructor.
     * @param WagerStatusChangerService $wagerStatusChangerService
     */
    public function __construct(WagerStatusChangerService $wagerStatusChangerService)
    {
        parent::__construct();
        $this->wagerStatusChangerService = $wagerStatusChangerService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Retrieving wagers, which status can be changed:');
        $wagers = [];
        $settings = WagerSettings::where('status', '!=', 'completed')->get();

        foreach ($settings as $setting) {
            $wagers[] = $setting->wager;
        }

        if (!count($wagers)) {
            $this->line('There is no any appropriate wager for now');
            exit;
        }

        foreach ($wagers as $wager) {
            $this->line("Trying to change current status: {$wager->settings->status} of Wager: {$wager->id}"); // было $wager->title !!
            $result = $this->wagerStatusChangerService->changeWagerStatus($wager);

            if (!is_string($result)) {
                $this->line("Status of Wager: {$wager->id} is changed to {$wager->settings->status}");
            } else {
                $this->error("Status of Wager: {$wager->id} was not changed");
            }
        }

        $this->info('Wagers status update is finished');
    }
}
