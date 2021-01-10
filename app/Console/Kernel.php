<?php

namespace App\Console;

use App\Jobs\CheckExpiredCampaignAndRemoveDiscountPrices;
use App\Jobs\CheckPendingCampaignsAndUpdateProductDiscountPrices;
use App\Jobs\CheckPendingOrExpiredCoupons;
use App\Models\Kampanya;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new CheckExpiredCampaignAndRemoveDiscountPrices())->everyFiveMinutes();
        $schedule->job(new CheckPendingCampaignsAndUpdateProductDiscountPrices())->everyFiveMinutes();
        $schedule->job(new CheckPendingOrExpiredCoupons())->everyFiveMinutes();

        $schedule->command('backup:run --only-db')->daily();
        $schedule->command('backup:clean --only-db')->daily();

//        $schedule->command('telescope:prune')->monthly();
//        $schedule->command('backup:run')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
