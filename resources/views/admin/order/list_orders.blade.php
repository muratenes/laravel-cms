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
                                    <div class="col-md-2">
                                        <select name="vendor_id" class="form-control" id="vendor_id">
                                            <option value="">--Esnaf--</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
{{--                                <div class="col-md-2">--}}
{{--                                    <select name="status" class="form-control" id="status">--}}
{{--                                        <option value="">--Sipariş Durumu Seçiniz--</option>--}}
{{--                                        @foreach($filter_types as $filter)--}}
{{--                                            <option value="{{ $filter[0] }}" {{ $filter[0] == request('status') ? 'selected': '' }}> {{ $filter[1] }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}

                                <div class="col-md-2">
                                    <button class="btn btn-sm btn-success">Filtrele</button>
                                    <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-danger">Temizle</a>
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
                                <th>Esnaf</th>
                                <th>Açıklama</th>
                                <th>Ürünler</th>
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
