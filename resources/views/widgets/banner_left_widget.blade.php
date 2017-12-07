@foreach($banners as $banner)
<a class="banner" href="{{$banner->url}}" @if($banner->blank) target="_blank" @endif>
    <img src="/{{$banner->getImgPreviewPath().$banner->img}}" alt="">
</a>
@endforeach