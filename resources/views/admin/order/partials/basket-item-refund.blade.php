<!-- Modal -->
<div id="orderItemRefundModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="/admin/order/refund-item" method="post" id="tableBasketItemRefund">
                @csrf
                <input type="hidden" name="id" id="basketItemID" value="1">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ürün Para İade İşlemi - <span id="paymentTransactionID"></span></h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Ürün</th>
                            <td id="productName">Ürün Adı</td>
                        </tr>
                        <tr>
                            <th>Sepet Ürün Tutarı</th>
                            <td class="text-bold"><span id="totalPrice">-</span> {{ $currencySymbol }}</td>
                        </tr>
                        <tr>
                            <th>Toplam İade Edilebilir Tutar <i class="fa fa-question-circle" title="Bu ürün için müşterinin karttan çekilen toplam tutar"></i></th>
                            <td class="text-bold"><span id="totalRefundableAmount">-</span> {{ $currencySymbol }}</td>
                        </tr>
                        <tr>
                            <th>Iade Edilebilir Tutar </th>
                            <td class="text-success">
                                <span id="canRefundAmount">- </span>{{ $currencySymbol }}
                            </td>
                        </tr>
                        <tr>
                            <th>Iade Edilen Tutar <i class="fa fa-question-circle" title="Bu ürün için şuana kadar yapılmış iade toplamı"></i></th>
                            <td class="text-danger">
                                <span id="basketRefundedAmount">-</span>
                                {{ $currencySymbol }}</td>
                        </tr>
                        <tr>
                            <th>Iade Edilmek İstenen Tutar</th>
                            <td>
                                <input type="number" step="any" name="refundAmount" id="refundAmountInput" class="form-control" required>
                                <a href="javascript:void(0)" onclick="useTotalWithdrawableAmount()" class="help-block text-green" style="float: right">
                                    tamamını kullan
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" onclick="return confirm('Girilen tutarı kullanıcıya iade etmek istiyor musunuz ? bu işlem geri alınamaz')">Iade Et</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                </div>
            </form>
        </div>

    </div>
</div>
