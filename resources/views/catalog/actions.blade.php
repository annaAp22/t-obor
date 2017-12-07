@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('actions') !!}
@endsection

@section('content')
	<h1>Акции</h1>
    @include('catalog.goods.view_greed', ['goods' => $goods])
@endsection