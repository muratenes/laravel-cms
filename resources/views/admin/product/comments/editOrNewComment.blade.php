@extends('admin.layouts.master')
@section('title','Yorum Detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.product.comments.list') }}"> Ürün Yorumları</a>
                    › {{ $item->user->full_name }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="post" action="{{ route('admin.product.comments.save',$item->id != null ? $item->id : 0) }}" id="form">
            {{ csrf_field() }}
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Yorum Detay</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Kullanıcı</label>
                                <p><a href="{{ route('admin.user.edit', $item->user_id)}}">{{ $item->user->full_name }}</a></p>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Ürün</label>
                                <p><a href="{{ route('admin.product.edit', $item->product_id)}}">{{ $item->product->title }}</a></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Mesaj</label>
                                <p>{{ $item->message }}</p>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Tarih</label>
                                <p>{{ $item->created_at }}</p>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ $item->active == 1 ? 'checked': '' }}>
                            </div>
                        </div>



                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
                <!-- /.box -->

            </div>
        </form>

    </div>
@endsection
