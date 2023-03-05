<?php

namespace App\Observers;

use App\Models\Product\Product;
use Psy\Util\Str;

class UrunObserver
{
    /**
     * Handle the product "deleted" event.
     *
     * @param \App\Models\Urun $urun
     */
    public function deleted(Product $urun)
    {
        $urun->slug = Str::random(30);
        $urun->save();
    }
}
