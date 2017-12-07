<ul class="level-{{$index >= 3 ? 3 : $index }}">
    @foreach($category->categories()->where('status', 1)->orderBy('sort')->get() as $category)
    <li>
        <a class="ef" href="{{route('catalog', $category->sysname)}}">
            <span>{{$category->name}}</span>
            @if($category->categories->count())
            <div class=" mark icon-wr a-c ech-i">
                <span class="icon sprite-icons n-marker-2-h"></span>
                <span class="icon sprite-icons n-marker-2"></span>
            </div>
            @endif
        </a>
        @if($category->categories->count())
            @include('widgets.catalog_widget_inner', ['category' => $category, 'index' => ($index+1)])
        @endif
    </li>
    @endforeach
</ul>