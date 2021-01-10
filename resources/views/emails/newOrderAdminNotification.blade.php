<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body></body>
</html>


<div class="container">
    <p>Hey ! <span class="box-title">{{ $site->title }}- Yeni Sipariş Geldi</span></p>

    <p>SP-{{$order->id}} - {{ date('Y-m-d H:i:s')  }}</p>

    <h4>Siparis Kodu : SP-{{ $order->id }}</h4>
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
                @foreach($basketItems as $item)
                    <td>
                        <div class="col-md-6 mb-md-0 p-md-4">
                            <img src="{{ $site->domain.''.config('constants.image_paths.product_image_folder_path').$item->product->image }}" class="w-50" width="180" height="180"
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
            @if(!is_null($prices['basketCoupon']))
                <tr>
                    <td>Kupon - {{$prices['basketCoupon']->code}}</td>
                    <td style="color: green">- ₺<span class="text-green bg-green">{{$prices['basketCoupon']->discount_price}}</span></td>
                </tr>
            @endif
            <tr>
                <th colspan="4" class="text-right">Kargo</th>
                <td class="text-right">{{ $order->cargo_price }} ₺</td>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Toplam</th>
                <td class="text-right">{{ $prices['cartTotalPrice'] }} ₺</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
