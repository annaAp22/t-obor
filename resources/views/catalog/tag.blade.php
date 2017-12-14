@extends('layouts.main')

@section('breadcrumbs')
<ul class="bcrumbs">
    <li><a href="{{ route('index') }}">Главная</a></li>
    <li>{{$tag->name}}</li>
</ul>
@endsection

@section('content')
<h1>{{$tag->name}}</h1>
@include('catalog.goods.view_greed', ['goods' => $goods])
<div class="seotxt wrp-typograph">
    {!! $tag->text !!}
</div>
@endsection