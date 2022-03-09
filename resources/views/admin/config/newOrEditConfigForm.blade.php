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
                            <div class="col-md-6">
                                 <x-input type="text" name="title" :value="$config->title" width="12" label="Başlık" horizontal required/>
                                 <x-input type="text" name="domain" :value="$config->domain" width="12" label="Domain" placeholder="Örnek:http://google.com" horizontal/>
                                 <x-input type="text" name="keywords" :value="$config->keywords" width="12" label="Kelimeler" placeholder="Aralarında virgül bırakarak yazınız" horizontal/>
                                <x-input name="logo" type="file" label="Logo" width="12" :value="$config->logo" path="config" horizontal/>
                                <x-input name="footer_logo" type="file" label="Footer Logo" width="12" :value="$config->footer_logo" path="config" horizontal/>
                                <x-input name="icon" type="file" label="Icon" width="12" :value="$config->icon" path="config" horizontal/>
                                <x-input type="number" name="cargo_price" step="any" :value="$config->cargo_price" width="12" label="Kargo Fiyatı" placeholder="Varsayılan kargo fiyatı" horizontal/>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="image">Açıklama</label><br>
                                    <textarea class="form-control" name="desc" rows="5">{{ old('desc',$config->desc) }}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="image">Footer Text</label><br>
                                    <textarea class="form-control" name="footer_text">{{ old('footer_text',$config->footer_text) }}</textarea>
                                </div>
                                <x-input name="active" type="checkbox" label="Aktif Mi ?" width="12" :value="$config->active" class="minimal"/>
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
                            <x-input type="text" name="facebook" :value="$config->facebook" width="12" label="Facebook Adresi" horizontal/>
                            <x-input type="text" name="instagram" :value="$config->instagram" width="12" label="Instagram Adresi" horizontal/>
                            <x-input type="text" name="twitter" :value="$config->twitter" width="12" label="Twitter Adresi" horizontal/>
                            <x-input type="text" name="youtube" :value="$config->youtube" width="12" label="Youtube Adresi" horizontal/>
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
                            <x-input type="text" name="phone" :value="$config->phone" width="12" label="Telefon" horizontal/>
                            <x-input type="email" name="email" :value="$config->email" width="12" label="Email" horizontal/>
                            <x-input type="text" name="address" :value="$config->address" width="12" label="Adres" horizontal/>
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
                        <x-input type="text" name="full_name" :value="$config->full_name" width="12" label="Tam Ad Soyad" horizontal/>
                        <x-input type="text" name="company_address" :value="$config->company_address" width="12" label="Firma Adres" horizontal/>
                        <x-input type="text" name="company_phone" :value="$config->company_phone" width="12" label="Firma Telefon" horizontal/>
                        <x-input type="text" name="fax" :value="$config->fax" width="12" label="Firma Fax" horizontal/>
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
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
                allowedContent : true
            };
            CKEDITOR.replace('editor1', options);
        })
    </script>
@endsection
