@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('article', $article) !!}
@endsection

@section('content')
    <article class="article">
        <h3>{{ $article->name }}<span>{{ \App\Helpers\russianDate($article->created_at) }}</span></h3>
        <img src="/{{ $article->getImgPath() }}{{ $article->img }}" class="prew_article">
        {!! $article->text !!}
    </article>
    @if($relatedArticles)
        <h3 class="more_article">Еще статьи:</h3>
        <div class="articles_main">
            @foreach($relatedArticles as $article)
                @include('articles.list_item', ['article' => $article])
            @endforeach
        </div>

        @include('vendor.pagination.default', ['paginator' => $relatedArticles])
    @endif
    @include('blocks.callback')
@endsection