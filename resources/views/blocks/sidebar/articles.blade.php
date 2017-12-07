<div class="useful_articles">
    <h3>Полезные статьи</h3>
    @foreach($articles as $article)
        <article>
            <div class="left">
                <a href="{{ route('article', $article->sysname) }}">
                    <img src="/{{ $article->getImgPath() }}{{ $article->img }}"  width="98px" height="98px" alt="">
                </a>
                {{ \App\Helpers\russianDate($article->created_at) }}
            </div>
            <div class="right">
                <b><a href="{{ route('article', $article->sysname) }}" >{{ $article->name }}</a></b>
                <p>
                    {{ $article->shortBody }}
                </p>
                <a href="{{ route('article', $article->sysname) }}" class="btn btn_white">Читать</a>
            </div>
        </article>
    @endforeach
    <a href="{{ route('articles') }}" class="viev_more">Смотреть все статьи</a>
</div>

