@extends('layouts.main')

@section('breadcrumbs')
	{!!  Breadcrumbs::render('articles') !!}
@endsection

@section('content')
    <h3>Все, что полезно знать о торговом оборудовании</h3>
    <div class="articles_main">
        @foreach($articles as $article)
        @include('articles.list_item', ['article' => $article])
        @endforeach
    </div>
    @include('vendor.pagination.default', ['paginator' => $articles])
    @include('blocks.callback')
@endsection