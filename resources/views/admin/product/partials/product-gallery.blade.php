<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">@lang('admin.product.gallery')</h3>
                <div class="box-tools">
                    <label for="">@lang('admin.product.gallery')</label>
                    <input type="file" name="imageGallery[]" multiple>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    @foreach($product->images as $image)
                        <div class="col-md-2" id="productImageCartItem{{$image->id}}">
                            <div class="card">
                                <div class="card-body">
                                    <a href="javascript:void(0);" onclick="deleteProductImage({{ $image->id }})" class="btn btn-danger btn-xs pull-right">X</a>
                                    <a target="_blank" href="{{ imageUrl('public/product-gallery',$image->image) }}">
                                        <img src="{{ imageUrl('public/product-gallery',$image->image) }}" height="170" width="170"
                                             class="card-img-top" style="width: 100%"
                                             alt="...">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
