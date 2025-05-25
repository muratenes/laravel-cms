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
<div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="text-align: left">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('admin.order.create') }}" id="createNewOrderForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Sipariş Ekle</h5>
                    <span class="help-block">Bu bölümden yeni sipariş oluşturabilirsiniz.</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="createNewOrderContainer">
                        <div class="col-xs-12">
                            <section class="content">
                                <div class="box box-primary">


                                    <div class="box-body">
                                        <!-- Firma Seçimi -->
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="vendor_id">Esnaf Seç</label>
                                                <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                                    <option value="">Esnaf Seçiniz</option>
                                                    @foreach($settings['vendors'] as $vendor)
                                                        <option selected value="{{ $vendor['id'] }}">{{ $vendor['title'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="due_date">Sipariş Tarihi</label>
                                                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="product_id">Ürün Seç</label>
                                                <select id="productId" class="form-control select2" required>
                                                    <option value="">--Ürün Seçiniz--</option>
                                                    @foreach($settings['products'] ?? [] as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="company_id"></label>
                                                <button type="button" class="btn btn-default  btn-sm form-control" id="add-order-product-row"><i class="fa fa-plus"></i> Ürün Ekle</button>
                                            </div>
                                        </div>
                                        <hr>

                                        <!-- Ürünler -->
                                        <table class="table table-bordered" id="order-product-table">
                                            <thead>
                                            <tr>
                                                <th>Ürün</th>
                                                <th>Adet</th>
                                                <th>Birim Fiyat</th>
                                                <th>Toplam</th>
                                            </tr>
                                            </thead>
                                            <tbody id="order-rows-body">
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="box-footer d-flex justify-content-end align-items-right gap-3" style="text-align: right">
                                        <strong>Sipariş Toplamı: <span id="total-amount">0.00</span>₺</strong>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Sipairişi oluştur</button>
                </div>
            </div>
        </form>
    </div>
</div>


