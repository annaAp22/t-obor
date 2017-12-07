<aside class="left-sidebar">
    @widget('CatalogWidget')

    @if(isset($category) && $category != 'root')
        @widget('TagsWidget', ['category_id' => $category->id])
    @elseif(isset($category) && $category == 'root')
        @widget('TagsWidget', ['category_id' => 0])
    @endif
    <div class="special">
        @foreach($banner_left as $banner)
            <a href="{{ $banner->url }}">
                <img src="/{{ $banner->getImgPath() }}{{ $banner->img }}" @if($banner->blank) target="_blank" @endif />
            </a>
        @endforeach
    </div>
    @include('blocks.sidebar.articles', ['articles' => $sidebar_articles])
    @widget('News')
</aside>
