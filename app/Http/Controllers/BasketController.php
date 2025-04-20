<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\BasketInterface;
use App\Repositories\Interfaces\CouponInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\CartTrait;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SepetSupportTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    use ResponseTrait;
    use SepetSupportTrait;

    protected BasketInterface $model;
    private ProductInterface $productService;
    private CouponInterface $couponService;

    public function __construct(BasketInterface $model, ProductInterface $productService, CouponInterface $couponService)
    {
        $this->model = $model;
        $this->productService = $productService;
        $this->couponService = $couponService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $basket = null;
        $productIdList = $this->getProductIdList();
        $cartSubTotalPrice = $this->getCardSubTotal();
        $sessionCoupon = session()->get('coupon');
        if ($request->user()) {
            $basket = Basket::getCurrentBasket();
        }

        if ($sessionCoupon) {
            $this->couponService->checkCoupon($productIdList, $sessionCoupon['code'], $cartSubTotalPrice, currentCurrencyID(), $basket);
        }

        return view('site.basket.sepet', compact('basket'));
    }

    /**
     * sepetten ürün siler.
     *
     * @param Request $request
     * @param string  $rowID   silinecek cart item id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request, string $rowID)
    {
        $cart = $this->getCartItem($rowID);

        if ($request->user()) {
            Basket::getCurrentBasket()->basket_items()
                ->where(['product_id' => $cart->attributes['product']['id'], 'attributes_text' => $cart->attributes['attributes_text']])
                ->delete()
            ;
        }
        $this->removeCartItem($rowID);
        success(__('lang.item_removed'));

        return redirect(route('basket'));
    }

    /**
     * sepetteki ürünü 1 adet azaltır.
     *
     * @param Request $request
     * @param string  $rowID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrement(Request $request, string $rowID)
    {
        // todo GAte ekle
        $cartItem = $this->getCartItem($rowID);
        if (! $cartItem) {
            $this->error(__('lang.basket_item_not_found'));
        }

        $quantity = $this->getCartItemQuantity($cartItem);
        $this->decrementItem($cartItem);
        if ($request->user()) {
            if (1 === $quantity) {
                Basket::getCurrentBasket()->basket_items()
                    ->where(['product_id' => $cartItem->attributes['product']['id']])
                    ->delete()
                ;
            } else {
                Basket::getCurrentBasket()->basket_items()
                    ->where(['product_id' => $cartItem->attributes['product']['id']])
                    ->decrement('qty')
                ;
            }
        }

        return $this->success([
            'card' => [
                'items'       => $this->cartItems(),
                'sub_total'   => $this->getCardSubTotal(),
                'total'       => $this->getCartTotal(),
                'cargo_price' => CartTrait::getCartTotalCargoAmount(),
            ],
            'html' => view('site.basket.partials.basket-items')->render(),
        ]);
    }

    /**
     * @param Request $request
     * @param string  $rowID   silinecek cart item id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItemFromBasketWithAjax(Request $request, string $rowID): JsonResponse
    {
        $cart = $this->getCartItem($rowID);

        if ($request->user()) {
            Basket::getCurrentBasket()->basket_items()
                ->where(['product_id' => $cart->attributes['product']['id'], 'attributes_text' => $cart->attributes['attributes_text']])
                ->delete()
            ;
        }
        $this->removeCartItem($rowID);

        return $this->success([
            'card' => [
                'items'     => $this->cartItems(),
                'sub_total' => $this->getCardSubTotal(),
                'total'     => $this->getCartTotal(),
            ],
            'html' => view('site.basket.partials.items')->render(),
        ]);
    }

    /**
     * sepetteki tüm ürünleri siler.
     *
     * @param Request $request
     */
    public function clearBasket(Request $request)
    {
        foreach ($this->cartItems() as $item) {
            $this->removeItemFromBasketWithAjax($request, $item->id);
        }

        return redirect(route('basket'))->with('message', __('lang.removed_all_items'));
    }

    /**
     * sepete ürün eklemek için kullanılır.
     *
     * @param Request $request
     * @param Product $product
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addItem(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'qty'                     => 'integer|nullable',
            'selectedAttributeIdList' => 'array|nullable',
        ]);

        $subAttributesId = $this->getSubAttributesIDList($request->get('selectedAttributeIdList'));
        $qty = $request->get('qty', 1);
        $response = $this->addItemToBasket($product, $subAttributesId, $qty);

        if (! $response['status']) {
            return $this->error($response['message']);
        }

        return $this->success([
            'card' => [
                'items'       => $this->cartItems(),
                'sub_total'   => $this->getCardSubTotal(),
                'total'       => $this->getCartTotal(),
                'cargo_price' => CartTrait::getCartTotalCargoAmount(),
            ],
            'html' => view('site.basket.partials.items')->render(),
        ], __('lang.added_to_basket'));
    }

    /**
     * ürünün seçilmiş özelliklerine göre  subAttributeID listesi döndürür.
     *
     * @param null|array $selectedSubAttributesIdTitleList ex 1|2 [attributeId,subAttributeId]
     *
     * @return array
     */
    private function getSubAttributesIDList(?array $selectedSubAttributesIdTitleList): array
    {
        $subAttributesId = [];
        if (\is_array($selectedSubAttributesIdTitleList)) {
            foreach ($selectedSubAttributesIdTitleList as $index => $item) {
                $subAttributeId = explode('|', $item)[1];
                $subAttributesId[] = (int) $subAttributeId;
            }
        }

        return $subAttributesId;
    }
}
