@extends('admin.layouts.master')
@section('title','Referans Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Referanslar
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.reference.new') }}"> <i class="fa fa-plus"></i> Yeni Referans Ekle</a>&nbsp;
                    <a href="{{ route('admin.reference') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Referanslar</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.reference') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Referanslarda'lerde ara.." value="{{ request('q') }}">

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
                            <th>Link</th>
                            <th>Açıklama</th>
                            <th>Resim</th>
                            <th>Durum</th>
                            <th>#</th>
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.reference.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l->link}}</td>
                                    <td>{{ substr($l->desc,0,100)}}</td>
                                    <td>
                                        @if($l->image)
                                            <a target="_blank" href="/{{ config('constants.image_paths.reference_image_folder_path').''. $l ->image }}">
                                                <img src="/{{ config('constants.image_paths.reference_image_folder_path').''. $l ->image }}" alt="" width="50" height="50"></a>
                                        @endif
                                    </td>
                                    <td><i class="fa fa-{{ $l -> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td><a href="{{ route('admin.reference.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><h5>Referans Bulunamadı</h5></td>
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
