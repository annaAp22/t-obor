<div class=" sidebar_nav">
    <h3>Каталог товаров <i class="fa fa-angle-down" aria-hidden="true"></i></h3>
    <ul>
        @foreach($categories as $category)
        @if($category->hasChildren)
        <li>
            <a href="{{ route('catalog', $category->sysname) }}" >{{ $category->name }}</a>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            @if($category->categories->count())
            <div class="second_nav">
                @foreach($category->categories as $subcategory)
                <div class="nav_item">
                    <a href="{{ route('catalog', $subcategory->sysname) }}">{{ $subcategory->name }}</a>
                </div>
                @endforeach
            </div>
            @endif
        </li>
        @else
        <li>
            <a href="{{ route('catalog', $category->sysname) }}">{{ $category->name }}</a>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </li>
        @endif
        @endforeach
    </ul>
</div>
