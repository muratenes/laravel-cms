@extends('admin.layouts.master')
@section('title','İçerik Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › @lang('admin.navbar.content_management')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.content.new') }}"> <i class="fa fa-plus"></i> Yeni İçerik Ekle</a>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.content_management')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="contentManagement">
                        <thead>
{{--                            <tr>--}}
{{--                                <th>ID</th>--}}
{{--                                <th>Başlık</th>--}}
{{--                                <th>Üst</th>--}}
{{--                                <th>Kısa Açıklama</th>--}}
{{--                                <th>Durum</th>--}}
{{--                                @if(config('admin.multi_lang'))--}}
{{--                                    <th>Dil</th>--}}
{{--                                @endif--}}
{{--                                <th>#</th>--}}
{{--                            </tr>--}}
                        </thead>

                    </table>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.content.js"></script>
@endsection
