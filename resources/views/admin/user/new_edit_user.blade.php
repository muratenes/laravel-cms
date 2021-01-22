@extends('admin.layouts.master')
@section('title', is_null($user) ? 'kullanıcı ekle' : $user->name.' değiştir')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    › <a href="{{ route('admin.users') }}"> @lang('admin.users')</a>
                    › {{ $user->full_name }}
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
                    <h3 class="box-title">@lang('admin.user_detail')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.user.save',$user->id != null ? $user->id : 0) }}" id="form">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Ad</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Kullanıcı Adı"
                                       value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Soyad</label>
                                <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyad"
                                       value="{{ old('surname', $user->surname) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Parola</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Adresi" value="{{ old('password',$user->email)  }}"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="form-group col-md-3">
                                    <label>Telefon:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" name="phone" value="{{ old('phone', $user->phone )}}" class="form-control"
                                               data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Role:</label>
                                    <div class="input-group">
                                        <select name="role_id" id="" class="form-control" required>
                                            <option value="">Role Seçiniz</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Kullanıcı Dil:</label>
                                    <div class="input-group">
                                        <select name="locale"  class="form-control" required>
                                            @foreach($activeLanguages as $language)
                                                <option value="{{ $language[3] }}" {{ $user->locale == $language[3] ? 'selected' : '' }}>{{ $language[1] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" id="is_active" name="is_active" {{ $user->is_active == 1 ? 'checked': '' }}>
                            </div>

                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Admin Mi ?</label><br>
                                <input type="checkbox" class="minimal" id="is_admin" name="is_admin" {{ $user->is_admin == 1 ? 'checked': '' }}>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Oluşturma Tarihi:</label>

                                <p> {{ $user->created_at }}</p>
                            </div>
                            <!-- /.input group -->
                            <div class="form-group col-md-3">
                                <label>Son Güncellenme Tarihi:</label>

                                <p> {{ $user->updated_at }}</p>
                            </div>
                            <!-- /.input group -->
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
@section('footer')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, locale: {format: 'MM/DD/YYYY hh:mm A'}})
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            })

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>
@endsection
