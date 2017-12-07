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
				    @include('catalog.goods.filters_form')
				</section>
			</div>
			<div class="main-content-3 goods-2">
			    @include('catalog.goods.view_rows', ['goods' => $goods])
			    @include('catalog.goods.view_greed', ['goods' => $goods])
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