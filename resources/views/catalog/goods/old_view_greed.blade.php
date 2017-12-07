<!-- вид:сетка -->
<div id="view-greed" class="">
    <div class="items-wr child-max-20-3 cmr">
        @foreach($goods->take(12) as $good)
            @include('catalog.goods.good_greed', ['good' => $good])
        @endforeach
    </div>
    @if($goods->count() > 12)
    <div class="big-roll">
        <div class="items-wr child-max-20-3 cmr">
            @foreach($goods->slice(12) as $good)
                @include('catalog.goods.good_greed', ['good' => $good])
            @endforeach
        </div>
    </div>
    <div class="more btn m-21 r ef tr-1 roll-up-down">
        <div class="before child v-c">
            <span class="etr-1">Показать больше</span>&nbsp;&nbsp;
            <div class="sprite-icons n-btn-5"></div>
        </div>
        <div class="after child v-c">
            <span class="etr-1">Показать меньше</span>&nbsp;&nbsp;
            <div class="sprite-icons n-btn-5 mirror-y"></div>
        </div>
    </div>
    @endif
</div>