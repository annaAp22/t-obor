<footer>
	<div class="row">
		<div class="left">
			<div class="footer_logo">
				<a href="index.htm">
					<img src="/img/logo_footer.png" >
				</a>
				<p>© 2017 <br> Торговое оборудование <br> для магазинов </p>
			</div>
			<div class="footer_nav">
				<a href="{{ route('about') }}">О магазине</a> <br>
				<a href="{{route('diler')}}">Дилерам</a> <br>
				<a href="{{ route('order_payment') }}">Заказ и Оплата</a> <br>
				<a href="{{ route('delivery') }}">Доставка и Возврат</a> <br>
				<a href="{{ route('news') }}">Новости</a> <br>
				<a href="{{ route('contacts') }}">Контакты</a>
			</div>
			<form class="main-footer_subscribe subscribe" method="POST" action="{{ route('subscribe') }}" id="subscribe-form">
				<i class="fa fa-envelope" aria-hidden="true"></i>
				<input type="email" name="email" placeholder="Ваш адрес @mail">
				<input type="submit" class="btn" value="ПОЛУЧАТЬ НОВОСТИ">
				<div class="message" style="margin-left: 68px; margin-top: 10px; display:none;">
					<b>СПАСИБО!</b>
					Вы успешно подписаны на рассылку.
				</div>
			</form>
		</div>
		<div class="right">
			<b>Адрес:</b>

			{{ $global_settings['address']->value }}

			<b>Электронная почта:</b>
			{{ $global_settings['email_support']->value }}

			<b>Телефон:</b>
            {!! $global_settings['phone_number']->value['1'] !!}<br>
            {!! $global_settings['phone_number']->value['2'] !!}<br>
            {!! $global_settings['phone_number']->value['3'] !!} (Viber, WhatsApp)

			<b>Режим работы:</b>

			пн.-пт.: {{ $global_settings['schedule']->value['start_workday'] }}-{{ $global_settings['schedule']->value['end_workday'] }},
			<br> сб.: {{ $global_settings['schedule']->value['start_weekend'] }}-{{ $global_settings['schedule']->value['end_weekend'] }}<br> вс: выходной день
		</div>
	</div>
</footer>
<div class="shadow" style="display: none;"></div>


