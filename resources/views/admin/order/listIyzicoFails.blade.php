@extends('admin.layouts.master')
@section('title','İyzico Hatalı Siparişler')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › İyzico Hatalı Siparişler
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
                        <form action="{{ route('admin.orders.iyzico_logs') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Siparişlerde ara.." value="{{ request('q') }}">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
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
                            <th>Kullanici Id</th>
                            <th>Kullanici Adı</th>
                            <th>Sepet Id</th>
                            <th>Json</th>
                            <th>İşlem Tarihi</th>
                        </tr>
                        @foreach($list as $l)
                            <tr>
                                <td><a href="{{ route('admin.user.edit',$l->user_id) }}">{{ $l->user_id }}</a></td>
                                <td>{{ $l ->full_name }}</td>
                                <td>{{ $l ->basket_id }}</td>
                                <td><a target="_blank" href="{{ route('admin.orders.iyzico_logs_detail',$l->id) }}"> <i class="fa fa-eye"></i></a> {{ substr($l ->json_response,0,150) }}</td>
                                <td>{{ $l ->created_at }} </td>
                                </td>
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
