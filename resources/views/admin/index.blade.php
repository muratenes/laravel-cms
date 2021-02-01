@extends('admin.layouts.master')
@section('title','Admin Anasayfa')
@section('link1','products')
@section('link1_title','Ürünler')
@section('link2_title','Ürün adı')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
{{--        @admin('image_quality.another.some2')--}}
{{--            <h2>Multi Lang</h2>--}}
{{--        @endadmin--}}

        <h1>
            Admin
            <small>Kontrol Paneli</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('homeView') }}"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active">Kontrol Paneli</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        @admin('title')
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $data['pending_orders_count'] }}</h3>

                            <p>Bekleyen Siparişler</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.orders') }}?q=&status_filter={{ \App\Models\Siparis::STATUS_SIPARIS_ALINDI }}" class="small-box-footer">Siparişler <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $data['total_order_count'] }}</h3>

                            <p>Toplam Siparişler</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.orders') }}" class="small-box-footer">Toplam Siparişler <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $data['total_user_count'] }}</h3>

                            <p>Kullanıcı Kayıtları</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.users') }}" class="small-box-footer">Kullanıcılar <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $data['completed_orders_count'] }}</h3>

                            <p>Tamamlanmış Siparişler</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-appstore"></i>
                        </div>
                        <a href="{{ route('admin.orders') }}?q=&status_filter={{ \App\Models\Siparis::STATUS_TAMAMLANDI }}" class="small-box-footer">More info <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        @endadmin
    <!-- /.row -->
        <div class="row">
            @admin('dashboard.show_orders')
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box box-header"><h3 class="box-title">Siparişler</h3></div>
                        <div class="box-body table-responsive">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                <tr>
                                    <th>Sipariş Kodu</th>
                                    <th>Ad/Soyad</th>
                                    <th>Kullanıcı</th>
                                    <th>Adres</th>
                                    <th>Telefon</th>
                                    <th>Banka</th>
                                    <th>Durum</th>
                                    <th>Sepet Tutarı</th>
                                    <th>Oluşturulma Tarihi</th>
                                </tr>
                                @foreach($data['last_orders'] as $l)
                                    <tr>
                                        <td><a href="{{ route('admin.order.edit',$l->id) }}">SP-{{ $l->id }}</a></td>
                                        <td><a href="{{ route('admin.order.edit',$l->id) }}"> {{ $l->full_name }}</a></td>
                                        <td>
                                            @if ($l->basket and $l->basket->user)
                                                <a href="{{ route('admin.user.edit',$l->basket->user->id) }}">
                                                    {{ $l->basket->user->full_name }} &nbsp;
                                                    <i class="fa fa-edit"></i></a>
                                            @endif
                                        </td>
                                        <td>{{ $l ->adres }}</td>
                                        <td>{{ $l ->phone }}</td>
                                        <td>{{ $l ->bank }} </td>
                                        <td>{{ $l->statusLabel() }}</td>
                                        <td>{{ $l->order_total_price }} ₺</td>
                                        <td>{{ $l ->created_at }} </td>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="box-footer">
                            <a href="{{ route('admin.orders') }}" class="btn btn-primary pull-right btn-xs">Tümünü Görüntüle</a>
                        </div>
                    </div>
                </div>
            @endadmin
            @admin('dashboard.show_products')
                <div class="col-md-{{ admin('dashboard.show_orders') == false ? '12' : '4' }}">
                    <div class="box box-primary">
                        <div class="box box-header"><h3 class="box-title">Ürünler</h3></div>
                        <div class="box-body table-responsive">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                <tr>
                                    <th>Başlık</th>
                                    <th>Kategori</th>
                                    <th>Slug</th>
                                    <th>Fiyat</th>
                                    <th>Fotoğraf</th>
                                    <th>Durum</th>
                                </tr>
                                @foreach($data['product_list'] as $l)
                                    <tr>
                                        <td><a href="{{ route('admin.product.edit',$l->id) }}"> {{ $l->title }}</a></td>
                                        <td>
                                            @foreach($l->categories as $cat)
                                                @if($loop->index < 3)
                                                    <a href="{{route('admin.product.edit',$cat->id)}}"> {{ $cat->title }} {{ !$loop->index <= 3  ? ',' : '' }}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $l ->slug }}</td>
                                        <td>{{ $l ->price }} ₺</td>
                                        <td>@if($l->image)
                                                <a target="_blank" href="/{{config('constants.image_paths.product_image_folder_path').''. $l ->image }}">Görüntüle</a>
                                            @endif</td>
                                        <td><i class="fa fa-{{ $l-> active == false ? 'times text-red' : 'check text-green' }}"></i></td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="box-footer">
                            <a href="{{ route('admin.products') }}" class="btn btn-primary pull-right btn-xs">Tümünü Görüntüle</a>
                        </div>
                    </div>
                </div>
            @endadmin
        </div>
        @admin('dashboard.show_orders')
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header">Çok Satan Ürünler</div>
                        <div class="box-body">
                            <canvas id="chartCokSatanlar" width="200" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header">Aylara Göre Satışlar</div>
                        <div class="box-body">
                            <canvas id="chartOrderCountPerMonth" width="200" height="100"></canvas>
                        </div>
                    </div>
                </div>


            </div>
        @endadmin

    </section>

    <!-- /.content -->
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.0/dist/Chart.min.js"></script>
    <script>
            @php
                $bestSellersLabels = $bestSellersData =$orderCountPerMonthLabels = $orderCountPerMonthData = "";
                foreach ($data['best_sellers'] as $bs){
                    $bestSellersLabels .= "\"$bs->title\",";
                    $bestSellersData .= "\"$bs->qty\",";
                }
                foreach ($data['sellers_per_month'] as $order){
                    $orderCountPerMonthLabels .= "\"$order->ay\",";
                    $orderCountPerMonthData .= "\"$order->qty\",";
                } // chartOrderCountPerMonth

            @endphp
        var ctx = document.getElementById('chartCokSatanlar').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [{!! $bestSellersLabels !!}],
                datasets: [{
                    label: 'Çok Satan Ürünler',
                    data: [{!! $bestSellersData !!}],
                    borderWidth: 1,
                    backgroundColor: '#3c8dbc',
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        // per month sales
        var ctx = document.getElementById('chartOrderCountPerMonth').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [{!! $orderCountPerMonthLabels !!}],
                datasets: [{
                    label: 'Aylara Göre Satılan Ürün Sayısı',
                    data: [{!! $orderCountPerMonthData !!}],
                    borderWidth: 1,
                    backgroundColor: '#3c8dbc',
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection

