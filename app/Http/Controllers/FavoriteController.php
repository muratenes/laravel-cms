<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product\Product;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ResponseTrait;

    public function list(Request $request)
    {
        $favorites = Favorite::with('product')->where('user_id', $request->user()->id)->paginate();

        return view('site.user.favorites', compact('favorites'));
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function addToFavorites(Request $request, Product $product)
    {
        $request->user()->favorites()->firstOrCreate([
            'product_id' => $product->id,
        ]);

        return $this->success([]);
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Product $product)
    {
        Favorite::where(['product_id' => $product->id, 'user_id' => $request->user()->id])->delete();
        success(__('lang.product_removed_favorites'));

        return back();
    }
}
