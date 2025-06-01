@extends('admin.layouts.master')
@section('title','Esnaf Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{route('admin.home_page')}}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Esnaf Raporları
                    › <h4>{{ $selectedVendor['title'] ?? '' }} > {{ request()->get('start_date') }} - {{ request()->get('end_date') }}</h4>
                </div>
                <div class="col-md-2 text-right mr-3">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- filtreleme -->
        <div class="col-md-12">
            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form action="{{ route('admin.vendors.reports') }}" method="GET" id="form">
                            <div class="col-md-12">
                                <div class="form-group col-md-2">
                                    <label for="vendor_id">Esnaf Seç</label>
                                    <select name="vendor_id" id="vendorIdFilter" class="form-control select2" required>
                                        <option value="">Esnaf Seçiniz</option>
                                        @foreach($settings['vendors'] as $vendor)
                                            <option {{ request()->get('vendor_id') == $vendor['id'] ? 'selected' : '' }} value="{{ $vendor['id'] }}">{{ $vendor['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="due_date">Başlangıç Tarihi</label>
                                    <input type="date" name="start_date" id="startDateFilter" class="form-control" value="{{ request()->get('start_date') ?: \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="due_date">Bitiş Tarihi</label>
                                    <input type="date" name="end_date" id="endDateFilter" class="form-control" value="{{ request()->get('end_date') ?: \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                </div>

                                <div class="col-md-2">
                                    <br>
                                    <button class="btn btn-sm btn-success">Filtrele</button>
                                    <a href="{{ route('admin.vendors.reports') }}" class="btn btn-sm btn-danger">Temizle</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($selectedVendor))
            <div class="col-md-12">
                <div class="box">
                    <!-- ./box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <h5 class="description-header text-danger">{{ currency_tr($summary['balance'] ?? 0) }}</h5>
                                    <span class="description-text">Güncel Bakiye</span>
                                    <span class="help-block">Tarih filtrelesi bakiyeyi engellemez</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <h5 class="description-header">{{ currency_tr($summary['order_total_amount']) }}</h5>
                                    <span class="description-text">Toplam Sipariş</span>
                                    <span class="help-block">Seçilen tarih arasındaki sipariş toplam tutarı</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <h5 class="description-header">{{ currency_tr($summary['payment_total_amount']) }}</h5>
                                    <span class="description-text">Toplam Ödeme</span>
                                    <span class="help-block">Seçilen tarih arasındaki yapılan ödeme tutarı</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <canvas id="dailySalesChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            {{--        <div class="col-md-12">--}}
            {{--            <div class="box">--}}
            {{--              <div class="box-body">--}}
            {{--                  <div style="width: 90%; margin: auto;">--}}
            {{--                      <canvas id="vendorDailyTotalChart" height="100"></canvas>--}}
            {{--                  </div>--}}
            {{--              </div>--}}
            {{--            </div>--}}
            {{--        </div>--}}
            <!-- Siparişler -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box ">
                        <div class="box-header">
                            <h3 class="box-title">Siparişler</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-hover table-bordered" id="orderList">
                                <thead>
                                <tr>
                                    <th>Sipariş Kodu</th>
                                    <th>Esnaf</th>
                                    <th>Açıklama</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>Ürünler</th>
                                    <th>Toplam Tutar</th>
                                    <th>Oluşturulma Tarihi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ödemeler -->
            <div class="box ">
                <div class="box-header">
                    <h3 class="box-title">Ödemeler</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="paymentList">
                        <thead>
                        <tr>
                            <th>Ödeme Kodu</th>
                            <th>Esnaf</th>
                            <th>Nakit Ödenen</th>
                            <th>Kartla Ödenen</th>
                            <th>Toplam Ödeme</th>
                            <th>Ödeme Tarihi</th>
                            <th>Açıklama</th>
                            <th>Oluşturulma Tarihi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        @else
            <div class="col-md-12">
               <div class="box">
                   <div class="box-body">
                       <h2 style="text-align: center;color: red">Raporu görüntülemek için esnaf seçiniz</h2>
                   </div>
               </div>
            </div>
        @endif

    </div>
@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.order.list.js"></script>
    <script src="/admin_files/js/pages/admin.payment.list.js"></script>
    <script src="/admin_files/js/pages/admin.vendors.reports.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var labels = {!! $chartLabels !!}; // ['2025-05-20', '2025-05-21', '2025-05-22']
        var productNames = {!! $productNames !!}; // ['Süt', 'Yumurta', 'Tereyağ']
        var rawData = {!! $chartData !!}; // {'Süt': [...], 'Yumurta': [...], ...}

        var backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        var datasets = productNames.map((product, index) => ({
            label: product,
            data: rawData[product],
            backgroundColor: backgroundColors[index % backgroundColors.length],
        }));

        var ctx = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tarih Bazlı Satış Tutarları (₺)'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    x: {
                        stacked: false, // <-- STACKED KAPALI
                        title: {
                            display: true,
                            text: 'Tarih'
                        }
                    },
                    y: {
                        stacked: false, // <-- STACKED KAPALI
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tutar (₺)'
                        }
                    }
                }
            }
        });

        // // other chart
        //
        // var labels = ['2025-05-20', '2025-05-21', '2025-05-22'];
        // var productNames = ['Süt', 'Yumurta', 'Tereyağ'];
        //
        // // Dummy toplam tutar verileri (₺ cinsinden)
        // var rawData = {
        //     'Süt': [1700.25, 1900.75, 2100.00],
        //     'Yumurta': [800.00, 950.50, 1020.25],
        //     'Tereyağ': [1200.00, 1150.00, 1300.00]
        // };
        //
        // var backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56'];
        //
        // var datasets = productNames.map((product, index) => ({
        //     label: product,
        //     data: rawData[product],
        //     backgroundColor: backgroundColors[index % backgroundColors.length],
        // }));
        //
        // var ctx = document.getElementById('vendorDailyTotalChart').getContext('2d');
        // new Chart(ctx, {
        //     type: 'bar',
        //     data: {
        //         labels: labels,
        //         datasets: datasets
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             title: {
        //                 display: true,
        //                 text: 'Tarih Bazlı Ürün Satışları (₺)'
        //             },
        //             tooltip: {
        //                 mode: 'index',
        //                 intersect: false,
        //                 callbacks: {
        //                     label: function(context) {
        //                         // ₺ formatı TR
        //                         return context.dataset.label + ': ' + context.raw.toLocaleString('tr-TR', {
        //                             style: 'currency',
        //                             currency: 'TRY'
        //                         });
        //                     }
        //                 }
        //             }
        //         },
        //         interaction: {
        //             mode: 'index',
        //             intersect: false
        //         },
        //         scales: {
        //             x: {
        //                 stacked: false,
        //                 title: {
        //                     display: true,
        //                     text: 'Tarih'
        //                 }
        //             },
        //             y: {
        //                 stacked: false,
        //                 beginAtZero: true,
        //                 title: {
        //                     display: true,
        //                     text: 'Tutar (₺)'
        //                 },
        //                 ticks: {
        //                     callback: function(value) {
        //                         return value.toLocaleString('tr-TR', {
        //                             style: 'currency',
        //                             currency: 'TRY'
        //                         });
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // });
    </script>
@endsection
