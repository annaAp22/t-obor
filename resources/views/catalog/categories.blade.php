@extends('layouts.main')

@section('breadcrumbs')
    @if($category == 'root')
        {!!  Breadcrumbs::render('catalogRoot') !!}
    @else
        {!!  Breadcrumbs::render('catalog', $category) !!}
    @endif
@endsection

@section('content')
    <h1>{{ $category == 'root' ? 'Каталог' : $category->name }}</h1>
    <div class="subcategory">
        @php
            $catList = $category == 'root' ? $categories : $category->categories;
        @endphp
    </div>
    <div class="page_list_nav">
        @foreach($catList as $subcategory)
            <a href="{{ route('catalog', $subcategory->sysname) }}">
                <img src="/{{ $subcategory->getImgPreviewPath() }}{{ $subcategory->img }}" class="catalog_img">
                {{ $subcategory->name }}
            </a>
        @endforeach
    </div>

    @if(!$category == 'root')
        <div class="seotxt wrp-typograph">
            {!! $category->text !!}
        </div>
    @endif
@endsection