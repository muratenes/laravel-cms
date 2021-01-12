@extends('admin.layouts.master')
@section('title','Ürün Yorum Listesi')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Ürün Yorumlar
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.product.comments.list') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Ürün Yorumlar</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.product.comments.list') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Yorum ara.." value="{{ request('q') }}">

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
                            <th>Kullanıcı</th>
                            <th>Ürün</th>
                            <th>Mesaj</th>
                            <th>Ekleme Tarih</th>
                            <th>Aktif</th>
                            <th>Okundu</th>
                            <th colspan="2">#</th>
                        </tr>
                        @foreach($list as $l)
                            <tr>
                                <td><a href="{{route('admin.product.comments.edit',$l->user_id)}}">{{  $l ->id }}</a></td>
                                <td><a href="{{route('admin.user.edit',$l->user_id)}}">{{ $l->user->full_name }}<i class="fa fa-external-link"></i></a></td>
                                <td><a href="{{route('admin.product.edit',$l->product_id)}}">{{ $l->product->title }} <i class="fa fa-external-link"></i></a></td>
                                <td>{{ substr($l->message,0,50) }}</td>
                                <td>{{ $l->created_at }}</td>
                                <td><i class="fa fa-{{ $l-> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                <td><i class="fa fa-{{ $l-> is_read == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                <td><a href="{{ route('admin.product.comments.edit',$l->id) }}"> <i class="fa fa-edit"></i> </a></td>
                                <td><a href="{{ route('admin.product.comments.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                            class="fa fa-trash-o"></i></a>
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
