<div class="main_sort">
    <a href="{{route('actions')}}" >
        <i class="fa fa-star-o" aria-hidden="true"></i>
        <span>Акции</span>
    </a>
    <a href="{{route('new')}}">
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
        <span>Новинки</span>
    </a>
    <a href="{{route('hits')}}">
        <i class="fa fa-volume-up" aria-hidden="true"></i>
        <span>Хиты продаж</span>
    </a>
</div>
<div class="product_slider_main">
    <div class="product_slider_content">
        @foreach($hit_goods as $product)
            <div class="slide you__viev slick-slide">
                <ul>
                    @include('catalog.products.list_item', ['product' => $product])
                </ul>
            </div>
        @endforeach
        @foreach($act_goods as $product)
            <div class="slide you__viev slick-slide">
                <ul>
                    @include('catalog.products.list_item', ['product' => $product])

                </ul>
            </div>
        @endforeach
        @foreach($new_goods as $product)
            <div class="slide you__viev slick-slide">
                <ul>
                    @include('catalog.products.list_item', ['product' => $product])
                </ul>
            </div>
        @endforeach
    </div>
</div>



