@if(count($bestSellers) > 0)
    <div class="widget widget-featured">
        <h3 class="widget-title">Çok Satanlar</h3>
        <div class="widget-body">
            <div class="owl-carousel widget-featured-products">
{{--                @foreach($bestSellers->chunk(3) as $chunk)--}}
{{--                    <div class="featured-col">--}}
{{--                        @foreach($chunk as $bestItem)--}}
{{--                            <div class="product-default left-details product-widget">--}}
{{--                                <figure>--}}
{{--                                    <a href="{{ route('product.detail',$bestItem->slug) }}">--}}
{{--                                        <img src="{{ config('constants.image_paths.product270x250_folder_path').''.$bestItem->image }}">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details">--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="{{ route('productDetail',$bestItem->slug) }}">{{$bestItem->title}}</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        @if($bestItem->current_discount_price)--}}
{{--                                            <span class="old-price" title="ürün fiyatı">  {{$bestItem->current_price}} ₺</span><br>--}}
{{--                                            <span class="product-price">  {{$bestItem->current_discount_price}} ₺</span>--}}
{{--                                        @else--}}
{{--                                            <span class="product-price" title="ürün fiyatı">  {{$bestItem->current_price}} ₺</span>--}}
{{--                                        @endif--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                @endforeach--}}

            </div>
        </div>
    </div>
@endif
