@extends('layouts.inner')

@section('breadcrumbs')
	{!!  Breadcrumbs::render('delivery') !!}
@endsection

@section('content')
	@php $deliveryPrice = $deliveries->count() ? $deliveries->first()->price : 0; @endphp
<div class="decor">
    <div class="left">
        <form action="{{ route('order.delivery') }}/" method="post" enctype="application/x-www-form-urlencoded">
            {{ csrf_field() }}

            
            <div class="main_input grey">
                                                <p>
                    Информация о покупателе
                    <span>*- обязательно для заполнения</span>
                </p>
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input name="name" value="{{ old('name') }}" placeholder="Ваше имя*" type="text">
                </label>
                <label>
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <input placeholder="Ваш телефон*" name="phone" class="phone-mask" value="{{ old('phone') }}" type="text">
                </label>
                <label>
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <input name="email" value="{{ old('email') }}" placeholder="Ваш @mail" type="email">
                </label>
                <label>
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <input name="index" value="" placeholder="Индекс" type="text">
                </label>
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <input name="city" value="" placeholder="Местоположение" type="text">
                </label>
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <input name="address" value="{{ old('address') }}" placeholder="Адрес доставки*" type="text">
                </label>
                <input type="hidden" name="payment_add">
            </div>

            @if($payments->count() || $deliveries->count())
            	@if($deliveries->count())
                <div class="grey type_delivery">
					<h3 class="points">
						<span>Выберите тип доставки</span>
						<span></span>
					</h3>
					<div class="select_types">
						@foreach($deliveries as $delivery)
                        <label>
							<div>
								<input name="delivery_id" value="{{ $delivery->id }}" checked="" data-price="{{ $delivery->price }}" type="radio">
								<span>
								<img src="/{{ $delivery->getImgPreviewPath() }}{{ $delivery->img }}">
								</span>
							</div>
							<div>
								<b>{{ $delivery->name }}</b>
								{{ $delivery->descr }}
							</div>
							<div>{{ $delivery->price }} руб.</div>
						</label>
                        @endforeach
					</div>
				</div> 
				@endif

				@if($payments->count())
				<div class="grey pay_type">
					<h3>
						<span>Выберите тип оплаты</span>
						<span></span>
					</h3>
					<div class="select_types">
						@foreach($payments as $payment)
                            <label>
								<div>
									<input class="" name="payment_id" value="{{ $payment->id }}" type="radio">
									<span><img src="/{{ $payment->getImgPreviewPath() }}{{ $payment->img }}" alt=""></span>
								</div>
								<div>
									<b>{{ $payment->name }}</b>
									{{ $payment->descr }}
								</div>
								<div> </div>
							</label>
                        @endforeach
						
						
					</div>
				</div>
                    
                @endif
             
			@endif

            <div class="rezult_summ points">
                <span>Итоговая стоимость с учетом доставки</span>
                <span></span>
                <span class="total">{{ $cart['amount'] + $deliveryPrice }} руб.</span>
            </div>
            <p class="grey_text">Нажимая на кнопку "оформить заказ", я подтверждаю свое согласие с <a href="#">"публичной офертой"</a></p>
            <input value="ПОДТВЕРДИТЬ ЗАКАЗ" class="btn btn_ord" type="submit">
            <p class="grey_text letter_spes">* Стоимость доставки и итоговую стоимость уточняйте у менеджера</p>
        </form>
    </div>

    <div class="right">
        <h3>Ваши покупки</h3>
		<table>
			<tbody>
				@foreach($cart['goods'] as $product)
                    <tr>
						<td>
							<div class="img">
								<img src="/{{ $product->getImgSmallPath() }}{{ $product->img }}">
							</div>
						</td>
						<td>
							<b>{{ $product->name }}</b>
							<span>Артикул:</span> {{ $product->article }}
							<div class="price">{{ $product->price }} руб.</div>
						</td>
						<td>
							<input value="{{ $cart[$product->id]['cnt'] }}" readonly="" type="text">
						</td>
					</tr>
                @endforeach
			</tbody>
		</table>

        <div class="price_main_info">
            <p class="points">
                <span>Общая стоимость:</span>
                <span></span>
                <span class="cart_amount" data-amount="{{ $cart['amount'] }}">{{ $cart['amount'] }} руб.</span>
            </p>
            <p class="points ">
                <span>Стоимость доставки:</span>
                <span></span>
                <span class="payment_cost">{{ $deliveryPrice }} руб.</span>
            </p>
        </div>
        <div class="itogo points">
            <span>Итого:</span>
            <span></span>
            <span class="total">{{ $cart['amount'] + $deliveryPrice }} руб.</span>
        </div>
        <p class="letter_spes grey_text">* Стоимость доставки и итоговую стоимость уточняйте у менеджера</p>
    </div>
</div>

@endsection