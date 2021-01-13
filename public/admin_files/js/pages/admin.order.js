function cancelBasketItem(orderID, basketItemID) {
    $.post(`/admin/order/cancel-order-item/${basketItemID}`)
        .then(response => {
            console.log(response)
        })
}

function refundBasketItem(basketItem, totalPrice) {
    var table = $("#tableBasketItemRefund");
    table.find('#refundAmountInput').removeAttr('max').val(0);
    table.find('#productName').text(basketItem.product.title);
    table.find('#totalPrice').text(totalPrice);
    table.find('#totalRefundableAmount').text(totalPrice);
    table.find('#canRefundAmount').text(totalPrice - basketItem.refunded_amount);
    table.find('#basketRefundedAmount').text(basketItem.refunded_amount);
    // table.find('#refundAmountInput').attr('max', basketItem.paid_price - basketItem.refunded_amount);
    table.find('#basketItemID').val(basketItem.id);
    table.find('#paymentTransactionID').text(basketItem.payment_transaction_id);
}

// çekilebilir toplam tutarı inputa yazdırır
function useTotalWithdrawableAmount(){
    var table = $("#tableBasketItemRefund");
    table.find("#refundAmountInput").val(
        parseFloat(table.find("#canRefundAmount").text())
    );
}
