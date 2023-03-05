{{--@extends('site.layouts.base')--}}
{{--@section('title','Sipariş Detayı')--}}

{{--@section('content')--}}
<div class="container bg-white padding-left-lg pt-5 p-md-5">
    <div class="bg-content">
        <h2>Sipariş (SP-{{ $order->id }})</h2>
        <table class="table table-bordererd table-hover">
            <tbody>
            <tr>
                <th colspan="2" class="text-center">Ürün</th>
                <th>Tutar</th>
                <th>Adet</th>
                <th>Ara Toplam</th>
                <th>Durum</th>
            </tr>
            <!-- item -->
            @foreach($order->basket->basket_items as $item)
                <tr>
                    <td><a href="{{ route('product.detail',$item->product->slug) }}">
                            <img src="{{config('constants.image_paths.product_image_folder_path').''.$item->product->image}}" class="img-responsive" height="100px"
                                 width="100px"></a></td>
                    <td><a href="{{ route('product.detail',$item->product->slug) }}">{{ $item->product->title }}</a></td>
                    <td>{{ $item->price }} ₺</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item ->price * $item->qty }} ₺</td>
                    <td>
                        {{ $item->statusLabel() }}
                    </td>
                </tr>
            @endforeach
            <!--item end -->
            <tr>
                <th colspan="5" class="text-right">Sipariş Genel Durum</th>
                <td class="text-right">{{ $order->statusLabel()}}</td>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Ara Toplam</th>
                <td class="text-right">{{ $order->order_price }} ₺</td>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Kargo</th>
                <td class="text-right">{{ $order->cargo_price }} ₺</td>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Toplam</th>
                <td class="text-right">{{ $order->order_total_price }} ₺</td>
            </tr>

            <!-- end item -->
            </tbody>
        </table>
    </div>
</div>
{{--@endsection--}}

