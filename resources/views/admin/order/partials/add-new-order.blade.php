<div class="box box-default">
    <div class="box-body with-border">
        <div class="row">
            <div class="col-md-10">
                <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                › Siparişler
            </div>
            <div class="col-md-2 text-right mr-3">
                <a href="{{ route('admin.orders') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
            </div>
        </div>
    </div>
</div>
<div class="row" id="createNewOrderContainer">
    <div class="col-xs-8">
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Yeni Sipariş Ekle</h3>
                    <span class="help-block">Bu bölümden yeni sipariş oluşturabilirsiniz.</span>
                </div>
                <form method="POST" action="{{ route('admin.order.create') }}" id="createNewOrderForm">
                    @csrf
                    <div class="box-body">
                        <!-- Firma Seçimi -->
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="vendor_id">Esnaf Seç</label>
                                <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                    <option value="">Esnaf Seçiniz</option>
                                    @foreach($vendors as $vendor)
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

                    <div class="box-footer d-flex justify-content-end align-items-center gap-3">
                        <strong>Sipariş Toplamı: <span id="total-amount">0.00</span>₺</strong>
                        <button type="submit" class="btn btn-primary" style="float: right">Sipariş Oluştur</button>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>

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




