@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('hits') !!}
@endsection

@section('content')
	<h1>Хиты продаж</h1>
    @include('catalog.goods.view_greed', ['goods' => $goods])
@endsection