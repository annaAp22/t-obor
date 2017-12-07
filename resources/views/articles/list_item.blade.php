<article>
    <a href="{{ route('article', $article->sysname) }}"  class="articles_img">
        <img src="/{{ $article->getImgPath() }}{{ $article->img }}" >
    </a>
    <div class="right">
        <span>{{ \App\Helpers\russianDate($article->created_at) }}</span>
        <div class="name">{{ $article->name }}</div>
        <p>{{ $article->descr }}</p>
        <a href="{{ route('article', $article->sysname) }}" class="btn btn_white">Читать</a>
    </div>
</article>