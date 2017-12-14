@extends('layouts.main')

@section('breadcrumbs')
    @php
        $root = null;
        if(isset($category)) $root = $category;
        if(isset($brand)) $root = $brand;
        if(isset($tag)) $root = $tag;
    @endphp
	{!!  Breadcrumbs::render('catalog', $root) !!}
@endsection

@section('content')
    @php
    $catalogTitle = 'Каталог';
    if(isset($category)) $catalogTitle = $category->name;
    if(isset($tag)) $catalogTitle = $tag->name;
    if(isset($brand)) $catalogTitle = 'Товары торговой марки "'.$brand->name.'"';
    @endphp
    <h1>{{ $catalogTitle }}</h1>
    @php
        $filtersParams = [
            'paginator' => $goods,
            'category'  => isset($category) ? $category : null,
            'brand'     => isset($brand) ? $brand : null,
            'tag'       => isset($tag) ? $tag : null,
            'minPrice'  => $goods->min_price,
            'maxPrice'  => $goods->max_price,
            'filters'   => isset($category) ? $category->filters : null,
            'sort' => 'good_category.sort',
            'goods' => $goods,
            'filters1' => ['category_id' => $category->id],
        ];
    @endphp
    @if($goods->count())
    @include('catalog.filters', $filtersParams)
    @include('catalog.products.grid', ['products' => $goods, 'banners' => isset($banners) ? $banners : null])
    @endif

    @if($goods->lastPage() > $goods->currentPage() )
    <div class="more goods-more" data-page="2">
        <a class="btn btn_white a_read_news">Показать больше</a>
    </div>
    @endif

    @if(isset($category) && !empty($category->text))
        <div class="seotxt wrp-typograph">
            {!! $category->text !!}
        </div>
    @endif
@endsection