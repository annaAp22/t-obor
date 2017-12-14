@php
    $deferred = session()->get('goods.defer');
    $bookmarked = $deferred ? array_key_exists($good->id, $deferred) : false;
@endphp
    <li class="gds-item">
        <a href="{{ route('good', $good->sysname) }}">
            <div class="img_blok">
                <img src="/{{ $good->getImgSmallPath() }}{{ $good->img }}" />
                <div class="detal_t">
                    @if($good->hit == 1)
                        <div class="hit">ХИТ</div>
                    @endif
                    @if($good->new == 1)
                        <div class="new">НОВОЕ</div>
                    @endif
                    @if($good->act == 1)
                        <div class="stock">АКЦИЯ</div>
                    @endif
                </div>
            </div>
        </a>
        <a href="{{ route('good', $good->sysname) }}" class="name">{{ $good->name }}</a>
        <div class="price">
            <b>{{ $good->price }} руб.</b>
        </div>
        <button class="btn js-cart-gds add-to-cart-btn"
                data-quantity="1"
                data-id="{{ $good->id }}"
                data-img="/{{ $good->getImgSmallPath() }}{{ $good->img }}"
                data-title="{{ $good->name }}"
                data-price="{{ $good->price }}"
                data-link="{{ route('good', $good->sysname) }}"
                data-sku="{{ $good->article }}">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>В КОРЗИНУ
        </button>
        <p>
            <span>Арт.: </span> {{$good->article}}
        </p>

        <div class="favorits defer-gds {{ $bookmarked ? 'active' : false }}" data-id="{{ $good->id }}">
            <i class="fa fa-star-o" aria-hidden="true"></i>
        </div>

        <div class="hidden_gds_info">
            <button class="btn_hiden js-cart-gds-quick fast-buy-button"
                    data-quantity="1"
                    data-id="{{ $good->id }}"
                    data-img="/{{ $good->getImgSmallPath() }}{{ $good->img }}"
                    data-title="{{ $good->name }}"
                    data-price="{{ $good->price }}"
                    data-link="{{ route('good', $good->sysname) }}"
                    data-sku="{{ $good->article }}">Купить быстро</button>
        </div>
    </li>
