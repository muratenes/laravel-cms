@extends('admin.layouts.master')
@section('title','Log Detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.logs') }}"> Loglar</a>
                    › {{ $log->code }}
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
                    <h3 class="box-title">Log Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-1">
                                    <label for="exampleInputEmail1">ID</label>
                                    <p>{{ $log->id }}</p>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="exampleInputEmail1">Kullanıcı ID</label>
                                    <p><a href="{{ $log->user_id != null ? route('admin.user.edit',$log->user_id)  : '#'}}">{{ $log->user_id }}</a></p>
                                </div>
                                <div class="form-group col-md-10">
                                    <label for="exampleInputEmail1">Mesaj</label><br>
                                    <p>{{ $log->message }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Kod</label><br>
                                    <p>{{ $log->code }}</p>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="exampleInputEmail1">Url</label><br>
                                    <p>{{ $log->url }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Oluşturulma Tarihi</label><br>
                                    <p>{{ $log->created_at }}</p>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Exception Type</label><br>
                                    <p>{{ $log->exception_type }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Hata
                                    <a href="{{ route('admin.log.json',$log->id) }}" target="_blank"><i class="fa fa-eye"></i></a>
                                </label><br>
                                <textarea name="" id="" cols="100" rows="50" class="form-control">
                                    {{ $log->exception }}
                                </textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->

        </div>
        <!--/.col (left) -->

    </div>
@endsection
