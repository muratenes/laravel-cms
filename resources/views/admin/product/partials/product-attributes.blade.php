<!-- ÜRÜN DETAY -->
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('admin.product.detail')
                <small>@lang('admin.product.attributes_info')</small>
            </h3>
            <div class="pull-right box-tools">
                <button type="button" class="btn btn-default btn-sm" title="@lang('admin.product.add_new_attribute')" onclick="addNewProductDetail()">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="box-body pad" id="productDetailAttributeContainer">
            @foreach($productDetails as $index => $detail)
                <!-- product detail item -->
                    <div class="form-row row productDetailAttribute" data-index="{{ $index }}">
                        <div class="form-group col-md-5">
                            <label for="exampleInputEmail1">@lang('admin.product.attribute_title')</label>
                            <select name="attribute{{$index}}" id="attributes{{$index}}" class="form-control"
                                    onchange="getAndFillSubAttributeByAttributeID(this.value,'#subAttributes{{$index}}')">
                                @foreach($data['attributes'] as $attr)
                                    <option
                                        value="{{ $attr->id }}" {{ $attr->id == $detail['parent_attribute']  ? 'selected' : '' }}>{{ $attr->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="exampleInputEmail1">@lang('admin.product.sub_attributes')</label>
                            <select name="subAttributes{{$index}}[]" id="subAttributes{{$index}}" class="form-control" multiple required>
                                @foreach($data['subAttributes'] as $subAttribute)
                                    @if($subAttribute->parent_attribute == $detail['parent_attribute'])
                                        <option
                                            value="{{ $subAttribute->id }}" {{ collect($productSelectedSubAttributesIdsPerAttribute[$index])->contains($subAttribute->id) ? 'selected' : '' }}>{{ $subAttribute->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">&nbsp;</label><br>
                            <a href="javascript:void(0);" onclick="deleteProductDetailFromDB({{$detail['id']}},{{$index}})"><i
                                    class="fa fa-trash text-red"></i></a>
                        </div>
                    </div>
                    <!--.//product detail item -->
                @endforeach

            </div>
        </div>
    </div>
</div>
