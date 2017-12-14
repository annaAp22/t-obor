@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('bookmarks') !!}
@endsection

@section('content')
    @if($goods)
        <h3>Закладки</h3>
        <div class="main_gds_list you__viev">
            <ul>
            @foreach($goods as $key => $product)
                @include('catalog.products.list_item', ['product' => $product])
            @endforeach
            </ul>
        </div>
    @else
        <div class="catalog-items"><p>Вы не добавляли товары в закладки.</p></div>
    @endif
@endsection