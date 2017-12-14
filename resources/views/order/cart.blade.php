@extends('layouts.inner')

@section('breadcrumbs')
    <ul class="bcrumbs">
        <li><b>Моя корзина</b></li>
    </ul>
@endsection

@section('content')
    @if($cart)

    <div class="content cart">
        <form action="{{ route('cart.edit') }}/" method="post">
            {{ csrf_field() }}
        <table class="table_basket">
            <thead>
            <tr>
                <td></td>
                <td>Название товара</td>
                <td>Кол-во</td>
                <td>Цена за шт.</td>
                <td>Общая цена</td>
            </tr>
            </thead>
            <tbody>
                @if($cart)
                        @foreach($cart['goods'] as $product)
                            <tr data-id="{{ $product->id }}" data-actiondel="{{ route('delete', $product->id) }}/">
                                <td>
                                    <div class="favorits defer-gds " data-id="{{ $product->id }}">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="table_basket_img">
                                        <img src="/{{ $product->getImgSmallPath() }}{{ $product->img }}">
                                    </div>
                                </td>

                                <td>
                                    <p>{{ $product->name }}</p>
                                    Артикул: <span>{{ $product->article }}</span>
                                </td>

                                <td>
                                    <input name="goods[{{ $product->id }}]" value="{{ $cart[$product->id]['cnt'] }}" min="1" data-price="{{ $product->price }}" type="number">
                                </td>

                                <td class="price" data-price="{{ $product->price }}">
                                    <b>{{ $product->price }} руб.</b>
                                </td>
                                
                                <td class="price-amount">
                                    <b>{{ $cart[$product->id]['cnt'] * $product->price }} руб.</b>
                                    <div class="del" data-id="{{ $product->id }}"></div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
      
            </tbody>
        </table>

        <div class="table_basket_footer">
            <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn_next">Продолжить покупки</a>
            Итоговая стоимость:
            <b>{{ $cart['amount'] }} руб.</b>
            <a href="{{ route('order') }}/" class="btn btn_table_basket">ОФОРМИТЬ ЗАКАЗ</a>
        </div>
        <div class="dop_info_basket">* Стоимость доставки и итоговую стоимость уточняйте у менеджера</div>
        </form>
             
    </div>

    @else
        <h2 style="color: darkred"> Корзина пуста</h2>
    @endif    
    

@endsection