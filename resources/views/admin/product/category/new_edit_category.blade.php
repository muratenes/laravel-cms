@extends('admin.layouts.master')
@section('title','Kategori detay')

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.product.categories') }}"> Kategoriler</a>
                    › {{ $category->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    @if(!is_null($category->slug))
                        <a target="_blank" href="{{ route('category.detail',$category->slug) }}">Sitede Görüntüle <i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                        &nbsp;@endif
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
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
                        @foreach($category->descriptions as $index => $description)
                            <li>
                                <a href="#tab_category_{{ $index }}" data-toggle="tab">
                                    <img src="{{ langIcon($description->lang) }}"/>
                                </a>
                            </li>
                        @endforeach
                        <li class="pull-right header small" style="font-size:14px"> Kategori Detay</li>

                    </ul>
                    <form role="form" method="post" action="{{ route('admin.product.category.save',$category->id != null ? $category->id : 0) }}" id="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_category_default_language">

                                <div class="box-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1">Başlık</label>
                                            <input type="text" class="form-control" name="title" placeholder="Kategori başlık"
                                                   value="{{ old('title', $category->title) }}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1">Üst Kategori</label>
                                            <select name="parent_category_id" id="parent_category_id" class="form-control">
                                                <option value="">---Kategori Seçiniz --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ $cat->id == old('parent_category_id',$category->parent_category_id) ? 'selected' : '' }}>{{ $cat->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputEmail1">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Kategori slug" disabled
                                                   value="{{ old('slug', $category->slug) }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                        <input type="checkbox" class="minimal" name="active" {{ old('active',$category->active) == 1 ? 'checked': '' }}>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputEmail1">icon</label><br>
                                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Anasayfa icon"
                                               value="{{ old('icon', $category->icon) }}" maxlength="25">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="image">Fotoğraf</label><br>
                                        <input type="file" class="form-control" name="image">
                                        @if($category->image)
                                            <span class="help-block">
                                        <a href="{{ imageUrl('public/categories',$category->image) }}" target="_blank">{{ $category->image }}</a></span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputEmail1">Sıra Numarası</label><br>
                                        <input type="number" class="form-control" id="row" name="row" placeholder="listelemede kullanıcılacak sıra numarası"
                                               value="{{ old('row', $category->row) }}">
                                    </div>
                                    <div class="form-group col-md-11">
                                        <label for="exampleInputEmail1">Açıklama</label>
                                        <input type="text" class="form-control" name="spot" placeholder="Kategori hakkında kısa açıklama" maxlength="255"
                                               value="{{ old('spot', $category->spot) }}">
                                    </div>


                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success">Kaydet</button>
                                </div>

                            </div>
                            <!-- /.tab-pane -->
                            @foreach($category->descriptions as $index => $description)
                                <div class="tab-pane" id="tab_category_{{ $index }}">
                                    <div class="box-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="exampleInputEmail1">Başlık</label>
                                                <input type="text" class="form-control" name="title_{{ $description->lang }}" placeholder="Kategori başlık"
                                                       value="{{ old("title_{{ $description->lang }", $description->title) }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Açıklama</label>
                                                <input type="text" class="form-control" name="spot_{{ $description->lang }}" placeholder="Kategori hakkında kısa açıklama" maxlength="255"
                                                       value="{{ old("spot_{{ $description->lang }", $description->spot) }}">
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
    <!--/.col (left) -->

    </div>
@endsection
@section('footer')
    <script src="{{ asset('admin_files/js/pages/admin.category.js') }}"></script>
@endsection
