<div class="link_category">
    @foreach($categories as $category)
        <a href="{{ route('catalog', ['sysname' => $category->sysname]) }}">
        <span>
        <img src="{{ $category->getImgPath() }}{{ $category->img }}" >
        </span>
            {{ $category->name }}
        </a>
    @endforeach
</div>