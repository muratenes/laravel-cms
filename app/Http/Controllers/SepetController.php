<?php

namespace App\Http\Controllers;

use App\Models\Ayar;
use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunSubAttribute;
use App\Models\Sepet;
use App\Models\Product\Urun;
use App\Models\SepetUrun;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Interfaces\SepetInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SepetSupportTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SepetController extends Controller
{
    use SepetSupportTrait;
    use ResponseTrait;

    protected SepetInterface $model;
    private UrunlerInterface $productService;
    private KuponInterface $couponService;

    public function __construct(SepetInterface $model, UrunlerInterface $productService, KuponInterface $couponService)
    {
        $this->model = $model;
        $this->productService = $productService;
        $this->couponService = $couponService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $basket = null;
        $productIdList = $this->getProductIdList();
        $cartSubTotalPrice = $this->getCardSubTotal();
        $sessionCoupon = session()->get('coupon');
        if ($request->user()) {
            $basket = Sepet::getCurrentBasket();
        }

        if ($sessionCoupon) {
            $this->couponService->checkCoupon($productIdList, $sessionCoupon['code'], $cartSubTotalPrice, currentCurrencyID(), $basket);
        }


        return view('site.sepet.sepet', compact('basket'));
    }

    /**
     * sepetten ürün siler.
     * @param Request $request
     * @param string $rowID silinecek cart item id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request, string $rowID)
    {
        $cart = $this->getCartItem($rowID);

        if ($request->user()) {
            Sepet::getCurrentBasket()->basket_items()
                ->where(['product_id' => $cart->attributes['product']['id'], 'attributes_text' => $cart->attributes['attributes_text']])
                ->delete();
        }
        $this->removeCartItem($rowID);
        success(__('lang.item_removed'));

        return redirect(route('basket'));
    }


    /**
     * @param Request $request
     * @param string $rowID silinecek cart item id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItemFromBasketWithAjax(Request $request, string $rowID): JsonResponse
    {
        $cart = $this->getCartItem($rowID);

        if ($request->user()) {
            Sepet::getCurrentBasket()->basket_items()
                ->where(['product_id' => $cart->attributes['product']['id'], 'attributes_text' => $cart->attributes['attributes_text']])
                ->delete();
        }
        $this->removeCartItem($rowID);

        return $this->success([
            'card' => [
                'items' => $this->cartItems(),
                'sub_total' => $this->getCardSubTotal(),
                'total' => $this->getCartTotal()
            ]
        ]);

    }

    /**
     * sepetteki tüm ürünleri siler
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
     * sepete ürün eklemek için kullanılır
     * @param Request $request
     * @param Urun $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function addItem(Request $request, Urun $product): JsonResponse
    {
        $request->validate([
            'qty' => 'integer|nullable',
            'selectedAttributeIdList' => 'array|nullable'
        ]);

        $subAttributesId = $this->getSubAttributesIDList($request->get("selectedAttributeIdList"));
        $qty = $request->get('qty', 1);
        $response = $this->addItemToBasket($product, $subAttributesId, $qty);

        if (!$response['status']) {
            return $this->error($response['message']);
        }

        return $this->success([
            'card' => [
                'items' => $this->cartItems(),
                'sub_total' => $this->getCardSubTotal(),
                'total' => $this->getCartTotal()
            ]
        ]);
    }

    /**
     * ürünün seçilmiş özelliklerine göre  subAttributeID listesi döndürür
     * @param array|null $selectedSubAttributesIdTitleList ex 1|2 [attributeId,subAttributeId]
     * @return array
     */
    private function getSubAttributesIDList(?array $selectedSubAttributesIdTitleList): array
    {
        $subAttributesId = [];
        if (is_array($selectedSubAttributesIdTitleList)) {
            foreach ($selectedSubAttributesIdTitleList as $index => $item) {
                $subAttributeId = explode("|", $item)[1];
                $subAttributesId[] = (int)$subAttributeId;
            }
        }

        return $subAttributesId;
    }


}
