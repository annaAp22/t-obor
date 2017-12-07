@if($goods->count())
    <div class="product-slider">
        <div class="wrap-block-title">
            <div class="block-title_text mod-icon-like">
                рекомендуем
            </div>

        </div>
        <div class="js-carousel owl-carousel" data-slide-count="3" data-dots="false" data-arrows="true">
            @foreach($goods as $good)
                @include('catalog.products.list_item', ['product' => $good])
            @endforeach
        </div>
    </div>
@endif