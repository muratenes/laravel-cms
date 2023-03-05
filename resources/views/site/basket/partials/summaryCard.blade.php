<div class="cart-summary">
    <h3>Sepet Özeti</h3>
    <table class="table table-totals">
        <tbody>
        <tr>
            <td>Ara Toplam</td>
            <td>{{ currentCurrencySymbol() }}<span class="cartSubTotal">{{ cartSubTotal() }} ( {{ $basket ? $basket->sub_total : '-' }})</span></td>
        </tr>
        <tr>
            <td>Kargo</td>
            <td>{{ currentCurrencySymbol() }}<span>{{ cartTotalCargoPrice() }}</span></td>
        </tr>
        @if(session()->get('coupon'))
            <tr>
                <td>Kupon - {{ session()->get('coupon')['code'] }}</td>
                <td style="color: green">- {{ currentCurrencySymbol() }}<span class="text-green bg-green">{{ session()->get('coupon')['discount_price'] }}</span></td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td>Genel Toplam</td>
            <td>{{ currentCurrencySymbol() }}<span class="cartTotal">{{ cartTotalPrice() }}
                                ( {{ $basket ? $basket->total : '-' }})
                                </span></td>
        </tr>
        </tfoot>
    </table>

    <div class="checkout-methods">
        @if(cartItemCount())
            <a href="{{route('odemeView')}}" class="btn btn-block btn-sm btn-primary">Ödeme Yap</a>
        @endif
    </div>
</div>
