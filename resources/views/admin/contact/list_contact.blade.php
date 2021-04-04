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
                            @foreach(explode('|',admin('modules.contact.fields')) as $field)
                                <th>{{ $field  }}</th>
                            @endforeach
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
    <script>
        $('#contactTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/contact/ajax'
            },
            "language": {
                "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
            },
            columns: [
                {data: 'id', name: 'id'},
                    @foreach(explode('|',admin('modules.contact.columns')) as $field)
                {
                    data: '{{ $field }}', name: '{{ $field }}'
                },
                    @endforeach
                {
                    data: 'created_at', name: 'created_at',
                    render: function (data, type, row) {
                        return createdAt(data)
                    }
                }
            ],
            order: [0, 'desc'],
            pageLength: 10
        });
    </script>
@endsection
