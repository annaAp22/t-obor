<ol class="dd-list">
    @foreach($cats as $cat)
    <li class="dd-item" data-id="{{$cat->id}}">
        <div class="dd-handle">
            @if($cat->icon)
                <img src="/{{$cat->getIconPath().$cat->icon}}" />
            @endif
            {{$cat->name}}
        </div>
        @if($cat->categories->count())
            @include('admin.categories.sort_inner', ['cats' => $cat->categories()->orderBy('sort')->get()])
        @endif
    </li>
    @endforeach
</ol>