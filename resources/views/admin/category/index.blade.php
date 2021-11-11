@extends('admin.layouts.master')
@section('title',__('admin.navbar.categories'))


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    › @lang('admin.navbar.categories')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.categories.create') }}?type={{ request()->get('type') }}"> <i class="fa fa-plus"></i> @lang('admin.add')</a>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.categories')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="tableCategories">
                        <tbody>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.category.js"></script>
@endsection
