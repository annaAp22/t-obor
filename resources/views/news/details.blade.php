@extends('layouts.main')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('news.record', $newsRecord) !!}
@endsection

@section('content')
    <article class="article">
        <h3>{{ $newsRecord->name }}<span>{{ \App\Helpers\russianDate($newsRecord->created_at) }}</span></h3>
        {!! $newsRecord->body !!}
    </article>
    @include('blocks.callback')
@endsection
