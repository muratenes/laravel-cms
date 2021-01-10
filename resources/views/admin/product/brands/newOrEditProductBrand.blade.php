@extends('admin.layouts.master')
@section('title','Marka detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.product.brands.list') }}"> Markalar</a>
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
                    <h3 class="box-title">Marka Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.product.brands.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="başlık" required maxlength="50"
                                       value="{{ old('title', $item->title) }}">
                            </div>

                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control" placeholder="link" disabled value="{{ $item->slug }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ old('active',$item->active) == 1 ? 'checked': '' }}>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="image">Fotoğraf</label><br>
                                <input type="file" class="form-control" name="image">
                                @if($item->image)
                                    <span class="help-block"><a
                                            href="{{ config('constants.image_paths.brand_image_folder_path') }}{{ $item->image }}">{{ $item->image }}</a></span>
                                @endif
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
