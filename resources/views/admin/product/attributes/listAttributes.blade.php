@extends('admin.layouts.master')
@section('title','Ürün Özellik Listesi')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Ürün Özellikler
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.product.attribute.new') }}"><i class="fa fa-plus"></i>&nbsp;Ekle</a>&nbsp;
                    <a href="{{ route('admin.product.attribute.list') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Ürün Özellikler</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.product.attribute.list') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Log ara.." value="{{ request('q') }}">

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
                            <th>Id</th>
                            <th>Başlık</th>
                            <th>Sil</th>
                        </tr>
                        @foreach($list as $l)
                            <tr>
                                <td>{{ $l ->id }} </td>
                                <td><a href="{{route('admin.product.attribute.edit',$l->id)}}">{{ $l->title }}</a></td>
                                <td><a href="{{ route('admin.product.attribute.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <div class="text-right"> {{ $list->links() }}</div>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
