@extends('admin.layouts.master')
@section('title','Site Ayarları')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Ayarlar
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.config.show', 0) }}"> <i class="fa fa-plus"></i> Yeni Ayar Ekle</a>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Ayarlar</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Site Başlık</th>
                            <th>Domain</th>
                            <th>Logo</th>
                            <th>Icon</th>
                            <th>Telefon</th>
                            <th>Mail</th>
                            <th>Varsayılan Kargo Fiyatı</th>
                            <th>Dil</th>
{{--                            <th>#</th>--}}
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.config.show', $l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l ->domain }}</td>
                                    <td>{{ $l ->logo }}</td>
                                    <td>{{ $l ->icon }}</td>
                                    <td>{{ $l ->tel }}</td>
                                    <td>{{ $l ->mail }}</td>
                                    <td>{{ $l ->cargo_price }}</td>
                                    <td><img src="{{ langIcon($l->lang)  }}" alt=""></td>
                                    <td><a href="{{ route('admin.config.show',$l->id) }}"><i class="fa fa-edit text-green"></i></a></td>
{{--                                    <td><a href="{{ route('admin.config.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i--}}
{{--                                                class="fa fa-trash text-red"></i></a>--}}
{{--                                    </td>--}}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center"><h5>Ayar Bulunamadı</h5></td>
                            </tr>
                        @endif
                        </tbody>

                    </table>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection


