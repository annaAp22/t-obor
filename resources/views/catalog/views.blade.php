@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('views') !!}
@endsection

@section('content')
    <h3>Недавно просмотренные</h3>
    @if($goods)
        <div class="main_gds_list you__viev">
            <ul>
            @foreach($goods as $key => $product)
                @include('catalog.products.list_item', ['product' => $product])
            @endforeach
            </ul>
        </div>
    @else
        <div class="catalog-items"><p>Вы не просматривали товары.</p></div>
    @endif
@endsection