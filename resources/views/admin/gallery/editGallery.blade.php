@extends('admin.layouts.master')
@section('title','Galeri detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    @if(config('admin.use_album_gallery'))
                        <a href="{{ route('admin.gallery') }}"> <i class="fa fa-"></i> Galeri</a>
                    @endif
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
            <form role="form" method="post" action="{{ route('admin.gallery.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Galeri</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="başlık" required
                                       value="{{ old('title', $item->title) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Slug</label>
                                <input type="text" class="form-control" disabled
                                       value="{{ old('slug', $item->slug) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="image">Fotoğraf</label><br>
                                <input type="file" class="form-control" name="image">
                                @if($item->image)
                                    <span class="help-block"><a target="_blank"
                                                                href="/{{ config('constants.image_paths.gallery_main_image_folder_path') }}{{ $item->image }}">{{ $item->image }}</a></span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ old('active',$item->active) == 1 ? 'checked': '' }}>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Ürün Galerisi</h3>
                                <div class="box-tools">
                                    <label for="">Dosya Ekle</label>
                                    <input type="file" name="imageGallery[]" multiple>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    @foreach($images as $image)
                                        <div class="col-md-2" id="productImageCartItem{{$image->id}}">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a href="{{ route('admin.gallery.image.delete',$image->id) }}" class="btn btn-danger btn-xs pull-right">X</a>
                                                    <a target="_blank" href="/{{ config('constants.image_paths.gallery_images_folder_path').$image->image }}">
                                                        <img src="/{{ config('constants.image_paths.gallery_images_folder_path').$image->image }}" height="170" width="170"
                                                             class="card-img-top" style="width: 100%"
                                                             alt="...">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.box -->

        </div>
    </div>
@endsection
