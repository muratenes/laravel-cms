<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\BasketItem;
use App\Models\Config;
use App\Models\Iyzico;
use App\Models\Log;
use App\Models\Order;
use App\Models\Product\Product;
use App\Models\Product\ProductVariant;
use App\Models\İyzicoFailsJson;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\SiparisInterface;
use App\Repositories\Traits\ResponseTrait;
use Carbon\Carbon;

class ElSiparisDal implements SiparisInterface
{
    use ResponseTrait;

    protected $model;

    public function __construct(Order $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = ['*'], $relations = null)
    {
    }

    public function allWithPagination($filter = null, $columns = ['*'], $perPageItem = null, $relations = null)
    {
    }

    public function getById($id, $columns = ['*'], $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null)
    {
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        $order = $this->model->getById($id);

        return $order->forceDelete($id);
    }

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    public function orderFilterByStatusAndSearchText($search_text, $status, $paginate = false)
    {
        return $this->model->with('basket.user')
            ->when($status, function ($q, $status) {
                return $q->where('status', $status);
            })
            ->where(function ($query) use ($search_text) {
                return $query->where('full_name', 'like', "%{$search_text}%")
                    ->orWhere('id', $search_text)
                ;
            })
            ->orderByDesc('id')->when(null !== $paginate, function ($q) use ($paginate) {
                if (true === $paginate) {
                    return $q->paginate();
                }

                return $q->get();
            });
    }

