@extends('site.layouts.base')
@section('title','Siparişler')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Anasayfa</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-lg-last dashboard-content">
                <div class="container">
                    @include('site.layouts.partials.messages')
                    <div class="bg-content">
                        <h2>Siparişler</h2>
                        @if(count($orders) == 0)
                            <p>Henüz siparişiniz yok</p>
                        @else
                            <table class="table table-bordererd table-hover">
                                <tr>
                                    <th>Sipariş Kodu</th>
                                    <th>Tutar</th>
                                    <th>Toplam Ürün</th>
                                    <th>Durum</th>
                                    <th>Tarih</th>
                                    <th></th>
                                </tr>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>SP-{{$order->id}}</td>
                                        <td>{{ $order->order_total_price  }} {{ getCurrencySymbolById($order->currency_id) }}</td>
                                        <td> {{ $order ->basket ->basket_item_count() }}</td>
                                        <td>{{ $order->statusLabel()  }}</td>
                                        <td>{{ $order->created_at  }}</td>
                                        <td>
                                            <div class="product-action">
                                                <a href="{{ route('user.orders.detail',$order->id) }}" class="btn-quickview" title="Sipariş Detay"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div><!-- End .col-lg-9 -->
            <aside class="sidebar col-lg-3">
                @include('site.user.partials.myAccountLeftSidebar')
            </aside>
        </div><!-- End .row -->
    </div>
@endsection

