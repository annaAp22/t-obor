@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('new') !!}
@endsection

@section('content')
	<h1>Новинки</h1>
    @include('catalog.goods.view_greed', ['goods' => $goods])
@endsection