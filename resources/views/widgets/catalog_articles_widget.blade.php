<div @if($articles->count() > 1) id="article-slider-1" class="article-slider" @endif>
    @foreach($articles as $article)
    <div class="article-3 ef">
        <a class="link-block" href="{{route('article', $article->sysname)}}">
            @if($article->img)
            <div class="icon-wr a-c">
                <img src="/{{$article->getImgPreviewPath().$article->img}}" alt="{{$article->name}}"/>
            </div>
            @endif
            <div class="c">{{$article->name}}</div>
            <div class="d">{{$article->descr}}<br/>...</div>
        </a>
        <a class="more" href="{{route('article', $article->sysname)}}">Читать все</a>
    </div>
    @endforeach
</div>
@if($articles->count() > 1)
<div id="pages-slider-2" class="pages-slider-2">
    <div class="pages ef atr-1 ">
        @foreach($articles as $key => $article)
        <a @if($key==0) class="active" @endif>{{$key+1}}</a>
        @endforeach
    </div>
    <div class="pages-nav">
        <div class="prev btn m-6 ef ch-i tr-1 icon-wr a-c in-19 hv-11">
            <div class="icon sprite-icons n-left-btn-2-h"></div>
            <div class="icon sprite-icons n-left-btn-2"></div>
        </div>
        <div class="next btn m-6 ef ch-i tr-1 icon-wr a-c in-19 hv-11 mirror-x">
            <div class="icon sprite-icons n-left-btn-2-h"></div>
            <div class="icon sprite-icons n-left-btn-2"></div>
        </div>
    </div>
</div>
@endif