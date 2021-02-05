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
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary no-border">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_category_default_language" data-toggle="tab">
                                <img src="{{ langIcon(defaultLangID()) }}"/>
                            </a>
                        </li>
                        @foreach($item->descriptions as $index => $description)
                            <li>
                                <a href="#tab_category_{{ $index }}" data-toggle="tab">
                                    <img src="{{ langIcon($description->lang) }}"/>
                                </a>
                            </li>
                        @endforeach
                        <li class="pull-right header small" style="font-size:14px"> Menü Detay</li>

                    </ul>
                    <form role="form" method="POST" action="{{ $item->id != null ? route('admin.builder.menus.update',$item->id) : route('admin.builder.menus.store') }}" id="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @method($item->id ? 'PUT' : 'POST')
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_category_default_language">
                                <div class="box-body">
                                    <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="255"/>
                                    <x-input name="href" label="Yönlendir" width="3" :value="$item->href" maxlength="255" placeholder="Yönlenecek Url"/>
                                    <x-input name="order" label="Sıra" width="1" :value="$item->order" max="255"/>
                                    <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                                    <x-select name="parent_id" label="Üst Menü" :options="$items" :value="$item->parent_id"/>
                                    <x-select name="module" label="Modül" :options="$modules" :value="$item->module" nokey />
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success">Kaydet</button>
                                </div>

                            </div>
                            <!-- /.tab-pane -->
                            @foreach($item->descriptions as $index => $description)
                                <div class="tab-pane" id="tab_category_{{ $index }}">
                                    <div class="box-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Başlık</label>
                                                <input type="text" class="form-control" name="title_{{ $description->lang }}" placeholder="Kategori başlık"
                                                       value="{{ old("title_{{ $description->lang }", $description->title) }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Yönlendir</label>
                                                <input type="text" class="form-control" name="href_{{ $description->lang }}" placeholder="Yönlenecek Url"
                                                       value="{{ old("href_{{ $description->lang }", $description->href) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>


                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.box-header -->
            <!-- form start -->

        </div>
        <!-- /.box -->

    </div>
@endsection
