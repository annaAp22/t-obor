<div class="shop-reviews">
    <div class="wrap-block-title">
        <div class="block-title_text mod-icon-review">
            ОТЗЫВЫ КЛИЕНТОВ О НАС
        </div>
    </div>

    <div class="js-carousel owl-carousel" data-slide-count="2" data-dots="false" data-arrows="true" >
        @foreach($reviews as $review)
            <div class="shop-reviews_item">
                <span>{{ $review->name }}</span>
                <time>{{ $review->created_at }}</time>
                <div>{{ $review->message }}</div>
            </div>
        @endforeach
    </div>

    <div class="shop-reviews_bottom">
        <a href="#" class="add-review-button btn-blue-border" data-product-id="0" >Оставить свой отзыв</a>
        <a href="{{ route('reviews') }}" class="btn-ar-right">Читать все отзывы </a>
    </div>
</div>
