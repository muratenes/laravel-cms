<div class="container">
    <h2 class="carousel-title">{{ $featuredProductTitle }}</h2>

    <div class="product-intro owl-carousel owl-theme" data-toggle="owl" data-owl-options="{
                            'margin': 20,
                            'items': {{count($featuredProducts)}},
                            'autoplayTimeout': 5000,
                            'responsive': {
                            '400': {
                                    'items': 2
                                },
                                '559': {
                                    'items': 3
                                },
                                '975': {
                                    'items': 4
                                }
                            }
                        }">
        @foreach($featuredProducts as $bs)
            <div class="product-default">
                <figure>
                    <a href="{{route('product.detail',$bs->slug)}}">
                        <img src="{{config('constants.image_paths.product270x250_folder_path').''.$bs->image}}" style="height: 240px;width: 380px">
                    </a>
                </figure>
                <div class="product-details">
                    <h2 class="product-title">
                        <a href="{{route('product.detail',$bs->slug)}}" title="{{ $bs->title }}">{{substr($bs->title,0,25)}}</a>
                    </h2>
                    <div class="price-box">
                        @if($bs->discount_price)
                            <span class="old-price" title="ürün fiyatı">  {{$bs->price}} ₺</span>
                            <span class="product-price">  {{$bs->discount_price}} ₺</span>
                        @else
                            <span class="product-price" title="ürün fiyatı">  {{$bs->price}} ₺</span>
                        @endif
                    </div><!-- End .price-box -->
                    <div class="product-action">
                        <a href="javascript:void(0);" class="btn-icon-wish"><i class="icon-heart" onclick="return addToFavorites({{$bs->id}})"></i></a>
                        <a class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal" href="javascript:void(0)"
                           onclick="addItemToBasket({{$bs->id}},{{count($bs->detail) > 0 ? 1 : 0 }});"><i
                                class="icon-bag"></i>Sepete Ekle</a>
                        <a href="{{route('product.quickView',$bs->slug)}}" class="btn-quickview" title="Önizleme" id="productQuickView{{$bs->id}}"><i
                                class="fas fa-external-link-alt"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
