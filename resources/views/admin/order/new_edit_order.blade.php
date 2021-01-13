@extends('admin.layouts.master')
@section('title','sipariş detay')

@section('content')
    @include('admin.order.partials.detail-forms')
    @include('admin.order.partials.basket-item-refund')
    <div class="box box-default">
        <div class="box-header">
            <div class="col-md-10">
                <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                › <a href="{{ route('admin.orders') }}"> Siparişler</a>
                › {{ $order->full_name }}
            </div>
            <div class="box-tools">
                <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirm('Tamamını iptal etmek istiyor musunuz ? bu işlem geri alınamaz') ? document.getElementById('cancelOrderForm').submit() : ''"
                   title="tamamını iptal et,sadece aynı gün alınan siparişler için geçerlidir"><i
                        class="fa fa-close"></i> İptal &nbsp;</a>
                <a class="btn btn-info btn-sm" href="{{ route('admin.order.invoice',$order->id) }}"><i class="fa fa-file"></i> &nbsp;Yazdır</a>
                <a target="_blank" href="{{ config('admin.iyzico.order_url') }}{{ $order->iyzico ? $order->iyzico->paymentId : '' }}" class="btn btn-default btn-sm" title="İyzico üzerinde göster">
                    <i class="fa fa-eye"></i> İyzico
                </a>
                <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
            </div>
        </div>

    </div>
    <form role="form" method="post" action="{{ route('admin.order.save',$order->id != null ? $order->id : 0) }}" id="form">
        {{ csrf_field() }}
        <input type="hidden" name="tst" value="12">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sipariş Bilgileri</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Sipariş Kodu</th>
                                <td>SP-{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Sipariş Durumu</th>
                                <td>
                                    <select name="status" class="form-control">
                                        <option value="">---Durum Seçiniz --</option>
                                        @foreach($filter_types as $type)
                                            <option value="{{ $type[0] }}" {{ $type[0] == $order->status ? 'selected' : '' }}
                                                {{ !$type[2]  ? 'disabled' : '' }}>
                                                {{ $type[1]  }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th>Sipariş Tarihi</th>
                                <td>{{$order->created_at }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" style="text-align: center">Müşteri Bilgileri</th>
                            </tr>
                            <tr>
                                <th>Ad & Soyad</th>
                                <td>{{$order->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Telefon</th>
                                <td>{{$order->phone }}</td>
                            </tr>
                            <tr>
                                <th>Ip Address</th>
                                <td>{{$order->ip_adres }}</td>
                            </tr>
                            </thead>
                        </table>

                    </div>
                    <!-- /.box-body -->

                </div>
                @include('admin.order.partials.address-detail')
            </div>

            <!--/.col (left) -->

            <div class="col-md-6">
                <!-- sepet bilgileri -->
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Sepet Bilgileri</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Toplam Ürün</th>
                                    <td>{{ count($order->snapshot['basket']['basket_items']) }}</td>
                                </tr>
                                <tr>
                                    <th>Alt Toplam</th>
                                    <td>{{ $order->order_price }} {{ $currencySymbol }}</td>
                                </tr>
                                <tr>
                                    <th>Kargo Toplam</th>
                                    <td>
                                        <span class="text-success">+{{ $order->cargo_price }} {{ $currencySymbol }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kupon</th>
                                    <td>
                                    <span class="text-danger">
                                        @if ($order->coupon_price)
                                            @if ($basket->coupon)
                                                {{ $basket->coupon_price }} {{ $currencySymbol }} ({{ $basket->coupon->code }})
                                            @else
                                                {{ $order->coupon_price }} {{ $currencySymbol }}
                                            @endif

                                        @else
                                            Kupon kullanılmadı
                                        @endif

                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Genel Toplam</th>
                                    <td>{{ $order->order_total_price }} {{ $currencySymbol }}</td>
                                </tr>

                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- kullanıcı bilgileri -->
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Kargo Bilgileri</h3>
                            <div class="box-tools">
                                @if ($order->cargo_id and $order->cargo_code and $order->cargo)
                                    <a target="_blank" href="{{ $order->cargo->cargo_tracking_url }}{{ $order->cargo_code }}"><i class="fa fa-eye" title="Kargo takip sayfası"></i></a>
                                @endif
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Kargo</label>
                                    <select name="cargo_id" class="form-control" id="">
                                        <option value="">Kargo Seçiniz</option>
                                        @foreach($cargos as $cargo)
                                            <option value="{{ $cargo->id }}" {{ $order->cargo_id == $cargo->id ? 'selected' : '' }}>{{ $cargo->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="exampleInputEmail1">Kargo Takip Kodu</label>
                                    <input type="text" class="form-control" name="cargo_code" placeholder="Kargo takip için kodu giriniz" value="{{ $order->cargo_code }}">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box box-primary collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Kullanıcı Bilgileri</h3>
                            <div class="box-tools">
                                <a href="{{ route('admin.user.edit',$order->basket->user->id )}}"><i class="fa fa-edit"></i></a>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Ad/Soyad</label>
                                    <br>{{ $order->full_name }}
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Email</label>
                                    <br>{{ $order->basket->user->email }}
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Kayıt Tarihi</label>
                                    <br>{{ $order->created_at }}
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Telefon</label>
                                    <br>{{ $order->phone }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <!-- ürün bilgileri -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Siparişteki Ürünler - SP-{{ $order->id }}</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.orders.snapshot',$order->id )}}" target="_blank"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Ürün</th>
                                <th>Ürün Resmi</th>
                                <th>Özellikler</th>
                                <th>Fiyat</th>
                                <th>Adet</th>
                                <th>Kargo</th>
                                <th>Toplam</th>
                                <th>Ürün Durum</th>
                                <th>İade</th>
                            </tr>

                            @foreach($order->basket->basket_items as $cart_item)
                                <tr>
                                    <td>{{ $cart_item->id }}</td>
                                    <td><a target="_blank" href="{{ route('admin.product.edit',$cart_item->product->id) }}">{{ $cart_item->product->title }}</a></td>
                                    <td><img src="{{ imageUrl('public/products',$cart_item->product->image) }}" width="50" height="50"></td>
                                    <td>{{ $cart_item->attributes_text  }}</td>
                                    <td>{{ $cart_item->price }} {{ $currencySymbol }}</td>
                                    <td>{{ $cart_item->qty  }}</td>
                                    <td>
                                        <span class="text-success">+{{ $cart_item->cargo_price }} {{ $currencySymbol }}</span>
                                    </td>
                                    <td>{{ $cart_item->total. ' '.$currencySymbol  }}</td>
                                    <td>
                                        <select name="orderItem{{ $cart_item['id'] }}" class="form-control">
                                            <option value="">---Ürün Durum Seçiniz --</option>
                                            @foreach($item_filter_types as $itemType)
                                                <option value="{{ $itemType[0] }}" {{ $itemType[0] == $cart_item->status ? 'selected' : '' }} {{ !$itemType[2] ?'disabled' :'' }}>
                                                    {{ $itemType[1]  }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                         <span data-toggle="modal" data-target="#orderItemRefundModal" onclick="refundBasketItem({{ json_encode($cart_item) }},{{ $cart_item['id'] }})">
                                            <i class="fa fa-history text-red ml-4" title="İade et"></i>
                                         </span>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class="col-md-6">
                <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">İyzico Bilgileri</h3>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Sepet / ConversationId</label>
                                <br>{{ $order->iyzico->transaction_id }}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Price</label>
                                <br>{{ $order->iyzico->price }} ₺
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Paid Price</label>
                                <br>{{ $order->iyzico->paidPrice }} ₺
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Taksit sayısı</label>
                                <br>{{ $order->iyzico->installment }}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Payment ID</label>
                                <br>{{ $order->iyzico->paymentId }}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Durum</label>
                                <br>{{ $order->iyzico->status }}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">3D Ödeme Alındı ?</label>
                                <br> <i class="fa fa-{{ $order->is_payment == 1 ? 'check text-green':'times text-red text-bold' }}">{{ $order->is_payment == 1 ? 'Ödeme Alındı':' DİKKAT ÖDEME ALINMADI' }}</i>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">İyzico Json</label>
                                <textarea disabled class="form-control" name="" id="" cols="30" rows="20">
                                    {{ $order->iyzico->iyzicoJson ? json_encode($order->iyzico->iyzicoJson, JSON_PRETTY_PRINT)  : '' }}
                                </textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        @include('admin.order.partials.iyzico-logs')
    </div>

@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.order.js"></script>
@endsection
