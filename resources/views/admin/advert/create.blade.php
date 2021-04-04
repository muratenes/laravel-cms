@extends('admin.layouts.master')
@section('title','Banner detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.adverts.index') }}"> @lang('admin.navbar.adverts')</a>
                    › {{ $item->title }}
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
                    <h3 class="box-title">@lang('admin.navbar.advert') Detay</h3>
                </div>
                <form role="form" method="POST" action="{{ $item->id != null ? route('admin.adverts.update',$item->id) : route('admin.adverts.store') }}" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @method($item->id ? 'PUT' : 'POST')
                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="255"/>
                            <x-input name="redirect_to" label="Link" width="3" :value="$item->redirect_to" maxlength="255" placeholder="Yönlendirelecek link" />
                            <x-input name="redirect_to_label" label="Yönlendirme Başlığı" width="3" :value="$item->redirect_to_label"  maxlength="100"/>
                            <x-input name="image" type="file" label="Görsel" width="2" :value="$item->image"  path="wads" />
                            <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                            <x-input name="sub_title" type="text" label="Alt Başlık" width="4" :value="$item->sub_title" maxlength="255"/>
                            @if(config('admin.multi_lang'))
                                <x-select name="lang" label="Dil" :value="$item->lang" :options="$languages" key="0" option-value="1" nohint />
                            @endif
                            <x-select name="type" label="Tür" :value="$item->type" :options="$types" key="0" option-value="1" nohint />
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
