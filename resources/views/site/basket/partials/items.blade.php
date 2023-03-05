@foreach(cartItems() as $item)
    <li>
        <a href="javascript:removeBasketItem({{ $item->id }})" class="item_remove"><i class="ion-close"></i></a>
        <a href="#"><img src="{{ imageUrl('public/products/thumb',$item->attributes['product']['image']) }}" alt="{{ $item->name }}">{{$item->name}}</a>
        <span class="cart_quantity"> {{ $item->quantity }} x <span class="cart_amount"> <span class="price_symbole">{{ currentCurrencySymbol() }} </span></span>{{ $item->price }}</span>
    </li>
@endforeach
