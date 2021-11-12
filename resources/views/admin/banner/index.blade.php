@extends('admin.layouts.master')
@section('title','Banner Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    › @lang('admin.navbar.banner')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.banners.new') }}"> <i class="fa fa-plus"></i> @lang('admin.add')</a>&nbsp;
                    <a href="{{ route('admin.banners') }}"><i class="fa fa-refresh"></i>&nbsp;@lang('admin.refresh')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Bannerlar</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="tableBanner">
                        <thead>
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
    <script src="/admin_files/js/pages/admin.banner.js"></script>
@endsection

