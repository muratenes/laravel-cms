@extends('admin.layouts.master')
@section('title','Sipariş Listesi')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Siparişler
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.orders') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Siparişler</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.orders') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Siparişlerde ara.." value="{{ request('q') }}">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-3  pull-right">
                                    <select name="status_filter" class="form-control" id="status_filter" onchange="document.getElementById('form').submit()">
                                        <option value="0">--Sipariş Durumu Seçiniz--</option>
                                        @foreach($filter_types as $filter)
                                            <option value="{{ $filter[0] }}" {{ $filter[0] == request('status_filter') ? 'selected': '' }}> {{ $filter[1] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>Sipariş Kodu</th>
                            <th>Ad/Soyad</th>
                            <th>Kullanıcı</th>
                            <th>Adres</th>
                            <th>Telefon</th>
                            <th>Ödeme Alındı?</th>
                            <th>Durum</th>
                            <th>Sepet Tutarı</th>
                            <th>Kargo Tutarı</th>
                            <th>Kupon Tutar</th>
                            <th>Toplam Tutar</th>
                            <th>Oluşturulma Tarihi</th>
                        </tr>
                        @foreach($list as $l)
                            <tr>
                                <td><a href="{{ route('admin.order.edit',$l->id) }}">SP-{{ $l->id }}</a></td>
                                <td><a href="{{ route('admin.order.edit',$l->id) }}"> {{ $l->full_name }}</a></td>
                                <td><a href="{{ route('admin.user.edit',$l->basket->user->id) }}">{{ $l->basket->user->name }} &nbsp; <i class="fa fa-edit"></i></a></td>
                                <td>{{ $l ->adres }}</td>
                                <td>{{ $l ->phone }}</td>
                                <td><i class="fa fa-{{ $l->is_payment == 1 ? 'check text-green':'times text-red text-bold' }}"></i> </td>
                                <td>{{ $l->statusLabel() }}</td>
                                <td>{{ $l->order_price }} {{ getCurrencySymbolById($l->currency_id) }}</td>
                                <td class="text text-success">+{{ $l->cargo_price }} {{ getCurrencySymbolById($l->currency_id) }}</td>
                                <td class="text text-danger">-{{ $l->coupon ? $l->coupon->price : 0 }} {{ getCurrencySymbolById($l->currency_id) }}</td>
                                <td class="text-bold">{{ $l->order_total_price }}  {{ getCurrencySymbolById($l->currency_id) }}</td>
                                <td>{{ $l ->created_at }} </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q'),'status_filter'=> request('status_filter')])->links() }}</div>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
