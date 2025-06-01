@extends('admin.layouts.master')
@section('title','Esnaf Listesi')


@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{route('admin.home_page')}}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Esnaf Raporları
                    › <h4>{{ $selectedVendor['title'] ?? '' }} > {{ request()->get('date_range') }}</h4>
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
                                    <select name="vendor_id" id="vendorIdFilter" class="form-control select2 vendorIdFilter" required>
                                        <option value="">Esnaf Seçiniz</option>
                                        @foreach($settings['vendors'] as $vendor)
                                            <option {{ request()->get('vendor_id') == $vendor['id'] ? 'selected' : '' }} value="{{ $vendor['id'] }}">{{ $vendor['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date_range">Tarih Aralığı</label>
                                    <input type="text" name="date_range" id="dateRangePicker" class="form-control"
                                           value="{{ request('date_range') ?: \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') . ' - ' . \Carbon\Carbon::now()->format('Y-m-d') }}"
                                           autocomplete="off" readonly>
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
                        <canvas id="salesChart" height="100"></canvas>
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
    <script src="/admin_files/js/pages/admin.reports.js"></script>
    <script src="/admin_files/js/pages/admin.order.list.js"></script>
    <script src="/admin_files/js/pages/admin.payment.list.js"></script>
    <script src="/admin_files/js/pages/admin.vendors.reports.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- -reports --->

    <script>
        const getQueryParam = (key) => {
            const params = new URLSearchParams(window.location.search);
            return params.get(key);
        };

        const vendorId = getQueryParam('vendor_id');
        const dateRange = getQueryParam('date_range');

        // vendorId veya dateRange yoksa, uyarı ver
        if (!vendorId || !dateRange) {
            document.getElementById('salesChart').replaceWith("Lütfen URL'de vendor_id ve date_range parametrelerini belirtin.");
            throw new Error("Eksik parametre: vendor_id veya date_range yok.");
        }

        // Tarih aralığını parçala
        const [start, end] = dateRange.split(' - ').map(d => new Date(d.trim()));
        const dayDiff = (end - start) / (1000 * 60 * 60 * 24); // milisaniye -> gün

        if (isNaN(dayDiff) || dayDiff < 0) {
            alert("Geçersiz tarih aralığı!");
            throw new Error("Geçersiz tarih aralığı.");
        }

        if (dayDiff > 32) {
            document.getElementById('salesChart').replaceWith("Satış verilerini grafik halinde görmek için tarih aralığı en fazla 30 gün olmalıdır");
            throw new Error("Tarih aralığı 30 günden büyük.");
        }


        fetch(`/admin/vendors/reports/daily-sales-by-vendor?vendor_id=${vendorId}&date_range=${encodeURIComponent(dateRange)}`)
            .then(res => res.json())
            .then(data => {
                new Chart("salesChart", {
                    type: "line",
                    data: {
                        labels: data.labels,
                        datasets: data.datasets.map((ds, i) => {
                            const colors = [
                                { border: "rgba(54, 162, 235, 1)", background: "rgba(54, 162, 235, 0.1)" },
                                { border: "rgba(255, 206, 86, 1)", background: "rgba(255, 206, 86, 0.1)" },
                                { border: "rgba(75, 192, 192, 1)", background: "rgba(75, 192, 192, 0.1)" },
                                { border: "rgba(255, 99, 132, 1)", background: "rgba(255, 99, 132, 0.1)" },
                                { border: "rgba(153, 102, 255, 1)", background: "rgba(153, 102, 255, 0.1)" }
                            ];
                            const c = colors[i % colors.length];
                            return {
                                label: ds.label,
                                data: ds.data,
                                fill: true,
                                tension: 0.3,
                                borderColor: c.border,
                                backgroundColor: c.background
                            };
                        })
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: "Son Satış Trendleri"
                            },
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: "Satış Adedi"
                                }
                            },
                            x: {
                                ticks: {
                                    maxTicksLimit: 10
                                }
                            }
                        }
                    }
                });
            });
    </script>
@endsection
