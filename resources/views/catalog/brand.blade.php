@extends('layouts.main')

@section('breadcrumbs')
<ul class="bcrumbs">
	<li><a href="{{ route('index') }}">Главная</a></li>
	<li>{{$brand->name}}</li>
</ul>
@endsection

@section('content')
<h1>{{$brand->name}}</h1>
@include('catalog.goods.view_greed', ['goods' => $goods])
<div class="seotxt wrp-typograph">
	{!! $brand->text !!}
</div>
@endsection