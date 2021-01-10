<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body></body>
</html>


<div class="container">
    <p>Merhaba <span class="box-title">{{ $user->full_name }}</span></p>

    <p>Sipariş Durumun "{{ $orderStatusText }}" olarak güncellendi.</p>

    <h4>Siparis Kodu : SP-{{ $order->id }}</h4>
    <p>Daha fazla bilgi için bizimle iletişime geçebilirsin <br> Mail : {{ $site->mail }} Site: {{ $site->domain }}</p>
    <hr>
    <div class="row">


        <table class="table">
            <thead>
            <tr>
                <th scope="col">Ürün</th>
                <th scope="col">Ürün Adı</th>
                <th scope="col">Özellikler</th>
                <th scope="col">Adet</th>
                <th scope="col">Fiyat</th>
                <th scope="col">Toplam Fiyat</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($basket->basket_items as $item)
                    <td>
                        <div class="col-md-6 mb-md-0 p-md-4">
                            <img src="{{ imageUrl('publics/products',$item->product->image) }}" class="w-50" width="180" height="180"
                                 alt="{{$item->product->title}}">
                        </div>
                    </td>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ $item->attributes_text }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->price }} ₺</td>
                    <td>{{ $item->qty *  $item->price}} ₺</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="4" class="text-right">Ara Toplam</th>
                <td class="text-right">{{ $order->order_price }} ₺</td>
            </tr>
            @if($order->coupon_price)
                <tr>
                    <td>Kupon - {{ $order->coupon->code}}</td>
                    <td style="color: green">- ₺<span class="text-green bg-green">{{$order->coupon_price}}</span></td>
                </tr>
            @endif
            <tr>
                <th colspan="4" class="text-right">Kargo</th>
                <td class="text-right">{{ $order->cargo_price }} ₺</td>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Toplam</th>
                <td class="text-right">{{ $order->order_total_price }} ₺</td>
            </tr>
            </tbody>
        </table>
        <p><span class="help-block">Tarih : {{ date('Y-m-d H:i:s')  }}</span></p>
    </div>

</div>
