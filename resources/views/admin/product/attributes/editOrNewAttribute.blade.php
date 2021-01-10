@extends('admin.layouts.master')
@section('title','Özellik Detay')
@section('header')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.product.attribute.list') }}"> Ürün Özellikleri</a>
                    › {{ $item->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="post"
              @if($item->id)
              action="{{ route('admin.product.attribute.save',$item->id) }}"
              @else
              action="{{ route('admin.product.attribute.create') }}"
              @endif
              id="form">
        {{ csrf_field() }}
        <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Özellik Detay</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_default_language" data-toggle="tab">
                                        <img src="{{ langIcon(defaultLangID()) }}"/>
                                    </a>
                                </li>
                                @foreach($item->descriptions as $index => $description)
                                    <li>
                                        <a href="#tab_{{ $index }}" data-toggle="tab">
                                            <img src="{{ langIcon($description->lang) }}"/>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_default_language">
                                    <label>Başlık</label>
                                    <input type="text" class="form-control" name="title_{{ defaultLangID() }}" placeholder="Kategori başlık"
                                           value="{{ old(("title". defaultLangID()) , $item->title) }}">
                                </div>
                                @foreach($item->descriptions as $index => $description)
                                    <div class="tab-pane" id="tab_{{ $index }}">
                                        <label>Başlık</label>
                                        <input type="text" class="form-control" name="title_{{ $description->lang }}" placeholder="Kategori başlık"
                                               value="{{ old(("title_". $description->lang) , $description->title) }}">
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" class="minimal" name="active" {{ old('active',$item->active) == 1 ? 'checked': '' }}>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
                <!-- /.box -->

            </div>
            <!--/.col (left) -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Alt Özellikler</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" title="Yeni Özellik Ekle" onclick="addNewProductAttributeItem()">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body" id="productSubAttributeContainer">
                        @include('admin.product.attributes.partials.edit-sub-attributes')
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
                <!-- /.box -->

            </div>
        </form>

    </div>
@endsection
@section('footer')
    <script src="{{ asset('admin_files/js/productAttribute.js') }}"></script>
@endsection
