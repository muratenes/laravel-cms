<?php

namespace App\Observers;

use App\Models\Product\Urun;
use App\Repositories\Interfaces\UrunlerInterface;
use Psy\Util\Str;

class UrunObserver
{

    /**
     * Handle the urun "deleted" event.
     *
     * @param \App\Models\Urun $urun
     * @return void
     */
    public function deleted(Urun $urun)
    {
        $urun->slug = Str::random(30);
        $urun->save();
    }


}
