<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KullaniciKayitMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    public $kullanici;

    public function __construct(User $kullanici)
    {
        $this->kullanici = $kullanici;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name') . ' - Kullanıcı Kaydi')
            ->view('emails.kullanici_kayit')
        ;
    }
}
