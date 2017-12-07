@extends('layouts.inner')

@section('breadcrumbs')
	{!!  Breadcrumbs::render('confirmation') !!}
@endsection

@section('content')
	<div class="message_success">
		<div class="title">СПАСИБО</div>
		<b>Ваш заказ принят</b>
		Номер Вашего заказа: <span>{{ $order_id }}</span>
		<a href="{{ route('index') }}" class="btn btn_white">На главную</a>
	</div>
@endsection