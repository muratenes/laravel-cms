@if($summary)
    <div class="box">
        <!-- ./box-body -->
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header text-danger">{{ currency_tr($summary['balance']) }}</h5>
                        <span class="description-text">Güncel Bakiye</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header">{{ currency_tr($summary['order_total_amount']) }}</h5>
                        <span class="description-text">Toplam Sipariş</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header">{{ currency_tr($summary['payment_total_amount']) }}</h5>
                        <span class="description-text">Toplam Ödeme</span>
                    </div>
                    <!-- /.description-block -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-footer -->
    </div>
@endif