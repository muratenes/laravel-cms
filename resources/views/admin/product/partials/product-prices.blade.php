<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('admin.product.price_info')</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-2">
                <label>@lang('admin.product.price') (₺)</label>
                <input type="number" step="any" class="form-control" name="tl_price" placeholder="ürün ₺ değeri" required
                       value="{{ old('tl_price', $product->tl_price) }}">
            </div>
            <div class="form-group col-md-2">
                <label>@lang('admin.product.discount_price') (₺)</label>
                <input type="number" step="any" class="form-control" name="tl_discount_price" placeholder="ürün ₺ indirimli değeri"
                       value="{{ old('tl_discount_price', $product->tl_discount_price) }}">
            </div>
        @if(config('admin.multi_currency'))
            <!--- USD değeri -->
                <div class="form-group col-md-2">
                    <label>@lang('admin.product.price') ($)</label>
                    <input type="number" step="any" class="form-control" name="usd_price" placeholder="ürün $ değeri" required
                           value="{{ old('usd_price', $product->usd_price) }}">
                </div>
                <div class="form-group col-md-2">
                    <label>@lang('admin.product.discount_price') ($)</label>
                    <input type="number" step="any" class="form-control" name="usd_discount_price" placeholder="ürün $ indirimli değeri"
                           value="{{ old('usd_discount_price', $product->usd_discount_price) }}">
                </div>

                <!--- EURO değeri -->
                <div class="form-group col-md-2">
                    <label>@lang('admin.product.price') (£)</label>
                    <input type="number" step="any" class="form-control" name="eur_price" placeholder="ürün £ değeri" required
                           value="{{ old('eur_price', $product->eur_price) }}">
                </div>
                <div class="form-group col-md-2">
                    <label>@lang('admin.product.discount_price') (£)</label>
                    <input type="number" step="any" class="form-control" name="eur_discount_price" placeholder="ürün £ indirimli değeri"
                           value="{{ old('eur_discount_price', $product->eur_discount_price) }}">
                </div>
            @endif
        </div>

    </div>
</div>
