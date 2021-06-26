<?php

namespace App\Repositories\Interfaces;

use App\Models\SepetUrun;
use App\Models\Siparis;

interface SiparisInterface extends BaseRepositoryInterface
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
     * @param SepetUrun $basketItem
     * @param float     $refundAmount iade edilmek istenen tutar
     *
     * @return array
     */
    public function checkCanRefundBasketItem(SepetUrun $basketItem, float $refundAmount);

    /**
     * admin sipariş ürün iade edebilir mi ?
     *
     * @param SepetUrun $basketItem
     * @param float     $refundAmount iade edilmek istenen tutar
     *
     * @return array
     */
    public function checkCanRefundBasketItemFromAdmin(SepetUrun $basketItem, float $refundAmount);

    /**
     * sepetteki ürünü iyzico tarafından iptal eder.
     *
     * @param SepetUrun $basketItem
     * @param float     $refundAmount iade edilmek istenen tutar
     *
     * @return array
     */
    public function refundBasketItemFromIyzico(SepetUrun $basketItem, float $refundAmount);

    /**
     * sipariş tamamıyla iade ürün iade edilebilir mi ?
     *
     * @param Siparis $order
     *
     * @return array
     */
    public function checkCanCancelAllOrder(Siparis $order);

    /**
     * admin siparişi tamamıyla iade  edilebilir mi ?
     *
     * @param Siparis $order
     *
     * @return array
     */
    public function checkCanCancelAllOrderFromAdmin(Siparis $order): array;

    /**
     * siparişi tamamıyla iade et.
     *
     * @param Siparis     $order
     * @param null|string $locale must be : tr,en
     *
     * @return array
     */
    public function cancelOrderFromIyzico(Siparis $order, ?string $locale);
}
