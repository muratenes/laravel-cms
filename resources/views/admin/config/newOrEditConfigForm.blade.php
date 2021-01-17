@extends('admin.layouts.master')
@section('title','Ayar detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.config.list') }}"> Ayarlar</a>
                    › {{ $config->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="post" action="{{ route('admin.config.save',$config->id != null ? $config->id : 0) }}" id="form" enctype="multipart/form-data">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Genel Ayarlar</h3>
                        @if($config->id)<img class="pull-right" src="{{ langIcon($config->lang) }}">@endif
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="Site başlık" value="{{ old('title', $config->title) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Domain</label>
                                <input type="text" class="form-control" name="domain" placeholder="Domain ex:http://google.com"
                                       value="{{ old('domain', $config->domain) }}" maxlength="50">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Kelimeler</label>
                                <input type="text" class="form-control" name="keywords" value="{{ old('keywords', $config->keywords) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="image">Logo</label><br>
                                <input type="file" class="form-control" name="logo">
                                @if($config->logo)
                                    <span class="help-block"><a
                                            href="{{  imageUrl('public/config',$config->logo)}}">{{ $config->logo }}</a></span>
                                @endif
                            </div>
                            <div class="form-group col-md-5">
                                <label for="image">Açıklama</label><br>
                                <textarea class="form-control" name="desc" rows="5">{{ old('desc',$config->desc) }}</textarea>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="image">Footer Logo</label><br>
                                <input type="file" class="form-control" name="footer_logo">
                                @if($config->footer_logo)
                                    <span class="help-block"><a
                                            href="{{ imageUrl('public/config',$config->footer_logo) }}">{{ $config->footer_logo }}</a></span>
                                @endif
                            </div>
                            <div class="form-group col-md-1">
                                <label for="image">İcon</label><br>
                                <input type="file" class="form-control" name="icon">
                                @if($config->icon)
                                    <span class="help-block"><a
                                            href="{{ imageUrl('public/config',$config->icon) }}">{{ $config->icon }}</a></span>
                                @endif
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ $config->active == 1 ? 'checked': '' }}>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Kargo Fiyatı</label><br>
                                <input type="number" class="minimal form-control" name="cargo_price" value="{{ old('cargo_price',$config->cargo_price) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="image">Footer Text</label><br>
                                <textarea class="form-control" name="footer_text">{{ old('footer_text',$config->footer_text) }}</textarea>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Dil</label>
                                @if($config->id)
                                    <br>
                                    <img src=" {{  langIcon($config->lang) }}" alt="">
                                    <input type="hidden" name="lang" value="{{ $config->lang }}">
                                @else
                                    <select name="lang" class="form-control" id="">
                                        @foreach($languages as $language)
                                            <option value="{{ $language[0] }}"
                                                {{ $config->lang == $language[0] ? 'selected' : '' }}
                                                {{ in_array($language[0],$addedLanguages) && $language[0] !== $config->lang ? 'disabled' : '' }}
                                            >
                                                {{ $language[1] }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <button type="submit" class="hidden">Kaydet</button>
                        </div>
                    </div>

                </div>
                <!-- /.box -->

            </div>
            <!--/.col (left) -->

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sosyal Medya</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Facebook Adresi</label>
                                <input type="text" class="form-control" name="facebook" placeholder="Facebook" value="{{ old('facebook', $config->facebook) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">İnstagram Adresi</label>
                                <input type="text" class="form-control" name="instagram" value="{{ old('instagram', $config->instagram) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Twitter Adresi</label>
                                <input type="text" class="form-control" name="twitter" value="{{ old('twitter', $config->twitter) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Youtube Adresi</label>
                                <input type="text" class="form-control" name="youtube" value="{{ old('youtube', $config->youtube) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">İletişim Bilgileri</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Telefon</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $config->phone) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" class="form-control" name="mail" value="{{ old('mail', $config->mail) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Adres</label>
                                <input type="text" class="form-control" name="adres" value="{{ old('adres', $config->adres) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" data-widget="collapse" data-toggle="tooltip">
                        <h3 class="box-title">Hakkımızda</h3>
                        <span class="help-block">Hakkımızda sayfası içerik</span>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Daralt">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body pad">
                         <textarea class="textarea" placeholder="Place some text here" id="editor1"
                                   style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                   name="about">{{ old('about',$config->about )}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <! -- firma bilgileri -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" data-widget="collapse" data-toggle="tooltip">
                        <h3 class="box-title">Firma Bilgileri</h3>
                        <span class="help-block">Eticaret işlemlerinde kullanıcılacak firma bilgileri</span>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Tam Ad Soyad</label>
                            <input type="text" class="form-control" name="full_name" maxlength="100" value="{{ old('full_name', $config->full_name) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Firma Adres</label>
                            <input type="text" class="form-control" maxlength="255" name="company_address" value="{{ old('company_address', $config->company_address) }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Firma Telefon</label>
                            <input type="text" class="form-control" maxlength="20" name="company_phone" value="{{ old('company_phone', $config->company_phone) }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Firma FAX</label>
                            <input type="text" class="form-control" maxlength="100" name="fax" value="{{ old('fax', $config->fax) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>

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
