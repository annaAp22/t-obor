<div class="main_slider">
    @foreach($banners as $banner)
        <div class="slide">
            <a href="{{ $banner->url }}">
                <img src="{{ $banner->getImgPath() }}{{ $banner->img }}">
            </a>
        </div>
    @endforeach
</div>
