@extends('admin.layouts.master')
@section('title','Takım detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.our_team') }}"> Takımımız</a>
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
                    <h3 class="box-title">Kişi Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.our_team.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Ad & Soyad</label>
                                <input type="text" class="form-control" name="title" placeholder="ad ve soyad" required
                                       value="{{ old('title', $item->title) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Pozisyon</label>
                                <input type="text" class="form-control" name="position" placeholder="örn:asistan,görevli vb."
                                       value="{{ old('position', $item->position) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="image">Fotoğraf</label><br>
                                <input type="file" class="form-control" name="image">
                                @if($item->image)
                                    <span class="help-block"><a target="_blank"
                                                                href="{{ imageUrl('public/our-team',$item->image) }}">{{ $item->image }}</a></span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="active" {{ old('active',$item->active) == 1 ? 'checked': '' }}>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Açıklama</label>
                                <textarea name="desc" class="form-control" id="desc" cols="30" rows="10">{{old('desc', $item->desc) }}</textarea>
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
