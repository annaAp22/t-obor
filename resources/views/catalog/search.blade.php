@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('search', $text) !!}
@endsection

@section('content')
    <div class="wrap-block-title">
        <div class="catalog-title">Результаты поиска</div>
        <div class="block-title_count">
            <span class="mod-bold mod-col-or">{{ $goods ? $goods->total() : 0 }}</span> {{ \App\Helpers\inflectByCount($goods ? $goods->total() : 0, ['one' => 'товар', 'many' => 'товара', 'others' => 'товаров']) }}
        </div>
    </div>

    <div class="catalog-items">
        @if($goods)
            @include('catalog.products.grid', ['products' => $goods, 'banners' => null])
        @else
            <p>Поиск не принес результатов. Попробуйте поискать что-нибудь другое.</p>
        @endif
    </div>

    @if($goods && $goods->lastPage() != $goods->currentPage())
    <div class="more goods-more" data-page="2">
        <a class="btn btn_white a_read_news">Показать ещё товары</a>
    </div>
    @endif

@endsection