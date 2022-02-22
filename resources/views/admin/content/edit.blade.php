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
                            <x-input name="title" label="Başlık" width="12" :value="$item->title" required maxlength="100" horizontal/>
                            <x-input name="spot" label="Kısa Açıklama" width="12" :value="$item->spot" maxlength="255" horizontal/>
                            <x-select name="parent_id" label="Üst İçerik" width="12" :value="$item->parent_id" :options="$contents->toArray()" horizontal/>
                            <x-input name="image" type="file" label="Görsel" width="12" :value="$item->image"  path="contents" horizontal />
                            @if(config('admin.multi_lang'))
                                <x-select name="lang" label="Dil" width="12" :value="$item->lang" :options="$languages" key="0" option-value="1" nohint horizontal/>
                            @endif
                            <div class="form-group col-md-12">
                                <x-input name="active" type="checkbox" label="Aktif Mi ?" width="2" :value="$item->active" class="minimal" />
                                <x-input name="show_menu" type="checkbox" label="Menüde Göster ?" width="2" :value="$item->show_menu" class="minimal" />
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
        @include('laravel-meta-tags::meta-tags')
        @if(config('admin.modules.content.images'))
            <x-images title="Görseller" folder-path="public/contents/gallery/"  :images="$item->images"/>
        @endif
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
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
                allowedContent : true
            };
            CKEDITOR.replace('editor1', options);
        })
    </script>
@endsection
