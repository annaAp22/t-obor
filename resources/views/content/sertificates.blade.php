@extends('layouts.inner')

@section('content')

<div class="wrapper main-wrapper two-side">
		<aside class="ls">
            @widget('CatalogWidget')
			@widget('BannerLeftWidget')
			@widget('LinksStickerWidget')
		</aside>
		<div class="rs wrapper-2">
			<div class="main-content-5">
				<div class="to-prev-page">
					<div class="btn m-24 child v-c ef tr-1">
						<div class="sprite-icons n-back-3"></div>&nbsp;&nbsp;&nbsp;
						<span class=""><a style="text-decoration: none;" href="javascript:history.back()">Назад</a></span>
					</div>
				</div>
				<div class="bread-crumb child v-c">
					<div class="sprite-icons n-leaf"></div>
					<a href="{{route('index')}}">Главная</a>
					<a>{{ empty($page->vars->where('var', 'title')->first()) ? 'Сертификаты' : $page->vars->where('var', 'title')->first()->value }}</a>
				</div>
				<section id="sertificates" class="sertificates">
					<div class="allocate child v-b">
						<h1 class="total-c-10">{{ empty($page->vars->where('var', 'title')->first()) ? 'Сертификаты' : $page->vars->where('var', 'title')->first()->value }}</h1>&#10;
					</div>
					<div class="block-1">
						<div class="wr-1">
							<div class="c">{{ empty($page->vars->where('var', 'title_banner')->first()) ? 'Только сертифицированный товар по мировым стандартам' : $page->vars->where('var', 'title_banner')->first()->value }}</div>
							<p>{{ empty($page->vars->where('var', 'text_banner')->first()) ? 'Компания закупает только сертифицированный товар и только у официальных поставщиков' : $page->vars->where('var', 'text_banner')->first()->value }}</p>
							<img class="some-img" src="/img/sertificates.png" alt=""/>
						</div>
					</div>
					<div class="item-wr child-850-23-4 cmr">
						@foreach($sertificates as $photo)
						<a class="item img-wr a-c" href="/{{$photo->getImgPath().$photo->img}}" rel="gallery">
							<img src="/{{$photo->getImgPreviewPath().$photo->img}}" alt=""/>
						</a>
						@endforeach
					</div>
				</section>

				@widget('AlsoBuyWidget')
				@widget('SubscribeWidget')
			</div>
		</div>
	</div>

	@endsection