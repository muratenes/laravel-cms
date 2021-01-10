@extends('site.layouts.base')
@section('title','Favorilerim')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Favorilerim</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        @include('site.layouts.partials.messages')
        <div class="row">
            <div class="col-lg-3">
                @include('site.kullanici.partials.myAccountLeftSidebar')
            </div>
            <div class="col-lg-9 order-lg-last dashboard-content">
                <h2>Favorilerim</h2>
                @if(count($favorites) > 0)
                    <div class="row">
                        @foreach($favorites as $l)
                            <div class="col-6 col-md-3 col-xl-3">
                                <div class="product-default">
                                    <figure>
                                        <a href="{{ route('product.detail',$l->product->slug) }}">
                                            <img src="{{ imageUrl('public/products',$l->product->image) }}">
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <h2 class="product-title">
                                            <a href="{{ route('product.detail',$l->product->slug) }}">{{substr($l->product->title,0,25)}}</a>
                                        </h2>
                                        <div class="price-box">
                                            <span class="product-price">₺{{$l->product->current_price}}</span>
                                        </div><!-- End .price-box -->
                                        <div class="product-action">
                                            <a href="#" class="btn-icon-wish active"><i class="fas fa-heart"></i></a>
                                            <a class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal"
                                               onclick="return addItemToBasket({{$l->product->id}},{{!is_null($l->product->detail) ? 1 : 0}})"><i
                                                    class="icon-bag"></i>Sepete Ekle</a>
                                            <a href="/urun/quickView/{{$l->product->slug}}" class="btn-quickview" id="productQuickView{{$l->product->id}}" title="Önizleme"><i class="fas fa-external-link-alt"></i></a>
                                        </div>
                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Henüz favorilere bir ürün eklemediniz</p>
                @endif
            </div>
        </div>
    </div>
@endsection
