@extends('admin.layouts.master')
@section('title','Kargo Ayarları')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Kargolar
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.cargo.create') }}"> <i class="fa fa-plus"></i> Yeni Kargo Ekle</a>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Kargolar</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Başlık</th>
                            <th>Ülke</th>
                            <th>Takip URL</th>
                            <th>Ücretsiz Taşıma</th>
                            <th>#</th>
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.cargo.show', $l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l ->country ? $l->country->title : '' }}</td>
                                    <td>{{  $l ->cargo_tracking_url }}</td>
                                    <td>{{  $l ->cargo_free_amount }}</td>
                                    <td>
                                        <form action="{{ route('admin.cargo.destroy',$l->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Silmek istediğine emin misin ?')"><i class="fa fa-trash text-red"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center"><h5>Kargo Bulunamadı</h5></td>
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
