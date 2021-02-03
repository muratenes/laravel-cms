@extends('admin.layouts.master')
@section('title','Banner detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="#"> Ayar</a>
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="post" action="{{ route('admin.builder.save') }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <div class="row">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Genel Ayarlar</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="50"/>
                                <x-input name="short_title" label="Kısa Başlık" width="2" :value="$item->short_title" maxlength="4"/>
                                <x-input name="creator" label="Oluşturucu" width="3" :value="$item->creator" maxlength="100"/>
                                <x-input name="creator_link" label="Oluşturucu Site" width="3" :value="$item->creator_link" maxlength="100"/>
                                <x-input name="max_upload_size" type="number" label="Upload Size" width="2" :value="$item->max_upload_size" help="Sunucuya yüklenen max dosya boyutu"/>
                                <x-input name="multi_lang" type="checkbox" label="Çoklu Dil ?" width="2" :value="$item->multi_lang" class="minimal"/>
                                <x-input name="multi_currency" type="checkbox" label="Çoklu Para Birimi ?" width="3" :value="$item->multi_currency" class="minimal"/>
                                <x-select name="default_language" label="Varsayılan Dil" :value="$item->default_language" :options="$languages" key="0" option-value="1" nohint/>
                                <x-select name="default_currency" label="Varsayılan Para B." :value="$item->default_currency" :options="$currencies" key="0" option-value="1" nohint width="3" help="Varsayılan para birimi"/>
                                <x-input name="default_currency_prefix" label="Para Birim Ön Ek" width="2" :value="$item->default_currency_prefix" maxlength="4" width="3" help="Varsayılan Para Birimi Ön Eki"/>
                                <x-input name="force_lang_currency" type="checkbox" label="Para birimi zorla ?" width="3" :value="$item->force_lang_currency" class="minimal" help="Seçilen ülkeye  göre varsayılan para birimini zorla"/>
                            </div>
                        </div>
                        <div class="box-footer text-right">
                            <button type="submit" class="btn btn-success">Kaydet</button>
                        </div>

                    </div>
                </div>
                <!-- module status -->
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Modül Durumları <i class="fa fa-question-circle" title="Modüllerin aktif/pasiflik durumu"></i></h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                @foreach($item->modules_status as $key => $value)
                                    @php
                                        $name = "modules_status[{$key}]"
                                    @endphp
                                    <div class="form-group col-md-1">
                                        <input type="hidden" name="{{ $name }}" value="0">
                                        <label for=""> {{ $key }}</label><br>
                                        <input type="checkbox" name="{{ $name }}" {{ $value == 1 ? 'checked' : '' }}>
                                    </div>
                                    {{--                                    <x-input :name="$name" type="checkbox" :label="$key" width="1" :value="$value" class="minimal"/>--}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box box-primary collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Modüller <i class="fa fa-question-circle" title="Modüllerin içerisindeki konfigürasyonlar"></i></h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                                @foreach($item->modules as $keyModule => $valueModule)
                                    @php
                                        $name = "modules[{$keyModule}]"
                                    @endphp
                                    <div class="row">
                                        <h5><strong>----{{ mb_strtoupper($keyModule) }}-----</strong></h5>

                                        @foreach($item->modules[$keyModule] as $subKey => $subValue)
                                            <div class="form-group col-md-{{ is_bool($subValue) ? 1 : (is_array($subValue) ? 5 : 3)  }} ">
                                                @php
                                                    $subName = $name.'['.$subKey.']';
                                                @endphp
                                                @if (is_bool($subValue))
                                                    <input type="hidden" name="{{ $subName }}" value="0">
                                                    <label for="" style="font-size: 12px"> {{ $subKey }}</label><br>
                                                    <input type="checkbox" name="{{ $subName }}" {{ $subValue == 1 ? 'checked' : '' }}>
                                                @elseif (is_array($subValue))
                                                    <x-input :name="$subName" :label="$subKey" width="12" :value="json_encode($subValue)"/>
                                                @else
                                                    <x-input :name="$subName" :label="$subKey" width="12" :value="$subValue"/>
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- image quality -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Görsel Ayarları <i class="fa fa-question-circle" title="Modüllerin görselleri yüzde kaç küçültülsün?"></i></h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    @foreach($item->image_quality as $key => $image)
                                        @php
                                            $name = "image_quality[{$key}]"
                                        @endphp
                                        <x-input :name="$name" type="number" :label="$key" width="3" :value="$image" max="100"/>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Tema Ayarları <i class="fa fa-question-circle" title="Tema,Banner,Footer ayarları"></i></h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Tema</label>
                                        <select name="site[theme][name]" id="theme" class="form-control">
                                            <option value="">--</option>
                                            @foreach($themes as $theme)
                                                <option value="{{ $theme }}" {{ $theme == $item->site['theme']['name']  ? 'selected' : '' }}>{{ $theme }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Banner</label>
                                        <select name="site[theme][banner]" id="banner" class="form-control">
                                            @foreach($banners as $banner)
                                                <option value="{{ $banner }}" {{ $banner == $item->site['theme']['banner']  ? 'selected' : '' }}>{{ $banner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Header</label>
                                        <select name="site[theme][header]" id="header" class="form-control">
                                            @foreach($headers as $header)
                                                <option value="{{ $header }}" {{ $header == $item->site['theme']['header']  ? 'selected' : '' }}>{{ $header }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Footer</label>
                                        <select name="site[theme][footer]" id="footer" class="form-control">
                                            @foreach($footers as $footer)
                                                <option value="{{ $footer }}" {{ $footer == $item->site['theme']['footer']  ? 'selected' : '' }}>{{ $footer }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Contact</label>
                                        <select name="site[theme][contact]" id="contact" class="form-control">
                                            @foreach($contacts as $contact)
                                                <option value="{{ $contact }}" {{ $header == $item->site['theme']['contact']  ? 'selected' : '' }}>{{ $contact }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.builder.js"></script>
@endsection
