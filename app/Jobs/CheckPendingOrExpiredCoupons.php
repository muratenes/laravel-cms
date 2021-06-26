<?php

namespace App\Jobs;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckPendingOrExpiredCoupons
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->checkPendingCoupons();
        $this->checkExpiredCoupons();
    }

    /**
     * aktif olmak için bekleyen kuponları aktif hale getirir.
     *
     * @return mixed
     */
    private function checkPendingCoupons()
    {
        $prevXMinute = Carbon::now()->subMinutes(config('admin.check_coupon_prev_minute'));

        $now = Carbon::now();

        return Coupon::whereBetween('start_date', [$prevXMinute, $now])
            ->where('end_date', '>', Carbon::now())
            ->where('active', false)
            ->update(['active' => true])
        ;
    }

    /**
     * süresi dolmuş kuponları deaktif eder.
     *
     * @return mixed
     */
    private function checkExpiredCoupons()
    {
        return Coupon::where('end_date', '<', Carbon::now())
            ->where('active', true)
            ->update(['active' => false])
        ;
    }
}
