<div class="main_product_list you_viev">
    <ul>
        @foreach($products as $key => $product)
            @include('catalog.products.list_item', ['product' => $product])
            @if(isset($banners))
                {{-- ROTATE BANNERS --}}
                @if(((($key + 1) % 12) == 0) && $banners->count())
                    @php
                        $banner = $banners->shift();
                        $banners->push($banner);
                    @endphp
                    <a class="banner-full-width" href="{{ $banner->url }}"><img src="/{{ $banner->getImgPath() }}{{ $banner->img }}"></a>
                @endif
            @endif
        @endforeach
    </ul>
</div>