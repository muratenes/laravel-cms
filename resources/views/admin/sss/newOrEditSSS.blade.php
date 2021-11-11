@extends('admin.layouts.master')
@section('title','SSS detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.sss') }}"> Sık Sorulan Sorular</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">SSS Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.sss.save',$item->id != null ? $item->id : 0) }}" id="form">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="başlık" required
                                       value="{{ old('title', $item->title) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ $item->active == 1 ? 'checked': '' }}>
                            </div>
                            @if(config('admin.multi_lang'))
                                <div class="form-group col-md-2">
                                    <label for="exampleInputEmail1">Dil</label>
                                    <select name="lang" id="languageSelect" class="form-control">
                                        @foreach($languages as $lang)
                                            <option value="{{ $lang[0] }}" {{ old('lang',$item->lang) == $lang[0] ? 'selected' : '' }}> {{ $lang[1] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Açıklama</label>
                                <textarea name="desc" class="form-control" id="desc" cols="30" rows="10" required>{{ old('desc',$item->desc) }}</textarea>
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
@endsection
