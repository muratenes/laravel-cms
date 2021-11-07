@extends('admin.layouts.master')
@section('title','Blog Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Blog
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.blog.new') }}"> <i class="fa fa-plus"></i> Yeni Blog Ekle</a>&nbsp;
                    <a href="{{ route('admin.blog') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Blog</h3>
                    <div class="box-tools">
                        <form action="{{ route('admin.blog') }}" method="get" id="form">
                            <div class="row">
                                <div class="col-md-3 input-group input-group-sm hidden-xs  pull-right">
                                    <input type="text" name="q" class="form-control pull-right" placeholder="Bloglarda ara.." value="{{ request('q') }}">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="tableBlog">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Başlık</th>
                            <th>Görsel</th>
                            <th>Durum</th>
                            <th>Fotoğraf</th>
                            <th>#</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.blog.js"></script>
@endsection
