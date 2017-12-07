@extends('layouts.inner')

@section('content')

<div class="wrapper main-wrapper two-side">
		<aside class="ls">
            @widget('CatalogWidget')
			@widget('TagsWidget')
			@widget('CatalogArticlesWidget', ['category_id' => $category->id])
			@widget('BannerLeftWidget')
			@widget('LinksStickerWidget')
		</aside>
		<div class="rs wrapper-2">
			<div class="main-content-2">
				<div class="bread-crumb child v-c">
					<div class="sprite-icons n-leaf"></div>
					<a href="{{route('index')}}">Главная</a>
					@if($category->parent()->count())
						<a href="{{route('catalog', $category->parent->sysname)}}">{{$category->parent->name}}</a>
					@endif
					<a>{{$category->name}}</a>
				</div>
				<section class="listing">
					<div class="allocate child v-b">
						<h1 class="total-c-10">{{$category->name}}</h1>&#10;
						<div class="g-count-1">
							<strong>{{$goods->count()}}</strong>&nbsp;&nbsp; {{Lang::choice('товар|товара|товаров', $goods->count(), [], 'ru')}}
						</div>&#10;
					</div>
					<div class="filters">
						<div class="c"><strong>Фильтры</strong> подбора товаров:</div>
						<div class="wr-2">
							<div class="block-1">
								<div class="wr-1 allocate child v-bt">
									<div class="range-scroll-info">
										<span class="t-1">Цены:</span>
										<span class="t-2">от</span>&nbsp;&nbsp;
										<input class="r" id="min-val-1" name="begin" type="text">&nbsp;&nbsp;
										<span class="t-2">до</span>&nbsp;&nbsp;
										<input class="r" id="max-val-1" name="end" type="text">
									</div>&#10;
									<div class="range-scroll-wr">
										<div id="minPrice" class="l-label">0 р.</div>
										<div id="maxPrice" class="r-label">100 000 р.</div>
										<div id="range-scroll" class="range-scroll"></div>
									</div>&#10;
								</div>
							</div>
							<div class="big-roll ef h-tr-1">
								<div class="block-1">
									<div class="wr-1 child v-bt">
										<div class="range-scroll-info">
											<span class="t-1">Какой-то фильтр:</span>
											<span class="t-2">подпись</span>&nbsp;&nbsp;
											<input class="r" name="undefined" type="text" value="значение">
										</div>
									</div>
								</div>
							</div>
							<div class="more btn m-23 ef tr-1 ch-h-i roll-up-down">
								<div class="before child v-c">
									<span class="">Показать ещё фильтры</span>&nbsp;&nbsp;&nbsp;
									<div class="icon-wr">
										<div class="icon ap sprite-icons n-btn-4 etr-1"></div>
										<div class="icon sprite-icons n-btn-3 etr-1"></div>
									</div>
								</div>
								<div class="after child v-c">
									<span class="">Меньше фильтров</span>&nbsp;&nbsp;&nbsp;
									<div class="icon-wr mirror-y">
										<div class="icon ap sprite-icons n-btn-4 etr-1"></div>
										<div class="icon sprite-icons n-btn-3 etr-1"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="block-2 allocate child v-c">
						<div class="sort child v-b">
							<div class="c">Сортировать товары:</div>&#10;
							<button class="btn m-20 r ef tr-1">Дороже</button>&#10;
							<button class="btn m-20 r ef tr-1">Дешевле</button>&#10;
							<button class="btn m-20 r ef tr-1">Хиты продаж</button>&#10;
							<button class="btn m-20 r ef tr-1">Акции</button>&#10;
						</div>&#10;
						<div class="view child v-c">
							<div class="c">Вид:</div>
							<div id="show-greed" class="btn sprite-icons n-view-greed ef ch-i-3 active-one active">
								<div class="icon sprite-icons n-view-greed-a etr-1"></div>
							</div>
							<div id="show-rows" class="btn sprite-icons n-view-rows ef ch-i-3 active-one">
								<div class="icon sprite-icons n-view-rows-h etr-1"></div>
							</div>
						</div>&#10;
					</div>
				</section>
			</div>
			<div class="main-content-3 goods-2">
				<!-- вид: полная ширина -->
				<div id="view-rows" class="view-rows" hidden>
					<div class="items-wr clr-m-b">
						@foreach($goods->take(8) as $good)
						<div class="g-item-2 allocate">
							<a class="wr-1 two-side" href="{{route('good', $good->sysname)}}">
								<div class="wr-1-1 ls">
									@if($good->discount)
									<div class="sale sale-1 sprite-icons n-cloud">
										<div class="t-1">Скидка</div>
										<div class="t-2">{{$good->discount}}%</div>
									</div>
									@endif
									@if($good->new || $good->act || $good->hit)
									<div class="top-wr">
										@if($good->new) <div class="new">НОВИНКА</div> @endif
										@if($good->act) <div class="act">АКЦИЯ!</div> @endif
										@if($good->hit) <div class="hit">ХИТ ПРОДАЖ</div> @endif
									</div>
									@endif
									@if($good->img)
									<div class="img icon-wr a-c">
										<img src="/{{$good->getImgMainPath().$good->img}}" alt="{{$good->name}}"/>
									</div>
									@endif
								</div>&#10;
								<div class="wr-1-2 rs">
									<div class="c">{{$good->name}}</div>
									<div class="d">{{$good->descr}}</div>
									@if($good->price)
									<div class="price">{{number_format($good->price, 0, ',', ' ')}} руб.</div>
									@endif
								</div>&#10;
							</a>&#10;
							<div class="wr-3">
								<div class="wr-3-1 tb">
									<div class="tr">
										<div class="td-bl">
											@if($good->stock)
											<div class="t-5 child v-c">
												<div class="sprite-icons n-mark-1"></div>&nbsp;&nbsp;
												<span class="">В наличии</span>
											</div>
											@else
											<div class="t-5 child v-c">
												<div class="sprite-icons n-mark-3"></div>&nbsp;&nbsp;
												<span class="">Под заказ</span>
											</div>
											@endif
										</div>
										@if($good->article)
										<div class="td-bl">
											<span class="t-5">Артикул:</span>&nbsp;
											<span class="t-2">{{$good->article}}</span>
										</div>
										@endif
									</div>
									<div class="tr">
										<div class="td-bl">
											<span class="t-3">Доставка:&nbsp;</span>
											<div class="t-4">1 -2 дня</div>
										</div>
										<div class="td-bl">
											<!-- активировать, если добавлено-->
											<div class="btn bm ef child v-c ch-i">
												<div class="icon-wr ef">
													<div class="icon ap sprite-icons n-defer-h etr-1"></div>
													<div class="icon sprite-icons n-defer  etr-1"></div>
												</div>
												<div class="icon-wr">
													<div class="sprite-icons n-defer-h"></div>
												</div>
												<span class="">&nbsp;&nbsp;Отложить</span>
												<span class="">&nbsp;&nbsp;Добавлено</span>
											</div>
										</div>
									</div>
								</div>
								<div class="btn put icon-wr a-c ef hv-14 tr-1">
									<div class="sprite-icons n-basket-3"></div>
								</div>
								<div class="hint">
									<img src="/img/cloud.png" alt=""/>
									<div class="t">Положить товар в корзину!</div>
								</div>
								<div class="quick-buy btn m-10 ef hv-15 tr-1 aligner tc">
									<div class="c-c child v-c">
										<div class="icon-wr a-c ech-i">
											<span class="icon sprite-icons n-plane-h etr-1"></span>
											<span class="icon sprite-icons n-plane etr-1"></span>
										</div>&nbsp;&nbsp;
										<span class="">Купить быстро!</span>
									</div>
								</div>
							</div>&#10;
						</div>
						@endforeach
					</div>
					@if($goods->count() > 8)
					<div class="big-roll">
						<div class="items-wr clr-m-b">
							@foreach($goods->slice(8) as $good)
								<div class="g-item-2 allocate">
									<a class="wr-1 two-side" href="{{route('good', $good->sysname)}}">
										<div class="wr-1-1 ls">
											@if($good->discount)
												<div class="sale sale-1 sprite-icons n-cloud">
													<div class="t-1">Скидка</div>
													<div class="t-2">{{$good->discount}}%</div>
												</div>
											@endif
											@if($good->new || $good->act || $good->hit)
												<div class="top-wr">
													@if($good->new) <div class="new">НОВИНКА</div> @endif
													@if($good->act) <div class="act">АКЦИЯ!</div> @endif
													@if($good->hit) <div class="hit">ХИТ ПРОДАЖ</div> @endif
												</div>
											@endif
											@if($good->img)
												<div class="img icon-wr a-c">
													<img src="/{{$good->getImgMainPath().$good->img}}" alt="{{$good->name}}"/>
												</div>
											@endif
										</div>&#10;
										<div class="wr-1-2 rs">
											<div class="c">{{$good->name}}</div>
											<div class="d">{{$good->descr}}</div>
											@if($good->price)
												<div class="price">{{number_format($good->price, 0, ',', ' ')}} руб.</div>
											@endif
										</div>&#10;
									</a>&#10;
									<div class="wr-3">
										<div class="wr-3-1 tb">
											<div class="tr">
												<div class="td-bl">
													@if($good->stock)
														<div class="t-5 child v-c">
															<div class="sprite-icons n-mark-1"></div>&nbsp;&nbsp;
															<span class="">В наличии</span>
														</div>
													@else
														<div class="t-5 child v-c">
															<div class="sprite-icons n-mark-3"></div>&nbsp;&nbsp;
															<span class="">Под заказ</span>
														</div>
													@endif
												</div>
												@if($good->article)
													<div class="td-bl">
														<span class="t-5">Артикул:</span>&nbsp;
														<span class="t-2">{{$good->article}}</span>
													</div>
												@endif
											</div>
											<div class="tr">
												<div class="td-bl">
													<span class="t-3">Доставка:&nbsp;</span>
													<div class="t-4">1 -2 дня</div>
												</div>
												<div class="td-bl">
													<!-- активировать, если добавлено-->
													<div class="btn bm ef child v-c ch-i">
														<div class="icon-wr ef">
															<div class="icon ap sprite-icons n-defer-h etr-1"></div>
															<div class="icon sprite-icons n-defer  etr-1"></div>
														</div>
														<div class="icon-wr">
															<div class="sprite-icons n-defer-h"></div>
														</div>
														<span class="">&nbsp;&nbsp;Отложить</span>
														<span class="">&nbsp;&nbsp;Добавлено</span>
													</div>
												</div>
											</div>
										</div>
										<div class="btn put icon-wr a-c ef hv-14 tr-1">
											<div class="sprite-icons n-basket-3"></div>
										</div>
										<div class="hint">
											<img src="/img/cloud.png" alt=""/>
											<div class="t">Положить товар в корзину!</div>
										</div>
										<div class="quick-buy btn m-10 ef hv-15 tr-1 aligner tc">
											<div class="c-c child v-c">
												<div class="icon-wr a-c ech-i">
													<span class="icon sprite-icons n-plane-h etr-1"></span>
													<span class="icon sprite-icons n-plane etr-1"></span>
												</div>&nbsp;&nbsp;
												<span class="">Купить быстро!</span>
											</div>
										</div>
									</div>&#10;
								</div>
							@endforeach
						</div>
					</div>
					<div class="more btn m-21 r ef tr-1 roll-up-down">
						<div class="before child v-c">
							<span class="etr-1">Показать больше</span>&nbsp;&nbsp;
							<div class="sprite-icons n-btn-5"></div>
						</div>
						<div class="after child v-c">
							<span class="etr-1">Показать меньше</span>&nbsp;&nbsp;
							<div class="sprite-icons n-btn-5 mirror-y"></div>
						</div>
					</div>
					@endif
				</div>
				<!-- вид:сетка -->
				<div id="view-greed" class="">
					<div class="items-wr child-max-20-3 cmr">
						@foreach($goods->take(12) as $good)
						<div class="g-item">
							<a class="wr-1" href="{{route('good', $good->sysname)}}">
								<div class="c">{{$good->name}}</div>
								@if($good->discount)
									<div class="sale sale-1 sprite-icons n-cloud">
										<div class="t-1">Скидка</div>
										<div class="t-2">{{$good->discount}}%</div>
									</div>
								@endif
								@if($good->new || $good->act || $good->hit)
									<div class="top-wr">
										@if($good->new) <div class="new">НОВИНКА</div> @endif
										@if($good->act) <div class="act">АКЦИЯ!</div> @endif
										@if($good->hit) <div class="hit">ХИТ ПРОДАЖ</div> @endif
									</div>
								@endif
								@if($good->img)
									<div class="img icon-wr a-c">
										<img src="/{{$good->getImgMainPath().$good->img}}" alt="{{$good->name}}"/>
									</div>
								@endif
							</a>
							<div class="allocate">
								<div class="">
									@if($good->stock)
										<div class="t-1 child v-c">
											<div class="sprite-icons n-mark-1"></div>&nbsp;&nbsp;
											<span class="">В наличии</span>
										</div>
									@else
										<div class="t-1 child v-c">
											<div class="sprite-icons n-mark-3"></div>&nbsp;&nbsp;
											<span class="">Под заказ</span>
										</div>
									@endif
									<span class="t-3">Доставка:&nbsp;</span>
									<span class="t-4">1 -2 дня</span>
								</div>
								@if($good->article)
									<div class="">
										<span class="t-1">Артикул:</span>&nbsp;
										<span class="t-2">{{$good->article}}</span>
									</div>
								@endif
							</div>
							@if($good->price)
								<div class="price">{{number_format($good->price, 0, ',', ' ')}} руб.</div>
							@endif
							<div class="btn put icon-wr a-c ef hv-14 tr-1">
								<div class="sprite-icons n-basket-3"></div>
							</div>
							<div class="hint">
								<img src="/img/cloud.png" alt=""/>
								<div class="t">Положить товар в корзину!</div>
							</div>
							<div class="quick-buy btn m-10 ef hv-15 tr-1 aligner tc">
								<div class="c-c child v-c">
									<div class="icon-wr a-c ech-i">
										<span class="icon sprite-icons n-plane-2-h etr-1"></span>
										<span class="icon sprite-icons n-plane-2 etr-1"></span>
									</div>&nbsp;
									<span class="">Купить <br>быстро!</span>
								</div>
							</div>
							<div class="clearfix"></div>
							<!-- активировать, если добавлено-->
							<div class="btn bm ef">
								<div class="icon-wr a-c-t ef ch-i">
									<div class="icon sprite-icons n-defer-h etr-1"></div>
									<div class="icon sprite-icons n-defer  etr-1"></div>
								</div>
								<div class="icon-wr a-c-t">
									<div class="icon sprite-icons n-defer-h"></div>
								</div>
								<span class="">Отложить</span>
								<span class="">Добавлено</span>
							</div>
							<div class="clearfix"></div>
							@if($good->descr)
							<div class="d ef etr-1"><div class="cut">{{$good->descr}}</div></div>
							@endif
						</div>
						@endforeach
					</div>
					@if($goods->count() > 12)
					<div class="big-roll">
						<div class="items-wr child-max-20-3 cmr">
							@foreach($goods->slice(12) as $good)
								<div class="g-item">
									<a class="wr-1" href="{{route('good', $good->sysname)}}">
										<div class="c">{{$good->name}}</div>
										@if($good->discount)
											<div class="sale sale-1 sprite-icons n-cloud">
												<div class="t-1">Скидка</div>
												<div class="t-2">{{$good->discount}}%</div>
											</div>
										@endif
										@if($good->new || $good->act || $good->hit)
											<div class="top-wr">
												@if($good->new) <div class="new">НОВИНКА</div> @endif
												@if($good->act) <div class="act">АКЦИЯ!</div> @endif
												@if($good->hit) <div class="hit">ХИТ ПРОДАЖ</div> @endif
											</div>
										@endif
										@if($good->img)
											<div class="img icon-wr a-c">
												<img src="/{{$good->getImgMainPath().$good->img}}" alt="{{$good->name}}"/>
											</div>
										@endif
									</a>
									<div class="allocate">
										<div class="">
											@if($good->stock)
												<div class="t-1 child v-c">
													<div class="sprite-icons n-mark-1"></div>&nbsp;&nbsp;
													<span class="">В наличии</span>
												</div>
											@else
												<div class="t-1 child v-c">
													<div class="sprite-icons n-mark-3"></div>&nbsp;&nbsp;
													<span class="">Под заказ</span>
												</div>
											@endif
											<span class="t-3">Доставка:&nbsp;</span>
											<span class="t-4">1 -2 дня</span>
										</div>
										@if($good->article)
											<div class="">
												<span class="t-1">Артикул:</span>&nbsp;
												<span class="t-2">{{$good->article}}</span>
											</div>
										@endif
									</div>
									@if($good->price)
										<div class="price">{{number_format($good->price, 0, ',', ' ')}} руб.</div>
									@endif
									<div class="btn put icon-wr a-c ef hv-14 tr-1">
										<div class="sprite-icons n-basket-3"></div>
									</div>
									<div class="hint">
										<img src="/img/cloud.png" alt=""/>
										<div class="t">Положить товар в корзину!</div>
									</div>
									<div class="quick-buy btn m-10 ef hv-15 tr-1 aligner tc">
										<div class="c-c child v-c">
											<div class="icon-wr a-c ech-i">
												<span class="icon sprite-icons n-plane-2-h etr-1"></span>
												<span class="icon sprite-icons n-plane-2 etr-1"></span>
											</div>&nbsp;
											<span class="">Купить <br>быстро!</span>
										</div>
									</div>
									<div class="clearfix"></div>
									<!-- активировать, если добавлено-->
									<div class="btn bm ef">
										<div class="icon-wr a-c-t ef ch-i">
											<div class="icon sprite-icons n-defer-h etr-1"></div>
											<div class="icon sprite-icons n-defer  etr-1"></div>
										</div>
										<div class="icon-wr a-c-t">
											<div class="icon sprite-icons n-defer-h"></div>
										</div>
										<span class="">Отложить</span>
										<span class="">Добавлено</span>
									</div>
									<div class="clearfix"></div>
									@if($good->descr)
										<div class="d ef etr-1"><div class="cut">{{$good->descr}}</div></div>
									@endif
								</div>
							@endforeach
						</div>
					</div>
					<div class="more btn m-21 r ef tr-1 roll-up-down">
						<div class="before child v-c">
							<span class="etr-1">Показать больше</span>&nbsp;&nbsp;
							<div class="sprite-icons n-btn-5"></div>
						</div>
						<div class="after child v-c">
							<span class="etr-1">Показать меньше</span>&nbsp;&nbsp;
							<div class="sprite-icons n-btn-5 mirror-y"></div>
						</div>
					</div>
					@endif
				</div>
			</div>
			@widget('SubscribeDiscountWidget')
		</div>
	</div>
	<div class="wrapper main-content-4 two-side">
		<div class="description ls">
			{!! $category->text !!}
		</div>
	</div>
	@widget('SubscribeWidget', ['class' => 'wrapper', 'form_index' => '', 'caption_class' => 'caption-2', 'total_class' => 'total-c-4', 'total_icon_right' => true])
@endsection