@extends('admin.layouts.master')
@section('title',__('admin.navbar.adverts'))


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    › @lang('admin.navbar.advert')
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.adverts.create') }}"> <i class="fa fa-plus"></i> @lang('admin.add')</a>&nbsp;
                    <a href="{{ route('admin.adverts.index') }}"><i class="fa fa-refresh"></i>&nbsp;@lang('admin.refresh')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.navbar.adverts')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            @foreach(config('modules.advert.columns') as $column)
                                <th>{{ $column['label'] }}</th>
                            @endforeach
                        </tr>
                        @if(count($list) > 0)
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l ->id }}</td>
                                    <td><a href="{{ route('admin.adverts.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                    <td>{{ $l->sub_title}}</td>
                                    <td>
                                        @if($l->image)
                                            <a href="{{ imageUrl('public/wads', $l->image) }}"><i class="fa fa-image"></i></a>
                                        @endif
                                    </td>
                                    <td>{{ $l->type }}</td>
                                    <th><img src="{{ langIcon($l->lang) }}" alt=""></th>
                                    <td><i class="fa fa-{{ $l -> status == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td>
                                        <form action="{{ route('admin.adverts.destroy',$l->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Silmek istediğine emin misin ?') "><i
                                                    class="fa fa-trash text-red"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><h5>Reklam Bulunamadı</h5></td>
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
