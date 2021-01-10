@extends('admin.layouts.master')
@section('title','SSS detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.roles') }}"> Roller</a>
                    › {{ $item->name }}
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
                    <h3 class="box-title">Rol Detay</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.role.save',$item->id != null ? $item->id : 0) }}" id="form">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Rol Adı</label>
                                <input type="text" class="form-control" name="name" placeholder="başlık" required
                                       value="{{ old('title', $item->name) }}">
                            </div>
                            <div class="form-group col-md-10">
                                <label for="exampleInputEmail1">Kısa Açıklama</label>
                                <input name="description" class="form-control" id="desc" value="{{ old('description',$item->description) }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <select multiple class="form-control" style="height: 600px" name="roles[]" required>
                                    @foreach($allPermissions as $permission)
                                        <option value="{{ $permission->id }}" {{ collect($userPermission)->contains($permission->id) ? 'selected' : '' }}> {{ $permission->name}} </option>
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
@endsection
