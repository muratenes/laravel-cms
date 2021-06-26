<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Product\Urun;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FavoriController extends Controller
{
    use ResponseTrait;

    public function list(Request $request)
    {
        $favorites = Favori::with('product')->where('user_id', $request->user()->id)->paginate();

        return view('site.kullanici.favorites', compact('favorites'));
    }

    /**
     * @param Request $request
     * @param Urun    $product
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function addToFavorites(Request $request, Urun $product)
    {
        $request->user()->favorites()->firstOrCreate([
            'product_id' => $product->id,
        ]);

        return $this->success([]);
    }

    /**
     * @param Request $request
     * @param Urun    $product
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Urun $product)
    {
        Favori::where(['product_id' => $product->id, 'user_id' => $request->user()->id])->delete();
        success(__('lang.product_removed_favorites'));

        return back();
    }
}
