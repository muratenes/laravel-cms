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

                    <div class="box-tools">
                        <form action="{{ route('admin.banners') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Bannerlarda ara.." value="{{ request('q') }}">

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
                            @foreach(config('modules.banner.columns') as $column)
                                <th>{{ $column['label'] }}</th>
                            @endforeach
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.banners.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l -> sub_title}}</td>
                                    <td>
                                        @if($l->image)
                                            <a href="{{ imageUrl('public/banners', $l->image) }}"><i class="fa fa-image"></i></a>
                                        @endif
                                    </td>
                                    <td>{{ $l -> link}}</td>
                                    <th><img src="{{ langIcon($l->lang) }}" alt=""></th>
                                    <td><i class="fa fa-{{ $l -> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td><a href="{{ route('admin.banners.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><h5>Banner Bulunamadı</h5></td>
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
