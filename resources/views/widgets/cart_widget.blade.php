<!--если корзина пуста дописываем класс disabled-->
<div class="main-header_cart {{ empty($cart['goods']) ? 'empty-cart' : '' }}">
    <div class="main-header_cart_count">{{ $cart['count'] }}</div>
    <div class="main-header_cart_title">Корзина</div>
    <div class="main-header_cart_total">{{ $cart['amount'] }} р.</div>

    <div class="main-header_cart_detail">
        @if(!empty($cart['goods']))
            @foreach($cart['goods'] as $product)
                <div class="main-header_cart_detail_item" data-id="{{ $product->id }}">
                    <figure><img src="/{{ $product->getImgSmallPath() }}{{ $product->img }}"></figure>
                    <div><a href="{{ route('good', $product->sysname) }}">{{ $product->name }}</a></div>
                    <span>{{ $product->price }} р.</span>
                </div>
            @endforeach
        @endif
        <div class="empty-cart">Ваша корзина пуста</div>
        <div class="main-header_cart_detail_bottom">
            <div>Итого: <span class="mod-col-or">{{ $cart['amount'] }} р.</span></div>
            <a href="{{ route('cart') }}">Перейти в корзину</a>
        </div>
    </div>
</div>
