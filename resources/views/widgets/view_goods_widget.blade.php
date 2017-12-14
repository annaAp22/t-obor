@if($goods->count())
<br>
<div class="you__viev">
    <h3>
        <i class="fa fa-eye" aria-hidden="true"></i>
        Вы просматривали
    </h3>
    <div class="product_slider_main">
        <div class="product_slider_content">
            @foreach($goods as $product)
            <div class="slide you__viev slick-slide">
                <ul>
                    @include('catalog.products.list_item', ['product' => $product])
                </ul>
            </div>
            @endforeach
        </div>
    </div>

    <a href="{{route('views')}}" class="viev_all">Смотреть все<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
</div>
@endif


