@extends('admin.layouts.master')
@section('title','Ürün Firmaları')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    › Firmalar
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.product.company.new') }}"> <i class="fa fa-plus"></i> @lang('admin.add')</a>&nbsp;
                    <a href="{{ route('admin.product.company.list') }}"><i class="fa fa-refresh"></i>&nbsp;@lang('admin.refresh')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.modules.product_company.plural')</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.product.company.list') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Firmalarda ara.." value="{{ request('q') }}">

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
                                <th>ID</th>
                                <th>Firma Adı</th>
                                <th>Slug</th>
                                <th>Telefon</th>
                                <th>Email</th>
                                <th>Adres</th>
                                <th>Durum</th>
                                <th>#</th>
                            </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.product.company.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l -> slug}}</td>
                                    <td>{{ $l -> phone}}</td>
                                    <td>{{ $l -> email}}</td>
                                    <td>{{ $l -> address}}</td>
                                    <td><i class="fa fa-{{ $l -> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td><a href="{{ route('admin.product.company.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><h5>Firma Bulunamadı</h5></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q')])->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
