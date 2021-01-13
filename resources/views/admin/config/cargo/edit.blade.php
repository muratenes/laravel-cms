@extends('admin.layouts.master')
@section('title','Ayar detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.cargo.index') }}"> Kargolar</a>
                    › {{ $cargo->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">Kaydet</a>
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="POST"
          action="{{ $cargo->id ? route('admin.cargo.update',$cargo->id) : route('admin.cargo.store') }}"
          id="form" enctype="multipart/form-data">
        @method($cargo->id ? 'PUT' : 'POST' )
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kargo Detay</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ route('admin.cargo.store',$cargo->id != null ? $cargo->id : 0) }}" id="form">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Başlık</label>
                                    <input type="text" class="form-control" name="title" placeholder="başlık" required
                                           value="{{ old('title', $cargo->title) }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cargo_tracking_url">Kargo Takip Url</label>
                                    <input type="text" class="form-control" name="cargo_tracking_url" placeholder="kargo takip url"
                                           value="{{ old('cargo_tracking_url', $cargo->cargo_tracking_url) }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cargo_free_amount">Kargo Ücretsiz Tutar <i class="fa fa-question-circle" title="Kargonuz kaç TL üzeri ücretsiz olacak ?"></i></label>
                                    <input type="number" class="form-control" name="cargo_free_amount" placeholder="Muafiyet tutarı"
                                           value="{{ old('cargo_free_amount', $cargo->cargo_free_amount) }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="exampleInputEmail1">Ülke</label>
                                    <select name="country_id" id="languageSelect" class="form-control">
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id',$country->id) == $cargo->country_id ? 'selected' : '' }}> {{ $country->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-right">
                            <button type="submit" class="btn btn-success">Kaydet</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

            </div>
            <!--/.col (left) -->

        </div>
    </form>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>

        $(function () {
            var options = {
                language: 'tr',
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };
            CKEDITOR.replace('editor1', options);
        })
    </script>
@endsection
