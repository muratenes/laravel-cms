<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>@yield('title',config('app.name').' | Yönetim')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('admin.creator') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/admin_files/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin_files/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/admin_files/bower_components/Ionicons/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="/admin_files/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/admin_files/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="/admin_files/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="/admin_files/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="/admin_files/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/admin_files/bower_components/select2/dist/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin_files/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/admin_files/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/admin_files/dist/css/custom.css">
    <!-- datatable -->
    <link rel="stylesheet" href="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('header')
</head>
<body class="hold-transition skin-blue sidebar-mini">
{{--<input id="pendingOrderCount" type="hidden" value="{{ $pendingOrderCount }}">--}}
{{--<input id="pendingRefundRequests" type="hidden" value="{{ $pendingRefundRequestCount }}">--}}
<div class="wrapper">

@include('admin.layouts.partials.navbar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">

            <section class="content">
                @include('site.layouts.partials.messages')
                @yield('content')
            </section>
        </div>
    </div>
    @include('admin.layouts.partials.footer')
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- jQuery 3 -->
<script src="/admin_files/bower_components/jquery/dist/jquery.min.js"></script>
<!-- datatable -->
<script src="/admin_files/plugins/jquery-datatable/jquery.dataTables.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/admin_files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="/admin_files/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="/admin_files/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/admin_files/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/admin_files/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="/admin_files/bower_components/moment/min/moment.min.js"></script>
<script src="/admin_files/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="/admin_files/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="/admin_files/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="/admin_files/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="/admin_files/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="/admin_files/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="/admin_files/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin_files/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin_files/dist/js/demo.js"></script>
<script src="/admin_files/js/pages/admin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{{--<script src="/admin_files/bower_components/ckeditor/ckeditor.js"></script>--}}

@yield('footer')
</body>
</html>
