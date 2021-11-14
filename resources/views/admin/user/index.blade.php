@extends('admin.layouts.master')
@section('title','Kullancı Listesi')


@section('content')
    <x-breadcrumb :first="__('admin.users')">
        <a href="{{ route('admin.user.create') }}"> <i class="fa fa-plus"></i> @lang('admin.add_new_user')</a>
    </x-breadcrumb>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.users')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>@lang('admin.name')</th>
                            <th>@lang('admin.surname')</th>
                            <th>@lang('admin.email')</th>
                            <th>@lang('admin.role')</th>
                            <th>@lang('admin.updated_at')</th>
                            <th>@lang('admin.created_at')</th>
                            <th>@lang('admin.status')</th>
                            <th>#</th>
                        </tr>
                        </thead>

                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.users.js"></script>
@endsection
