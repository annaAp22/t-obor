@extends('layouts.main')

@section('breadcrumbs')
<ul class="bread">
	<li><a href="{{ route('index') }}">Главная</a></li>
	<li>{{$brand->name}}</li>
</ul>
@endsection

@section('content')
<h1>{{$brand->name}}</h1>
@include('catalog.goods.view_greed', ['goods' => $goods])
<div class="seotext wrap-typography">
	{!! $brand->text !!}
</div>
@endsection