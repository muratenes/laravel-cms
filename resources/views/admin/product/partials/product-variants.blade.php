<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">@lang('admin.product.variants')
                    <small>@lang('admin.product.you_can_define_variants_by_attribute')</small>
                </h3>
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-default btn-sm" title="@lang('admin.proudct.add_new_variant')" onclick="addNewProductVariantItem({{$product->id}})">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="box-body pad" id="productVariantContainer">

                @foreach($productVariants as $index => $variant)
                    <!-- product variant item -->
                        <div class="form-row row productVariantItem" data-index="{{ $index }}">
                        <!-- variant id below hidden input name=variantIndexHidden{{$index}}-->
                            <input type="hidden" value="{{ $variant->id }}" name="variants[{{$index}}][id]">
                            <div class="form-group">
                                @foreach($productDetails as $subIndex => $detail)

                                    <div class="col-md-1">
                                        <td><label for="">{{ $detail['attribute']['title'] }}</label>
                                        <!-- variant attributeID name=variantAttributeHidden{{$index}}-->
                                            <input type="hidden" value="{{ $detail['attribute']['id'] }}" name="variants[{{$index}}][attributes][{{ $subIndex }}][attribute_id]">
                                        </td>
                                        <td>
                                            <select name="variants[{{$index}}][attributes][{{ $subIndex }}][sub_attribute]" class="form-control">
                                                <option value="">Seçiniz</option>
                                                @foreach($detail['sub_details'] as $subDetail)
                                                    <option {{ collect($variant->urunVariantSubAttributes()->get()->map(function ($item) {
                                                                     return $item->sub_attr_id;
                                                                    }))->contains($subDetail['sub_attribute']) ? 'selected' : 'note' }}

                                                            value="{{  $subDetail['parent_sub_attribute']['id'] }}">


                                                        {{ $subDetail['parent_sub_attribute']['title'] }}</option>
                                                @endforeach
                                            </select>

                                        </td>
                                    </div>

                            @endforeach
                            <!-- variant currency -->
                                <div class="col-md-2">
                                    <td>
                                        <label for="">Para Birimi</label>
                                        <i class="fa fa-question-circle" title="Seçilen özellikler hangi para biriminde uygulanacaksa o seçilmelidir"></i>
                                    </td>
                                    <td>
                                        <select name="variants[{{ $index }}][currency]" id="" class="form-control" required>
                                            <option value="">---Para birimi seçiniz--</option>
                                            @foreach($data['currencies'] as $currency)
                                                <option value="{{ $currency[0] }}" {{ $variant->currency == $currency[0] ? 'selected' : '' }}>
                                                    {{ $currency[1] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </div>
                                <!-- ./variant currency -->
                                <div class="col-md-1">
                                    <td><label for="">@lang('admin.price')</label>
                                        <i class="fa fa-question-circle" title="Ürünün girilen özelliklere ait fiyatı"></i>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" value="{{ $variant->price }}" name="variants[{{ $index }}][price]" required step="any">
                                    </td>
                                </div>
                                <div class="col-md-1">
                                    <td><label>@lang('admin.qty')</label>
                                        <i class="fa fa-question-circle" title="Seçilen özelliklere ait adet sayısı"></i>
                                    </td>
                                    <td><input type="number" class="form-control" value="{{$variant->qty}}" name="variants[{{ $index }}][qty]" required></td>
                                </div>

                                <div class="form-group col-md-1">
                                    <label>&nbsp;</label><br>
                                    <a href="javascript:void(0);" onclick="deleteProductVariantFromDB({{$variant->id}},{{$index}})"><i
                                            class="fa fa-trash text-red"></i></a>
                                </div>
                            </div>
                        </div>
                        <!--.//product detail item -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
