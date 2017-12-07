@extends('layouts.main')
@php
$deferred = session()->get('goods.defer');
$bookmarked = $deferred ? array_key_exists($good->id, $deferred) : false;
@endphp
@section('breadcrumbs')
    {!!  Breadcrumbs::render('product', $good) !!}
@endsection

@section('content')
<div class="pruduct_page good-item">
    <div class="product_slider">
        <h1>{{ $good->name }}</h1>
        <div class="product_slider_container">
            <div class="product_slider_nav">
                <div class="slide img_blok">
                    <img src="/{{ $good->getImgPreviewPath() }}{{ $good->img }}">
                </div>
                @foreach($good->photos as $photo)
                    <div class="slide img_blok">
                        <img src="/{{ $photo->getImgPreviewPath() }}{{ $photo->img }}">
                    </div>
                @endforeach
            </div>
            <div class="product_slider_for">
                <div class="slide">
                    <img src="/{{ $good->getImgPath() }}{{ $good->img }}">
                </div>
                @foreach($good->photos as $photo)
                    <div class="slide">
                        <img src="/{{ $photo->getImgPath() }}{{ $photo->img }}">
                    </div>
                @endforeach

            </div>
            <div class="favorites defer-good {{ $bookmarked ? 'active' : false }}" data-id="{{ $good->id }}">
                <i class="fa fa-star-o" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="product_info">
        <div class="articul">
            <span>Артикул:</span> {{ $good->article }}
        </div>
        <form onsubmit="return false;">
            <div class="left">
                Количество:
                <input type="number" min="1" value="1">
            </div>
            <div class="right">
                <div class="price">
                    <b>{{ $good->price }} руб.</b>
                </div>
            </div>
            <button class="btn cart-good"
                    data-quantity="1"
                    data-id="{{ $good->id }}"
                    data-img="/{{ $good->getImgSmallPath() }}{{ $good->img }}"
                    data-name="{{ $good->name }}"
                    data-price="{{ $good->price }}"
                    data-link="{{ route('good', $good->sysname) }}"
                    data-articul="{{ $good->article }}">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                ПОЛОЖИТЬ В КОРЗИНУ
            </button>

            <button class="btn btn_white cart-good-quick"
                    data-quantity="1"
                    data-id="{{ $good->id }}"
                    data-img="/{{ $good->getImgSmallPath() }}{{ $good->img }}"
                    data-name="{{ $good->name }}"
                    data-price="{{ $good->price }}"
                    data-link="{{ route('good', $good->sysname) }}"
                    data-articul="{{ $good->article }}">Купить быстро</button>
        </form>
        <div class="product_params">
            @foreach($good->attributes as $attr)
                <div class="prams_row">
                    <div>{{ $attr->name }}:</div>
                    <div></div>
                    <div>{{ $attr->pivot->value }} {{ $attr->unit }}</div>
                </div>
            @endforeach
            <br>
            <div>
                <p>{{ $good->description }}</p>
            </div>
            <div>
                {!! $good->text !!}
            </div>
        </div>
    </div>
</div>

<div class="dop_prod_info">
    <div>
        <b>Доставка малогабаритного товара:</b>
        <ol>
            <li>По любому району Москвы до МКАД - 390 руб;</li>
            <li>За пределы МКАД - 500 руб.+ 30 рублей за каждый километр пути.</li>
        </ol>

        <b>Доставка по адресу крупногабаритных товаров:</b>
        <ol>
            <li>По Москве до линии МКАД - 590 рублей;</li>
            <li>За МКАД - 100 рублей + 30 руб/км;</li>
            <li>При сумме заказа от 50 000 рублей стоимость доставки по столице - бесплатно, а за пределы МКАД - 20 руб/км.</li>
        </ol>
        Товар доставляется до двери клиента, а стоимость разгрузки и подъёма оборудования не входит в общую сумму установленных услуг.
        <br>
        <a href="{{route('delivery')}}" class="viev_more">Подробнее о доставке</a>
    </div>
    <div>
        <b>Возврат</b>
        Замена или возврат торгового оборудования возможно осуществить в следующих случаях:
        <ol>
            <li>Производственный брак;</li>
            <li>Нарушение целостности упаковки и самого продукта по вине транспортной компании или продавца;</li>
            <li>Несоответствие характеристик и комплектации согласно описаний на сайте и прилагаемой документации;</li>
            <li>Отсутствие сертификатов и необходимых сопроводительных документов.</li>
        </ol>
        <br>
        <a href="{{route('delivery')}}" class="viev_more">Подробнее о возврате</a>
    </div>
</div>
    @widget('ViewGoodsWidget')
@endsection
