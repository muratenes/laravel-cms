<?php

namespace App\Repositories\Interfaces;

use App\Models\BasketItem;
use App\Models\Order;

interface OrderInterface
{
    public function createOrderIyzicoDetail($iyzicoData, $orderId);

    public function orderFilterByStatusAndSearchText($search_text, $status, $paginate = false);

    public function getUserAllOrders(int $user_id);

    public function getOrderIyzicoDetail($id);

    public function getUserOrderDetailById(int $user_id, int $order_id);

    public function updateOrderWithItemsStatus($order_id, $order_data, $order_items_status);

    // $productWithAttributeList = [productID,array(subAttributeIdList),qty]
    public function decrementProductQty($productWithAttributeList);

    public function getIyzicoErrorLogs($query);

    /**
     * sipariş ürün iade edilebilir mi ?
     *
     * @param BasketItem $basketItem
     * @param float      $refundAmount iade edilmek istenen tutar
     *
     * @return array
     */
    public function checkCanRefundBasketItem(BasketItem $basketItem, float $refundAmount);

    /**
     * admin sipariş ürün iade edebilir mi ?
     *
     * @param BasketItem $basketItem
     * @param float      $refundAmount iade edilmek istenen tutar
     *
     * @return array
     */
    public function checkCanRefundBasketItemFromAdmin(BasketItem $basketItem, float $refundAmount);

    /**
     * sepetteki ürünü iyzico tarafından iptal eder.
     *
     * @param BasketItem $basketItem
     * @param float      $refundAmount iade edilmek istenen tutar
     *
     * @return array
     */
    public function refundBasketItemFromIyzico(BasketItem $basketItem, float $refundAmount);

    /**
     * sipariş tamamıyla iade ürün iade edilebilir mi ?
     *
     * @param Order $order
     *
     * @return array
     */
    public function checkCanCancelAllOrder(Order $order);

    /**
     * admin siparişi tamamıyla iade  edilebilir mi ?
     *
     * @param Order $order
     *
     * @return array
     */
    public function checkCanCancelAllOrderFromAdmin(Order $order): array;

    /**
     * siparişi tamamıyla iade et.
     *
     * @param Order       $order
     * @param null|string $locale must be : tr,en
     *
     * @return array
     */
    public function cancelOrderFromIyzico(Order $order, ?string $locale);
}
