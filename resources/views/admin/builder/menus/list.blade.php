@extends('admin.layouts.master')
@section('title',__('admin.navbar.menu'))
@section('content')
    <input type="hidden" value="/storage/services/" id="imagePrefix">
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Menüler
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.builder.menus.new') }}"><i class="fa fa-plus"></i>&nbsp;Ekle</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Menüler</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="serviceTable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Başlık</th>
                            <th>Link</th>
                            <th>Üst Menü</th>
                            <th>Sıra</th>
                            <th>Modül</th>
                            <th>Durum</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $l)
                            <tr>
                                <td>{{ $l ->id }}</td>
                                <td><b><a href="{{ route('admin.builder.menus.edit',$l->id) }}"> {{ $l->title }}</a></b></td>
                                <td>{{ $l->href}}</td>
                                <td>{{ $l->parent ? $l->parent->title : '' }}</td>
                                <td>{{ $l->order}}</td>
                                <td>{{ $l->module}}</td>
                                <td><i class="fa fa-{{ $l -> status == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                <td><a href="{{ route('admin.builder.menus.delete',$l->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                            class="fa fa-trash text-red"></i></a></td>
                            </tr>
                            @foreach($l->children as $child)
                                <tr>
                                    <td class="">{{ $child ->id }}</td>
                                    <td> &nbsp;&nbsp; <i class="fa fa-angle-double-right"></i> <a href="{{ route('admin.builder.menus.edit',$child->id) }}"> {{ $child->title }}</a></td>
                                    <td>{{ $child->href}}</td>
                                    <td>{{ $child->parent ? $child->parent->title : '' }}</td>
                                    <td>{{ $child->order}}</td>
                                    <td>{{ $child->module}}</td>
                                    <td><i class="fa fa-{{ $child -> status == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    <td><a href="{{ route('admin.builder.menus.delete',$child->id) }}" onclick="return confirm('Silmek istediğine emin misin ?')"><i
                                                class="fa fa-trash text-red"></i></a></td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right"> {{ $list->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
