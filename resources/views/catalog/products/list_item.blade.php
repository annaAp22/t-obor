@php
    $deferred = session()->get('goods.defer');
    $bookmarked = $deferred ? array_key_exists($product->id, $deferred) : false;
@endphp
    <li class="gds-item">
        <a href="{{ route('good', $product->sysname) }}">
            <div class="img_blok">
                <img src="/{{ $product->getImgSmallPath() }}{{ $product->img }}" />
                <div class="detal_t">
                    @if($product->hit == 1)
                        <div class="hit">ХИТ</div>
                    @endif
                    @if($product->new == 1)
                        <div class="new">НОВОЕ</div>
                    @endif
                    @if($product->act == 1)
                        <div class="stock">АКЦИЯ</div>
                    @endif
                </div>
            </div>
        </a>
        <a href="{{ route('good', $product->sysname) }}" class="name">{{ $product->name }}</a>
        <div class="price">
            <b>{{ $product->price }} руб.</b>
        </div>
        <button class="btn js-cart-gds add-to-cart-btn"
                data-quantity="1"
                data-id="{{ $product->id }}"
                data-img="/{{ $product->getImgSmallPath() }}{{ $product->img }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-priceold="{{ $product->priceOld() }}"
                data-link="{{ route('good', $product->sysname) }}"
                data-articul="{{ $product->article }}">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>В КОРЗИНУ
        </button>
        <p>
            <span>Арт.: </span> {{$product->article}}
        </p>

        <div class="favorits defer-gds {{ $bookmarked ? 'active' : false }}" data-id="{{ $product->id }}">
            <i class="fa fa-star-o" aria-hidden="true"></i>
        </div>

        <div class="hidden_gds_info">
            <button class="btn_hiden js-cart-gds-quick"
                    data-quantity="1"
                    data-id="{{ $product->id }}"
                    data-img="/{{ $product->getImgSmallPath() }}{{ $product->img }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-priceold="{{ $product->priceOld() }}"
                    data-link="{{ route('good', $product->sysname) }}"
                    data-articul="{{ $product->article }}">Купить быстро</button>

            @if($product->attributes->count())
                @foreach($product->attributes as $attribute)
                   {{ $attribute->name }}: <span> {{ $attribute->pivot->value }} {{ $attribute->unit }} </span><br>
                @endforeach
            @endif
        </div>
    </li>