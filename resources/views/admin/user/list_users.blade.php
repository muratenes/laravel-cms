@extends('admin.layouts.master')
@section('title','Kullancı Listesi')


@section('content')
    <x-breadcrumb :first="__('admin.users')">
        <a href="{{ route('admin.user.new') }}"> <i class="fa fa-plus"></i> @lang('admin.add_new_user')</a>
    </x-breadcrumb>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.users')</h3>

                    <div class="box-tools">
                        <form action="{{ route('admin.users') }}" method="get">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="q" class="form-control pull-right" placeholder="Kullanıcılarda ara.." value="{{ request('q') }}">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                            <th>@lang('admin.name')</th>
                            <th>@lang('admin.email')</th>
                            <th>@lang('admin.updated_at')</th>
                            <th>@lang('admin.created_at')</th>
                            <th>@lang('admin.role')</th>
                            <th>@lang('admin.status')</th>
                            <th>#</th>
                        </tr>
                        @foreach($list as $u)
                            <tr>
                                <td>{{ $u ->id }}</td>
                                <td><a href="{{ route('admin.user.edit',$u->id) }}"> {{ $u->full_name }}</a></td>
                                <td>{{ $u ->email }}</td>
                                <td>{{ $u ->updated_at }}</td>
                                <td>{{ $u ->created_at }}</td>
                                <td>{{ $u->role ? $u->role->name :  '-' }}</td>
                                <td><i class="fa fa-{{ $u -> is_active == false ? 'times text-red' : 'check text-green' }} "></i></td>
                                <td><a href="{{ route('admin.user.delete',$u->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                            class="fa fa-trash text-red"></i></a></td>
                            </tr>
                        @endforeach
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
