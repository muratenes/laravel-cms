@extends('admin.layouts.master')
@section('title','İletişim Listesi')
@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › İletişim Formları
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.contact') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">İletişim Formları</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="contactTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ad</th>
                                <th>Email</th>
                                <th>Konu</th>
                                <th>Telefon</th>
                                <th>Mesaj</th>
                                <th>Oluşturulma Tarihi</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.contact.js"></script>
@endsection
