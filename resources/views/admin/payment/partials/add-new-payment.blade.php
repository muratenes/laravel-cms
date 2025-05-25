<table class="d-none" style="display: none">
    <tbody class="template-order-product-row">
    <tr>
        <td>
            <select name="items[][product_id]" class="form-control select2 productSelect disabled" readonly>
                <option value="">Ürün Seçiniz</option>
                @foreach($settings['products'] ?? [] as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="items[][quantity]" class="form-control" min="1" value="1">
        </td>
        <td>
            <input type="number" name="items[][per_price]" class="form-control productPrice" step="0.01" min="0" required>
        </td>

        <td>
            <span><span class="line-total">0</span>₺</span>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="createPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="text-align: left">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('admin.payments.create') }}" id="createNewPaymentForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ödeme Ekle</h5>
                    <span class="help-block">Bu bölümden yeni ödeme ekleyebilirsiniz.</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="createNewPaymentContainer">
                        <div class="col-xs-12">
                            <section class="content">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="vendor_id">Esnaf Seç</label>
                                                <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                                    <option value="">Esnaf Seçiniz</option>
                                                    @foreach($settings['vendors'] as $vendor)
                                                        <option value="{{ $vendor['id'] }}">{{ $vendor['title'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="due_date">Ödeme Tarihi</label>
                                                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="credit_cart_amount">Kartla Ödenen <i class="fa fa-info-circle" title="Kartla ödenen tutar"></i></label>
                                                <input type="number" step="any" name="credit_cart_amount" id="credit_cart_amount" class="form-control payment-amount-item" value="0" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="cash_amount">Nakit Ödenen* <i class="fa fa-info-circle" title="Nakit ödenen tutar"></i></label>
                                                <input type="number" step="any" name="cash_amount" id="cash_amount" class="form-control payment-amount-item" value="0" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="cash_amount">Açıklama</label>
                                                <textarea class="form-control" name="description" maxlength="255"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="box-footer d-flex justify-content-end align-items-right gap-3" style="text-align: right">
                                        <strong>Ödeme Toplamı: <span id="total-amount-for-payment">0.00</span>₺</strong>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Ödemeyi Ekle</button>
                </div>
            </div>
        </form>
    </div>
</div>


