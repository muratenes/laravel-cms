@extends('admin.layouts.master')
@section('title','İçerik detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.content') }}"> İçerik Yönetim</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="post" action="{{ route('admin.content.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">İçerik Detay</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="başlık" required
                                       value="{{ old('title', $item->title) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="image">Fotoğraf</label><br>
                                <input type="file" class="form-control" name="image">
                                @if($item->image)
                                    <span class="help-block"><a target="_blank"
                                                                href="/{{ config('constants.image_paths.reference_image_folder_path') }}{{ $item->image }}">{{ $item->image }}</a></span>
                                @endif
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ old('active',$item->active) == 1 ? 'checked': '' }}>
                            </div>
                            @if(config('admin.MULTI_LANG'))
                                <div class="form-group col-md-2">
                                    <label for="exampleInputEmail1">Dil</label>
                                    <select name="lang" id="languageSelect" class="form-control">
                                        @foreach($languages as $lang)
                                            <option value="{{ $lang[0] }}" {{ old('lang',$item->lang) == $lang[0] ? 'selected' : '' }}> {{ $lang[1] }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            @endif
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Üst İçerik</label>
                                <select name="parent" id="languageSelect" class="form-control">
                                    <option value="">Üst Başlık Seçiniz</option>
                                    @foreach($contents as $content)
                                        <option value="{{ $content->id }}" {{ old('parent',$content->id) == $item->parent ? 'selected' : '' }}> {{ $content->title }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">Hangi başlığın altında(alt kategori olarak) yayınlaması isteniyorsa üst olarak seçilmedilir</span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Kısa Açıklama</label>
                                <input type="text" name="spot" class="form-control" maxlength="255" value="{{ old('spot',$item->spot) }}">
                            </div>

                        </div>

                    </div>
                    <!-- /.box-body -->


                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" data-widget="collapse" data-toggle="tooltip">
                        <h3 class="box-title">İçerik Açıklama
                            <small>İçerik hakkında uzun açıklama</small>
                        </h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Daralt">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body pad">
                                     <textarea class="textarea" placeholder="" id="editor1"
                                               style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                               name="desc">{{ old('desc',$item->desc) }}</textarea>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script !src="">
        $(function () {
            var options = {
                language: 'tr',
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };
            CKEDITOR.replace('editor1', options);
        })
    </script>
@endsection
