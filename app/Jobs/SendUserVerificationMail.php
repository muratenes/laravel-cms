<?php

namespace App\Jobs;

use App\Mail\KullaniciKayitMail;
use App\Models\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendUserVerificationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $user)
    {
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new KullaniciKayitMail($this->user));
    }
}
