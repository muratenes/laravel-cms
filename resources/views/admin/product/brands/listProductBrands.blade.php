@extends('admin.layouts.master')
@section('title','Ürün Markaları')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Markalar
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.product.brands.new') }}"> <i class="fa fa-plus"></i> Yeni Marka Ekle</a>&nbsp;
                    <a href="{{ route('admin.product.brands.list') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Markalar</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.product.brands.list') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Markalarda ara.." value="{{ request('q') }}">

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
                            <th>slug</th>
                            <th>Foto</th>
                            <th>Durum</th>
                            <th>#</th>
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.product.brands.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l -> slug}}</td>
                                    <td>@if($l->image)
                                            <a target="_blank" href="{{ config('constants.image_paths.brand_image_folder_path').''. $l ->image }}">
                                                <img src="{{ config('constants.image_paths.brand_image_folder_path').''. $l ->image }}" alt="" width="50" height="50"></a>
                                        @endif</td>
                                    <td><i class="fa fa-{{ $l -> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td><a href="{{ route('admin.product.brands.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><h5>Marka Bulunamadı</h5></td>
                            </tr>
                        @endif

                        </tbody>

                    </table>
                    <div class="text-right"> {{ $list->appends(['q' => request('q')])->links() }}</div>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
