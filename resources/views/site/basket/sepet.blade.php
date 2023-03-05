@extends('site.layouts.base')
@section('title','Sepetim')
@section('header')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Sepet</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        @include('site.layouts.partials.messages')
        <div class="row">
            <div class="col-lg-9">
                <div class="cart-table-container">
                    <table class="table table-cart">
                        <thead>
                        <tr>
                            <th class="product-col">Ürün</th>
                            <th class="">Özellikler</th>
                            <th class="price-col">Fiyat</th>
                            <th class="">Kargo Fiyat</th>
                            <th class="qty-col">Adet</th>
                            <th>Toplam</th>
                        </tr>
                        </thead>
                        <tbody id="sepetItemsContainer">
                        @if(cartItemCount() > 0)
                            @foreach(cartItems() as $cartItem)
                                <tr class="product-row basketCartItem" data-value="{{$cartItem->id}}">
                                    <input type="hidden" value="{{$cartItem->id}}" data-type="cartItemRow">
                                    <td class="product-col">
                                        <figure class="product-image-container">
                                            <a href="{{ route('product.detail',$cartItem->attributes['product']['slug']) }}" class="product-image">
                                                <img class="cartItem" src="#"
                                                     alt="{{$cartItem->title}}" width="180" height="160">
                                            </a>
                                        </figure>
                                        <h2 class="product-title">
                                            <a href="{{ route('product.detail',$cartItem->attributes['product']['slug']) }}">{{$cartItem->name}}</a>
                                        </h2>
                                    </td>
                                    <td>{{ $cartItem->attributes['attributes_text_lang'] }}</td>
                                    <td>{{ $cartItem->price }} {{ currentCurrencySymbol() }}</td>
                                    <td>{{ $cartItem->attributes['cargo_price'] }} {{ currentCurrencySymbol() }}</td>
                                    <td>
                                        <input class="vertical-quantity form-control" type="text" id="{{$cartItem->id}}" value="{{$cartItem->quantity}}">
                                    </td>
                                    <td><span class="itemTotalPrice">{{ getCartItemTotalByItem($cartItem)  }}</span> {{ currentCurrencySymbol() }}</td>
                                </tr>
                                <tr class="product-action-row">
                                    <td colspan="5" class="clearfix">
                                        <div class="float-left">
                                            <a href="javascript:void(0);" onclick="return addToFavorites({{$cartItem->id}})" class="btn-move">Favorilere Ekle</a>
                                        </div><!-- End .float-left -->

                                        <div class="float-right">
                                            <form action="{{ route('basket.remove',['rowId' => $cartItem->id]) }}" id="deleteForm{{$cartItem->id}}" method="post" class="mb-0">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <a href="javascript:void(0);" onclick="document.getElementById('deleteForm{{$cartItem->id}}').submit()" title="Sepetten Kaldır"
                                                   class="btn-remove"><span
                                                            class="sr-only">Kaldır</span></a>
                                            </form>

                                        </div><!-- End .float-right -->
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center"><h4>Henüz sepette ürün yok</h4></td>
                            </tr>
                        @endif

                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="5" class="clearfix">
                                <div class="float-left">
                                    <a href="{{route('homeView')}}" class="btn btn-outline-secondary">Alışverişe Devam Et</a>
                                </div><!-- End .float-left -->

                                <div class="float-right">
                                    <form action="{{ route('basket.removeAllItems') }}" id="formRemoveAllItems" method="post" class="mb-0">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    @if(cartItemCount() > 0)
                                        <a href="javascript:void(0);" onclick="document.getElementById('formRemoveAllItems').submit()"
                                           class="btn btn-outline-secondary btn-clear-cart">Sepeti Temizle</a>
                                        <a href="javascript:void(0)" onclick="return updateBasket()" class="btn btn-outline-secondary btn-update-cart">Sepeti Güncelle</a>
                                    @endif

                                </div><!-- End .float-right -->
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div><!-- End .cart-table-container -->


            </div><!-- End .col-lg-8 -->

            <div class="col-lg-3">
                @if(!session()->get('coupon'))
                    <div class="cart-discount">
                        <h4>Kupon Kodu Uygula</h4>
                        <form action="{{ route('coupon.apply') }}" method="post">
                            @csrf
                            <div class="input-group">,
                                <input type="text" class="form-control form-control-sm" value="{{ old('code','FRH245') }}" placeholder="Kupon Kodunu Giriniz" required name="code">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">Uygula</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
                @include('site.basket.partials.summaryCard')
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
    <div class="mb-6"></div>
@endsection

@section('footer')
    <script src="/js/basketPage.js"></script>
@endsection
