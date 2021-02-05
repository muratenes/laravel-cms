@extends('admin.layouts.master')
@section('title','Hizmet detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.builder.menus') }}"> @lang('admin.navbar.menu')</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != null ? route('admin.builder.menus.update',$item->id) : route('admin.builder.menus.store') }}" id="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Menu Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="255"/>
                            <x-input name="href" label="Yönlendir" width="3" :value="$item->href" maxlength="255" placeholder="Yönlenecek Url"/>
                            <x-input name="order" label="Sıra" width="1" :value="$item->order" max="255"/>
                            <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                            <x-select name="parent_id" label="Üst Menü" :options="$items" :value="$item->parent_id"/>
                            <x-select name="module" label="Modül" :options="$modules" :value="$item->module" nokey />
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
