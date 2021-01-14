<head>
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            line-height: 1.25;
        }

        .table {
            border: 1px solid #3e0404;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }

        .table caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }

        .table tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;
        }

        .table th,
        .table td {
            padding: .625em;
            text-align: center;
        }

        .table th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .success-message {
            color: green;
            font-size: 20px
        }

        .order-code-table {
            width: 100%;
            border: 1px solid red;
        }

        .app-title {
            align-content: center;
            justify-content: center;
            text-align: center;
            font-size: 23px;
            font-weight: 600;
        }

        .bold {
            font-weight: bold;
            color: black;
        }

        body {
            font-size: 100%
        }

        .addressText {
            font-size: 1.1em;
        }

        @media screen and (max-width: 600px) {
            .table {
                border: 0;
            }

            .table caption {
                font-size: 1.3em;
            }

            .table thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            .table tr {
                border-bottom: 3px solid #ddd;
                display: block;
                margin-bottom: .625em;
            }

            .table td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: .8em;
                text-align: right;
            }

            .table td::before {
                /*
                * aria-label has no advantage, it won't be read inside a table
                content: attr(aria-label);
                */
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }

            .table td:last-child {
                border-bottom: 0;
            }
        }
    </style>
</head>
<body>
<div>
    <h1 class="app-title">{{ env('APP_NAME') }}</h1>
</div>
<hr>
<h3 class="success-message">@lang('lang.hello_username',['username' => $basket->user->full_name]), @lang('lang.order_successfully_received')</h3>
<table>
    <tr>
        <td><b>{{ __('lang.order_code') }} :</b></td>
        <td>{{ $order->code }} <a href="{{ route('user.orders.detail',$order->id) }}">{{ __('lang.show_order') }}</a></td>
    </tr>
    <tr>
        <td><b>@lang('lang.order_date') :</b></td>
        <td>{{ $order->created_at }}</td>
    </tr>
</table>

<br>
<table class="table">

    <thead>
    <tr>
        <th scope="col" class="bold">@lang('lang.product')</th>
        <th scope="col" class="bold">@lang('lang.price')</th>
        <th scope="col" class="bold">@lang('lang.qty')</th>
        <th scope="col" class="bold">@lang('lang.cargo_price')</th>
        <th scope="col" class="bold">@lang('lang.total')</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($basket->basket_items as $item)
        <tr>
            <td data-label="product">
                <a href="{{ route('product.detail',$item->product->slug) }}">
                    {{ $item->product->title }}
                </a>
            </td>
            <td data-label="Due Date">{{ $item->price }} {{ getCurrencySymbolById($order->currency_id) }}</td>
            <td data-label="Amount">{{ $item->qty }}</td>
            <td data-label="Amount">{{ $item->cargo_price }} {{ getCurrencySymbolById($order->currency_id) }}</td>
            <td data-label="Period">{{ $item->total }} {{ getCurrencySymbolById($order->currency_id) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<!-- genel özet -->
<table style="width:40%;float: right;margin-top: 5px" class="table">

    <tbody>

    <tr>
        <th class="bold">@lang('lang.sub_total')</th>
        <td>{{ getCurrencySymbolById($order->currency_id) }} {{ $order->order_price }}</td>
    </tr>
    <tr>
        <th class="bold">@lang('lang.cargo_price')</th>
        <td>{{ getCurrencySymbolById($order->currency_id) }} {{ $order->cargo_price }}</td>
    </tr>
    @if ($order->coupon_price)
        <tr>
            <th class="bold">@lang('lang.coupon')</th>
            <td>
                <span style="color:#29b10b">{{ getCurrencySymbolById($order->currency_id) }} -{{ $order->coupon_price }}</span></td>
        </tr>
    @endif

    <tr>
        <th class="bold">@lang('lang.total_amount')</th>
        <td>{{ getCurrencySymbolById($order->currency_id) }} {{  $order->order_total_price }}</td>
    </tr>
    </tbody>
</table>

<!-- adres/teslimat bilgileri -->
<table style="width:100%;border: 1px solid black;top: 10px" class="table">
    <tbody>
    <tr>
        <th class="bold">@lang('lang.delivery_address')</th>
        <th class="bold">@lang('lang.invoice_address')</th>
    </tr>
    <tr>
        <td style="border:3px solid #e7e7e7">
            <p style="text-align: center" class="addressText">
                {{ $order->adres }}
            </p>
        </td>
        <td style="border:3px solid #e7e7e7">
            <p style="=text-align: center;" class="addressText">
                {{ $order->fatura_adres }}
            </p>
        </td>
    </tr>

    </tbody>
</table>
</body>
