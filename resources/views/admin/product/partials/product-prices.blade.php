<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Fiyat Bilgileri</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label>Alış Fiyatı (₺)</label>
                <input type="number" step="any" class="form-control" name="purchase_price" placeholder="Ürün Alış Fiyatı" required
                       value="{{ old('purchase_price', $product->purchase_price) }}">
            </div>
            <div class="form-group col-md-6">
                <label>Satış Fiyatı (₺)</label>
                <input type="number" step="any" class="form-control" name="price" placeholder="Satış Fiyatı"
                       value="{{ old('price', $product->price) }}">
            </div>
        </div>

    </div>
</div>
