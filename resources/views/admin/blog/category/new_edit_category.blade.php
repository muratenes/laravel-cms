@extends('admin.layouts.master')
@section('title','Kategori detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.blog_category') }}"> Kategoriler</a>
                    › {{ $category->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
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
                    <h3 class="box-title">Kategori Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.blog_category.save',$category->id != null ? $category->id : 0) }}" id="form">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="Kategori başlık"
                                       value="{{ old('title', $category->title) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Üst Kategori</label>
                                <select name="parent_category" id="parent_category" class="form-control">
                                    <option value="">---Kategori Seçiniz --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == old('parent_category',$category->parent_category) ? 'selected' : '' }}>{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Kategori slug" disabled
                                       value="{{ old('slug', $category->slug) }}">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                            <input type="checkbox" class="minimal" name="active" {{ old('active',$category->active) == 1 ? 'checked': '' }}>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">icon</label><br>
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Anasayfa icon"
                                   value="{{ old('icon', $category->icon) }}" maxlength="25">
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
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (left) -->

    </div>
@endsection
