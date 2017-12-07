@extends('layouts.inner')

@section('content')

<div class="wrapper main-wrapper two-side">
    <aside class="ls">
        @widget('CatalogWidget')
		@if($good->categories->count())
        	@widget('CatalogArticlesWidget', ['category_id' => $good->categories->first()->id])
		@endif
        @widget('BannerLeftWidget')
        @widget('LinksStickerWidget')
    </aside>
    <div class="rs wrapper-2 main-content">
        <div class="bread-crumb child v-c">
            <div class="sprite-icons n-leaf"></div>
            <a href="{{route('index')}}">Главная</a>
			@if($good->categories->count())
				<a href="{{route('catalog', $good->categories->first()->sysname)}}">{{$good->categories->first()->name}}</a>
			@endif
            <a>{{$good->name}}</a>
        </div>
			<div class="card two-side clear-parent">
				<div class="ls">
					<div @if($good->photos->count()) id="card-slider" @endif class="card-slider slider">
						<div class="items-wr">
							@if($good->new) <div class="new">НОВИНКА</div> @endif
							@if($good->act) <div class="act">АКЦИЯ!</div> @endif
							@if($good->hit) <div class="hit">ХИТ ПРОДАЖ</div> @endif
							@if($good->discount)
							<div class="sale sale-1 sprite-icons n-cloud">
								<div class="t-1">Скидка</div>
								<div class="t-2">{{$good->discount}}%</div>
							</div>
							@endif
							<div class="items">
								@if($good->img)
								<a class="card-item img-wr a-c good-img" href="/{{$good->getImgPath().$good->img}}" rel="gallery">
									<img src="/{{$good->getImgSmallPath().$good->img}}" alt=""/>
								</a>
								@endif
								@foreach($good->photos as $photo)
								<a class="card-item img-wr a-c" href="/{{$photo->getImgPath().$photo->img}}" rel="gallery">
									<img src="/{{$photo->getImgSmallPath().$photo->img}}" alt=""/>
								</a>
								@endforeach
							</div>
						</div>
						<div class="preview all-left">
							@if($good->img)
							<div class="item icon-wr a-c active">
								<img src="/{{$good->getImgPreviewPath().$good->img}}" alt=""/>
							</div>
							@endif
							@foreach($good->photos as $photo)
								<div class="item icon-wr a-c">
									<img src="/{{$photo->getImgPreviewPath().$photo->img}}" alt=""/>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="rs">
					<div class="info">
						<div class="c">{{$good->name}}</div>
						<div class="tb">
							<div class="tr">
								<div class="td td-m">
									@if($good->stock)
										<div class="presence child v-c">
											<div class="sprite-icons n-mark-1"></div>&nbsp;&nbsp;
											<span class="">В наличии</span>
										</div>
									@else
										<div class="presence child v-c">
											<div class="sprite-icons n-mark-3"></div>&nbsp;&nbsp;
											<span class="">Под заказ</span>
										</div>
									@endif
								</div>
								@if($good->article)
								<div class="td td-m">
									<div class="art">Артикул:<strong>{{$good->article}}</strong></div>
								</div>
								@endif
							</div>
							<div class="tr">
								<div class="td td-t t-1"><strong>Доставка:</strong> 1 -2 дня<br/>По Москве - 500 р.</div>
								<div class="td td-t t-2">При заказе от 20.000 р.  доставка <strong>бесплатно!</strong></div>
							</div>
							<div class="tr">
								<div class="td td-t">
									<div class="t-3">Количество:</div>
									<div class="updown m-1 allocate child v-c ef">
										<div class="dec icon-wr a-c etr-1">
											<div class="icon sprite-icons n-dec"></div>
										</div>&#10;
										<input name="qnt" class="display" type="text" value="1" autocomplete="off" disabled/>&#10;
										<div class="inc icon-wr a-c etr-1">
											<div class="icon sprite-icons n-inc"></div>
										</div>&#10;
									</div>
								</div>
								@if($good->price)
								<div class="td td-t">
									<div class="t-3">Цена:</div>
									<div class="price">{{number_format($good->price, 0, ',', ' ')}} руб.</div>
									<strike>
									@if($good->priceOld())
										{{$good->priceOld()}}  руб.
									@endif
									</strike>
								</div>
								@endif
							</div>
							<div class="tr">
								<div class="td td-t">
									<div class="btn m-11 put ef tr-1 aligner tc cart-good-info"  data-id="{{$good->id}}" data-price="{{$good->price}}" @if($good->img) data-img="/{{$good->getImgMainPath().$good->img}}" @endif data-name="{{$good->name}}">
										<div class="c-c child v-c">
											<div class="sprite-icons n-basket-3"></div>&nbsp;
											<span class="t">В корзину</span>
										</div>
									</div>
								</div>
								<div class="td td-t">
									<div class="quick-buy btn m-12 ef tr-1 aligner tc ch-i-2 cart-good-quick" data-id="{{$good->id}}" data-price="{{$good->price}}" @if($good->img) data-img="/{{$good->getImgMainPath().$good->img}}" @endif data-name="{{$good->name}}">
										<div class="c-c child v-c">
											<div class="sprite-icons n-plane-2">
												<span class="icon sprite-icons n-plane-2-h etr-1"></span>
											</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="t">Купить <br>быстро!</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tr">
								<div class="td td-t">
									<div class="btn r-v child v-c ef ch-i-2">
										<div class="sprite-icons n-r-v">
											<div class="icon sprite-icons n-r-v-h etr-1"></div>
										</div>&nbsp;&nbsp;&nbsp;
										<a class="t t-4 etr-1 show-reviews" href="">Читать отзывы</a>
									</div>
								</div>
								<div class="td td-t">
									<div class="btn defer child v-c ef ch-i-2">
										<div class="sprite-icons n-defer">
											<div class="icon sprite-icons n-defer-h etr-1"></div>
										</div>&nbsp;&nbsp;&nbsp;
										<a class="t t-4 etr-1" href="">Отложить товар</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="warranty allocate child v-c">
						<div class="sprite-icons n-warranty"></div>
						<div class="wr">
							<div class="c">Фирменная гарантия</div>
							<div class="d">Компания закупает только сертифицированный товар и только у официальных поставщиков</div>
						</div>
					</div>
				</div>
			</div>
			<div id="tabulator-1" class="tabulator m-1">
				<label class="tab tab-1 active-one ef tr-1 active">Описание</label>
				<label id="reviews-tab" class="tab tab-1 active-one ef tr-1 child v-b">
					<span class="">Отзывы</span>
					@if($comments->count())
					<span class="count-1">{{$comments->count()}}</span>
					@endif
				</label>
				<label class="tab tab-1 active-one ef tr-1">Вы смотрели</label>
				<span class="clearfix"></span>
				<div class="pg g-description">
					{!! $good->text !!}
				</div>
				<div class="pg g-comments two-side">
                    @include('catalog.goods.comments', ['good' => $good])
				</div>
				<div class="pg g-views">
					@widget('ViewGoodsWidget', ['good_id' => $good->id])
				</div>
			</div>

			@include('catalog.goods.also_buy', ['good' => $good])
			@widget('SubscribeWidget')
			@include('catalog.goods.analogues', ['analogues' => $analogues])
		</div>
	</div>

@endsection