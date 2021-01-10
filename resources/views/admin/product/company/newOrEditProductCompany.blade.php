@extends('admin.layouts.master')
@section('title','Firma detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.product.company.list') }}"> Firmalar</a>
                    › {{ $item->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">firma Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.product.company.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="başlık" required maxlength="50"
                                       value="{{ old('title', $item->title) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Mail</label>
                                <input type="text" class="form-control" name="email" placeholder="mail" maxlength="50"
                                       value="{{ old('email', $item->email) }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control" placeholder="link" disabled value="{{ $item->slug }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Adres</label>
                                <input type="text" class="form-control" name="address" placeholder="adres" required maxlength="50"
                                       value="{{ old('address', $item->address) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Telefon</label>
                                <input type="text" class="form-control" name="phone" placeholder="telefon" maxlength="50"
                                       value="{{ old('phone', $item->phone) }}">
                            </div>


                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ old('active',$item->active) == 1 ? 'checked': '' }}>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Kayıt Tarihi</label>
                                <p>{{$item->created_at}}</p>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Son Güncelleme</label>
                                <p>{{$item->updated_at}}</p>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (left) -->

    </div>
@endsection