    public function getUserAllOrders(int $user_id)
    {
        return $this->model->with('basket')->whereHas('basket', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
    }

    public function getUserOrderDetailById(int $user_id, int $order_id)
    {
        return $this->model->with('basket.basket_items.product')->whereHas('basket', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->where('orders.id', $order_id)->firstOrFail();
    }

    public function updateOrderWithItemsStatus($order_id, $order_data, $order_items_status)
    {
        try {
            $data = $this->getById($order_id, null, 'basket.basket_items');
            $data->update($order_data);
            foreach ($order_items_status as $item) {
                BasketItem::where(['id' => $item[0]])->first()->update(['status' => $item[1]]);
            }
            session()->flash('message', config('constants.messages.success_message'));
        } catch (\Exception $exception) {
            session()->flash('message', 'sepet güncellenirken hata oldu ' + $exception->getMessage());
            session()->flash('message_type', 'danger');
        }
    }

    // $productWithAttributeList = [productID,array(subAttributeIdList),qty]
    public function decrementProductQty($productWithAttributeList)
    {
        foreach ($productWithAttributeList as $index => $item) {
            $variant = ProductVariant::urunHasVariant($item['product_id'], $item['sub_attributes']);
            if ($variant) {
                $variant->decrement('qty', $item['qty']);
            } else {
                Product::find($item['product_id'])->decrement('qty', $item['qty']);
            }
        }
    }

    /**
     * @param $iyzicoData
     * @param $orderId
     * @param $iyzicoJsonResponse
     */
    public function createOrderIyzicoDetail($iyzicoData, $orderId)
    {
        $iyzicoData['siparis_id'] = $orderId;
        $iyzicoData['iyzicoJson'] = $iyzicoData;

        return Iyzico::create($iyzicoData);
    }

    public function getIyzicoErrorLogs($query)
    {
        return İyzicoFailsJson::orderByDesc('id')->when(null !== $query, function ($q) use ($query) {
            $q->where('user_id', 'like', "%{$query}%")
                ->orWhere('full_name', 'like', "%{$query}%")
                ->orWhere('basket_id', 'like', "%{$query}%")
                ->orWhere('json_response', 'like', "%{$query}%")
            ;
        })->simplePaginate();
    }

    public function getOrderIyzicoDetail($id)
    {
        return İyzicoFailsJson::find($id);
    }

    /**
     * sipariş ürün iade edilebilir mi ?
     *
     * @param BasketItem $basketItem
     * @param float      $refundAmount iade edilmek istenen tutar
     *
     * @return array
     */
    public function checkCanRefundBasketItem(BasketItem $basketItem, float $refundAmount)
    {
        if (($refundAmount + $basketItem->refunded_amount) > $basketItem->total) {
            return $this->response(false, __('lang.the_amount_refunded_cannot_be_greater_than_the_grand_total', ['refunded_amount' => $refundAmount + $basketItem->refunded_amount]));
        }
        $checkStatus = [
            BasketItem::STATUS_BASARISIZ,
            BasketItem::STATUS_IADE_EDILDI,
            BasketItem::STATUS_IPTAL_EDILDI,
        ];
        if (\in_array($basketItem->status, $checkStatus, true)) {
            return $this->response(false, __('messages.can_not_cancel_basket_item', ['status' => $basketItem->statusLabel()]));
        }
        $now = Carbon::now();
        $afterTwoWeek = $basketItem->created_at->addDays(14);
        if ($afterTwoWeek <= $now) {
            return $this->response(false, __('lang.you_can_not_refund_basket_item_two_week_error'));
        }

        return $this->response(true, __('lang.can_be_canceled'));
    }

    public function refundBasketItemFromIyzico(BasketItem $basketItem, float $refundAmount)
    {
        $order = $basketItem->basket->order;
        $request = new \Iyzipay\Request\CreateRefundRequest();
        $request->setLocale($basketItem->basket->user->locale_iyzico);
        $request->setPrice($refundAmount);
        $request->setPaymentTransactionId($basketItem->payment_transaction_id);
        $request->setConversationId($basketItem->id . ':' . $refundAmount);
        $request->setIp(request()->ip());

        $refundResponse = json_decode(\Iyzipay\Model\Refund::create($request, Iyzico::getOptions())->getRawResult(), true);
        if ('success' !== $refundResponse['status']) {
            Log::addIyzicoLog(__('log.admin.basket_item_refund_error', ['itemId' => $basketItem->id, 'message' => $refundResponse['errorMessage']]), json_encode($refundResponse), $order->id, Log::TYPE_ORDER);

            return $this->response(false, $refundResponse['errorMessage']);
        }
        $basketItem->refunded_amount += $refundAmount;
        $basketItem->status = $basketItem->refunded_amount === $basketItem->total ? BasketItem::STATUS_IADE_EDILDI : BasketItem::STATUS_KISMI_IADE;
        $basketItem->save();

        return $this->response(
            true,
            __('lang.product_cancelled_with_amount', ['product' => $basketItem->product->title, 'amount' => $refundAmount, 'currency' => Config::getCurrencySymbolById($order->currency_id)]),
            $refundResponse
        );
    }

    /**
     * sipariş tamamıyla iptal edilebilir mi ?
     *
     * @param Order $order
     *
     * @return array
     */
    public function checkCanCancelAllOrder(Order $order)
    {
        $checkStatus = [
            Order::STATUS_ONAY_BEKLIYOR,
            Order::STATUS_SIPARIS_ALINDI,
            Order::STATUS_HAZIRLANIYOR,
            Order::STATUS_HAZIRLANDI,
            Order::STATUS_TAMAMLANDI,
        ];
        if (! \in_array($order->status, $checkStatus, true)) {
            return $this->response(false, __('lang.can_not_cancel_basket_item', ['status' => $order->statusLabel()]));
        }
        $now = Carbon::now();
        if (! $now->isSameDay($order->created_at) || $order->created_at >= $now->setHour(16)->setMinute(55)) {
            return $this->response(false, __('messages.the_order_cannot_be_canceled_because_it_is_not_on_the_same_day'));
        }

        return $this->response(true, __('messages.can_be_canceled'));
    }

    /**
     * @param Order       $order
     * @param null|string $locale must be: en,tr
     *
     * @return array
     */
    public function cancelOrderFromIyzico(Order $order, ?string $locale)
    {
        $request = new \Iyzipay\Request\CreateCancelRequest();
        $request->setLocale($locale ?? $order->basket->user->locale_iyzico);
        $request->setConversationId($order->iyzico->paymentId);
        $request->setPaymentId($order->iyzico->paymentId);
        $request->setIp(request()->ip());

        return json_decode(\Iyzipay\Model\Cancel::create($request, Iyzico::getOptions())->getRawResult(), true);
    }

    public function checkCanCancelAllOrderFromAdmin(Order $order): array
    {
        $checkStatus = [
            Order::STATUS_ONAY_BEKLIYOR,
            Order::STATUS_SIPARIS_ALINDI,
            Order::STATUS_HAZIRLANIYOR,
            Order::STATUS_HAZIRLANDI,
            Order::STATUS_TAMAMLANDI,
        ];
        if (! \in_array($order->status, $checkStatus, true)) {
            return $this->response(false, __('lang.order_can_not_cancel_basket_item', ['status' => $order->statusLabel()]));
        }

        return $this->response(true, __('messages.can_be_canceled'));
    }

    public function checkCanRefundBasketItemFromAdmin(BasketItem $basketItem, float $refundAmount)
    {
        if (($refundAmount + $basketItem->refunded_amount) > $basketItem->total) {
            return $this->response(false, __('lang.the_amount_refunded_cannot_be_greater_than_the_grand_total', ['refunded_amount' => $refundAmount + $basketItem->refunded_amount]));
        }
        $checkStatus = [
            BasketItem::STATUS_BASARISIZ,
            BasketItem::STATUS_IADE_EDILDI,
            BasketItem::STATUS_IPTAL_EDILDI,
        ];
        if (\in_array($basketItem->status, $checkStatus, true)) {
            return $this->response(false, __('messages.can_not_cancel_basket_item', ['status' => $basketItem->statusLabel()]));
        }

        return $this->response(true, __('lang.can_be_canceled'));
    }
}
