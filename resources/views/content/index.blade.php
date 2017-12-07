@extends('layouts.main')

@section('content')
    @include('blocks.main_slider', ['banners' => $banners])
    @include('blocks.products_slider')
    @include('blocks.our_production', ['categories' => $categories])
    <div class="news_list news_list_main">
        @include('news.list', ['news' => $news])
    </div>
    <a href="{{ route('news') }}" class="btn btn_white a_read_news">Читать все новости</a>
    @include('blocks.callback')
@endsection
