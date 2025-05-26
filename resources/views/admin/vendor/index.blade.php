@extends('admin.layouts.master')
@section('title','Esnaf Listesi')


@section('content')
    <x-breadcrumb first="Esnaflar">
        <a href="{{ route('admin.vendors.create') }}"> <i class="fa fa-plus"></i> Yeni Esnaf Ekle</a>
    </x-breadcrumb>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Esnaflar</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="vendorTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Esnaf</th>
                            <th>Ad - Soyad</th>
                            <th>Telefon</th>
                            <th>Oluşturma Tarihi</th>
                            <th>Aktif Mi? <i class="Paneli kullanabilir mi?"></i></th>
                            <th>#</th>
                        </tr>
                        </thead>

                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->
    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.vendors.js"></script>
@endsection
