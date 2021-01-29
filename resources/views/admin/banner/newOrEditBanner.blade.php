@extends('admin.layouts.master')
@section('title','Banner detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.banners') }}"> Bannerlar</a>
                    › {{ $banner->title }}
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
                    <h3 class="box-title">Banner Detay</h3>
                </div>
                <form role="form" method="post" action="{{ route('admin.banners.save',$banner->id != null ? $banner->id : 0) }}" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$banner->title" required maxlength="50"/>
                            <x-input name="link" label="Link" width="3" :value="$banner->link" maxlength="255" placeholder="Yönlendirelecek link" />
                            <x-input name="image" type="file" label="Görsel" width="2" :value="$banner->image"  path="banners" />
                            <x-input name="active" type="checkbox" label="Aktif Mi ?" width="1" :value="$banner->active" class="minimal"/>
                            <x-input name="sub_title" type="text" label="Alt Başlık" width="6" :value="$banner->sub_title" maxlength="255"/>
                            <x-input name="sub_title_2" type="text" label="2. Alt Başlık" width="6" :value="$banner->sub_title_2" maxlength="255"/>
                        </div>
                        <div class="row">
                            @if(config('admin.MULTI_LANG'))
                                <x-select name="lang" label="Dil" :value="$banner->lang" :options="$languages" key="0" option-value="1" nohint />
                            @endif
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
