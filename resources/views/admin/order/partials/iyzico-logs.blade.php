<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">İşlem Bilgileri</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Mesaj </th>
                    <th scope="col">Veri</th>
                    <th scope="col">Type</th>
                    <th scope="col">Sepet|Sipariş Id</th>
                    <th scope="col">Url</th>
                    <th scope="col">Tarih</th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <th scope="row">{{ $log->id }}</th>
                        <td><a href="{{ route('admin.log.json',$log->id) }}"><i class="fa fa-eye"></i></a> <a href="/admin/logs/show/{{$log->id}}">{{ $log->message }} </a> </td>
                        <td>{{ $log->exception ? substr($log->exception,0,50).'...' : '-' }}</td>
                        <td>{{ $log->label }}</td>
                        <td>{{ $log->code }}</td>
                        <td>{{ $log->url }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
