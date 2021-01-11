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
            <!-- filtreleme -->
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body" >
                    <div class="row">
                        <form action="{{ route('admin.orders') }}" method="GET" id="form">
                            <div class="col-md-12">
                                <div class="col-md-1" style="padding-top: 8px"><strong>Filtrele : </strong></div>
                                @if(config('admin.product.use_companies'))
                                    <div class="col-md-2">
                                        <select name="company" class="form-control" id="company_filter">
                                            <option value="">--Tedarikçi--</option>
                                            @foreach($companies as $com)
                                                <option value="{{ $com->id }}" {{ request('company') == $com->id ? 'selected' : '' }}>{{ $com->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-2">
                                    <select name="status_filter" class="form-control" id="status_filter">
                                        <option value="0">--Sipariş Durumu Seçiniz--</option>
                                        @foreach($filter_types as $filter)
                                            <option value="{{ $filter[0] }}" {{ $filter[0] == request('status_filter') ? 'selected': '' }}> {{ $filter[1] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-sm btn-success">Filtrele</button>
                                    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-danger">Temizle</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Siparişler</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="orderList">
                        <thead>
                            <tr>
                                <th>Sipariş Kodu</th>
                                <th>Ad/Soyad</th>
                                <th>Kullanıcı</th>
                                <th>Adres</th>
                                <th>Telefon</th>
                                <th>Ödeme Alındı?</th>
                                <th>Durum</th>
                                <th>İl</th>
                                <th>İlçe</th>
                                <th>Sepet Tutarı</th>
{{--                                <th>Kargo Tutarı</th>--}}
{{--                                <th>Kupon Tutar</th>--}}
                                <th>Toplam Tutar</th>
                                <th>Oluşturulma Tarihi</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.order.list.js"></script>
@endsection
