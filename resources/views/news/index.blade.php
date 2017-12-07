@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('news') !!}
@endsection

@section('content')
    <h3>Новости</h3>
    <div class="news_list">
        @include('news.list')
    </div>

    <div class="page-navigation">
        @include('vendor.pagination.default', ['paginator' => $news])
    </div>
    @include('blocks.callback')
@endsection
