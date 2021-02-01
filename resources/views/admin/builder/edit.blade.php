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
                                    <x-input :name="$name" type="checkbox" :label="$key" width="1" :value="$value" class="minimal"/>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
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
                                <x-input :name="$name" type="number" :label="$key" width="6" :value="$image" max="100" help="Resim kalitesidir. boş bırakılırsa resim ölçeklendirmez"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
