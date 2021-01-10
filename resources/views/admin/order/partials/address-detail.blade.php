<div class="row" style="margin-top: 5px">
    <div class="col-md-6" style="padding-right: 0">
        <div class="box">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2" class="align-items-center text-center"><b>Teslimat Adresi</b></td>
                    </tr>
                    <tr>
                        <th>Ad</th>
                        <td>{{ $order->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Telefon</th>
                        <td>{{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <th>Adres</th>
                        <td>
                        <span>
                            {{ $order->adres }}
                        </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 "  style="padding-left: 3px">
        <div class="box">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2" class="align-items-center text-center"><b>Fatura Adresi</b></td>
                    </tr>
                    <tr>
                        <th>Ad</th>
                        <td>{{ $order->full_name_invoice }}</td>
                    </tr>
                    <tr>
                        <th>Telefon</th>
                        <td>{{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <th>Adres</th>
                        <td>
                        <span>
                            {{ $order->adres }}
                        </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
