@extends('admin.layouts.master')
@section('title','Referans detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.reference') }}"> Referanslar</a>
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Referans Detay</h3>
                </div>
                <form role="form" method="post" action="{{ route('admin.reference.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="başlık" required maxlength="100"
                                       value="{{ old('title', $item->title) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Link</label>
                                <input type="text" class="form-control" name="link" placeholder="Yönlendirelecek url" max="255"
                                       value="{{ old('link', $item->link) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="image">Fotoğraf</label><br>
                                <input type="file" class="form-control" name="image">
                                @if($item->image)
                                    <span class="help-block">
                                        <a target="_blank" href="{{ imageUrl('public/references',$item->image)}}">
                                            {{ $item->image }}
                                        </a>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ old('active',$item->active) == 1 ? 'checked': '' }}>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Açıklama</label>
                                <textarea name="desc" class="form-control" id="desc" cols="30" rows="10" maxlength="255">{{ old('desc',$item->desc) }}</textarea>
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
