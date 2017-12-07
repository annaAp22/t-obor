<!-- вид: полная ширина -->
<div id="view-rows" class="view-rows" hidden>
    <div class="items-wr clr-m-b">
        @foreach($goods as $good)
            @include('catalog.goods.good_row', ['good' => $good])
        @endforeach
    </div>
    @if($goods->lastPage() > $goods->currentPage() )
    <div class="more goods-more" data-page="2">
        <a class="btn btn_white a_read_news">Показать больше</a>
    </div>
    @endif
</div>
