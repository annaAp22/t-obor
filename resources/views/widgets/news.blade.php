@if($news && $news->count())
    <div class="news">
        <h3>Новости</h3>
        <div class="news__slider">
            @foreach($sidebar_news as $newsRecord)
            <div class="slide">
                <span>{{ App\Helpers\russianDate($newsRecord->created_at) }}</span>
                <a href="{{ route('news.record', $newsRecord->sysname) }}">
                    {{ $newsRecord->name }}
                </a>
            </div>
            @endforeach
        </div>
        <a href="{{ route('news') }}"  class="viev_more">Смотреть все новости</a>
    </div>
@endif



<!--
@if($news && $news->count())
<div class="news_list news_list_main">
    @foreach($news as $newsRecord)
    <a href="{{ route('news.record', $newsRecord->sysname) }}">
        <div class="news-list">
            <div class="news-img">
                <img src="/{{ $newsRecord->imagePreviewPath }}">
            </div>
            <div class="news-title">
                <p>{{ App\Helpers\russianDate($newsRecord->created_at) }}</p>
                <h4>{{ $newsRecord->name }}</h4>
            </div>
        </div>
    </a>
    @endforeach
</div>
<a href="{{ route('news') }}" class="btn btn_white a_read_news">Читать все новости</a>
@endif-->
