@foreach($news as $key => $newsRecord)
    <a href="{{ route('news.record', $newsRecord->sysname) }}">
        <span>{{ \App\Helpers\russianDate($newsRecord->created_at) }}</span>
        {{ $newsRecord->name }}
    </a>
@endforeach
