@extends('layouts.main')

@section('breadcrumbs')
	{!!  Breadcrumbs::render('page', $page) !!}
@endsection

@section('content')
	<div class="page-single">
		<h1 class="page-single_title">{{ $page->name }}</h1>
		<div class="wrap-typography">{!! $page->content !!}</div>
	</div>
@include('blocks.callback')
@endsection