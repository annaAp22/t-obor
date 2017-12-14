<header>
	<div class="row-blk">
		<a class="logotype" href="/">
			<img src="/img/logotype.jpg">
		</a>
		<div class="hdr_form">
			<form class="main-header_search" method="POST" action="{{ route('search') }}">
				{{ csrf_field() }}
				<label>
					<i class="fa fa-search" aria-hidden="true"></i>
					<input type="text" name="text" id="autocomplite" placeholder="Поиск по сайту..." data-url="{{ route('goods.search') }}">
				</label>
			</form>
			<span>
				 <i class="fa fa-map-marker" aria-hidden="true"></i>
				{{ $global_settings['address']->value }}
				</span>
			<span>
					<a href="mailto:info@t-oborud.ru"><i class="fa fa-envelope" aria-hidden="true"></i> {{ $global_settings['email_support']->value }}</a>
				</span>
		</div>
		<div class="phones-blk">
			<tel>
				{!! $global_settings['phone_number']->value['1'] !!}
			</tel>
			{{ $global_settings['schedule']->value['start_workday'] }} - {{ $global_settings['schedule']->value['end_workday'] }} по Мск
			<tel>
				{!! $global_settings['phone_number']->value['2'] !!}
			</tel>
			Бесплатно по РФ
		</div>
		<div class="shopcr">
			<div class="cart">
				<a href="{{ route('cart') }}">
						<span>
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							<b>{{ count(session()->get('goods.cart')) }}</b>
						</span>
					Корзина
				</a>
			</div>
			<div class="bookmarks">
				<a href="{{ route('bookmarks') }}" class="main-header_block mod-bookmarks">
						<span>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<b>{{ count(session()->get('goods.defer')) }}</b>
						</span>
					Закладки
				</a>
			</div>
		</div>
	</div>
</header>
