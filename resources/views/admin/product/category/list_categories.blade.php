@extends('admin.layouts.master')
@section('title','Kategori Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <div>
                <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                › Kategoriler
            </div>

            <div class="box-tools pull-right">

                <a class="btn btn-box-tool" title="yenile" href="{{ route('admin.product.categories') }}"><i class="fa fa-retweet"></i></a>
                        <a class="btn btn-box-tool" title="kategori ekle" href="{{ route('admin.product.category.new') }}"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Kategoriler</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.product.categories') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3  pull-right">
                                    <select name="parent_category" class="form-control" id="parent_category" onchange="document.getElementById('form').submit()">
                                        <option value="">--Üst Kategori Seçiniz--</option>
                                        @foreach($main_categories as $cat)
                                            <option value="{{ $cat->id }}" {{ request('parent_category') == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Kategorilerde ara.." value="{{ request('q') }}">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Başlık</th>
                            <th>Üst Kategori</th>
                            <th>Sıra Numarası</th>
                            <th>Slug</th>
                            <th>Durum</th>
                            <th>#</th>
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.product.category.edit',$l->id) }}">
                                            {{ $l->title }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($l->parent_category)
                                            <a href="{{ route('admin.product.category.edit',$l->parent_category->id) }}"
                                               title="{{ $l->parent_category->title }}">
                                                <span> {{ $l->parent_category->title }} <i class="fa fa-external-link"></i></span>
                                            </a>
                                        @else
                                            -
                                        @endif

                                    </td>
                                    <td>{{ $l -> row}}</td>
                                    <td>{{ $l ->slug }}</td>
                                    <td><i class="fa fa-{{ $l -> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td><a href="{{ route('admin.product.category.delete',$l->id) }}" onclick="return confirm('Kategoriye ait tüm ürünler silinecek, yinede kategoriyi silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center"><h5>Kategori Bulunamadı</h5></td>
                            </tr>
                        @endif

                        </tbody>

                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q'),'parent_category'=> request('parent_category')])->links() }}</div>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('admin_files/js/pages/admin.category.js') }}"></script>
@endsection
