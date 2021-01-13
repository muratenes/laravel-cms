function refundBasketItem(basketItem,basketItemID) {
    var table = $("#tableBasketItemRefund");
    $.post(`/admin/order/basket/${basketItemID}`)
        .then(response => {
            console.log(response);
            const data = response.data.basket;
            table.find('#refundAmountInput').removeAttr('max').val(0);
            table.find('#productName').text(basketItem.product.title);
            table.find('#totalPrice').text(data.total);
            table.find('#totalRefundableAmount').text(data.total);
            table.find('#canRefundAmount').text(data.total - data.refunded_amount);
            table.find('#basketRefundedAmount').text(data.refunded_amount);
            // table.find('#refundAmountInput').attr('max', basketItem.paid_price - basketItem.refunded_amount);
            table.find('#basketItemID').val(data.id);
            table.find('#paymentTransactionID').text(data.payment_transaction_id);
        })

}

// çekilebilir toplam tutarı inputa yazdırır
function useTotalWithdrawableAmount() {
    var table = $("#tableBasketItemRefund");
    table.find("#refundAmountInput").val(
        parseFloat(table.find("#canRefundAmount").text())
    );
}
