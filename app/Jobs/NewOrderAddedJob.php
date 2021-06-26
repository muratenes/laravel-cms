<?php

namespace App\Jobs;

use App\Mail\Order\OrderCreateadMail;
use App\Models\Auth\Role;
use App\Models\Sepet;
use App\Models\Siparis;
use App\Notifications\order\AdminNewOrderNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewOrderAddedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var Siparis
     */
    public Siparis $order;

    /**
     * @var Sepet
     */
    public Sepet $basket;

    /**
     * @var User
     */
    public User $user;

    /**
     * Create a new notification instance.
     *
     * @param Siparis $order
     */
    public function __construct(Siparis $order)
    {
        $this->order = $order;
        $this->basket = $order->basket;
        $this->user = $order->basket->user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->user)->send(new OrderCreateadMail($this->order));
        $adminUsers = User::where('role_id', [Role::ROLE_SUPER_ADMIN, Role::ROLE_STORE])->get();
        foreach ($adminUsers as $user) {
            $user->notify(new AdminNewOrderNotification($this->order));
        }
    }
}
