<div class="js-tabs-item product-tabs_body_item" style="display: none">
    @if($reviews->count())
        @foreach($reviews as $review)
            <div class="product-review">
                <div class="product-review_data">
                    <div>{{ $review->name }}</div>
                    <time>{{ $review->date }}</time>
                </div>
                <div class="product-review_text">
                    <p class="mod-bold">Текст отзыва</p>
                    <p>{{ $review->text }}</p>
                    @if($review->pros)
                        <div class="product-review_text_benefits">
                            <p class="mod-bold mod-col-blue">Достоинства товара</p>
                            <p>{{$review->pros}}</p>
                        </div>
                    @endif
                    @if($review->cons)
                        <div class="product-review_text_limitations">
                            <p class="mod-bold mod-col-red">Недостатки</p>
                            <p>{{$review->cons}}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="page-navigation">
            <a href="#" class="page-navigation_prev"></a>
            <a href="#" class="page-navigation_num">1</a>|
            <span class="page-navigation_num">2</span>|
            <a href="#" class="page-navigation_num">3</a>|
            <a href="#" class="page-navigation_num">4</a>|
            <a href="#" class="page-navigation_num">5</a>
            <a href="#" class="page-navigation_next"></a>
            <button class="add-review-button btn-orange" data-product-id="{{ $product_id }}">ОСТАВИТЬ СВОЙ ОТЗЫВ</button>
        </div>
    @else
        <div class="no-reviews"><p>Никто пока еще не написал отзывов на этот товар. Станьте первым!</p></div>
        <div class="page-navigation">
            <button class="add-review-button btn-orange" data-product-id="{{ $product_id }}">ОСТАВИТЬ СВОЙ ОТЗЫВ</button>
        </div>
    @endif
</div>
