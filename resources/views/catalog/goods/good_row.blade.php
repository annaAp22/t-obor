<div class="g-item-2 allocate">
    <a class="wr-1 two-side" href="{{route('good', $good->sysname)}}">
        <div class="wr-1-1 ls">
            @if($good->discount)
                <div class="sale sale-1 sprite-icons n-cloud">
                    <div class="t-1">Скидка</div>
                    <div class="t-2">{{$good->discount}}%</div>
                </div>
            @endif
            @if($good->new || $good->act || $good->hit)
                <div class="top-wr">
                    @if($good->new) <div class="new">НОВИНКА</div> @endif
                    @if($good->act) <div class="act">АКЦИЯ!</div> @endif
                    @if($good->hit) <div class="hit">ХИТ ПРОДАЖ</div> @endif
                </div>
            @endif
            @if($good->img)
                <div class="img icon-wr a-c good-img">
                    <img src="/{{$good->getImgMainPath().$good->img}}" alt="{{$good->name}}"/>
                </div>
            @endif
        </div>&#10;
        <div class="wr-1-2 rs">
            <div class="c">{{$good->name}}</div>
            <div class="d">{{$good->descr}}</div>
            @if($good->price)
                <div class="price">{{number_format($good->price, 0, ',', ' ')}} руб.</div>
                @if($good->priceOld())
                    <strike>{{$good->priceOld()}}  руб.</strike>
                @endif
            @endif
        </div>&#10;
    </a>&#10;
    <div class="wr-3">
        <div class="wr-3-1 tb">
            <div class="tr">
                <div class="td-bl">
                    @if($good->stock)
                        <div class="t-5 child v-c">
                            <div class="sprite-icons n-mark-1"></div>&nbsp;&nbsp;
                            <span class="">В наличии</span>
                        </div>
                    @else
                        <div class="t-5 child v-c">
                            <div class="sprite-icons n-mark-3"></div>&nbsp;&nbsp;
                            <span class="">Под заказ</span>
                        </div>
                    @endif
                </div>
                @if($good->article)
                    <div class="td-bl">
                        <span class="t-5">Артикул:</span>&nbsp;
                        <span class="t-2">{{$good->article}}</span>
                    </div>
                @endif
            </div>
            <div class="tr">
                <div class="td-bl">
                    <span class="t-3">Доставка:&nbsp;</span>
                    <div class="t-4">1 -2 дня</div>
                </div>
                <div class="td-bl">
                    <!-- активировать, если добавлено-->
                    <div class="btn bm ef child v-c ch-i defer-good @if($good->isDefer())) active @endif" data-id="{{$good->id}}">
                        <div class="icon-wr ef">
                            <div class="icon ap sprite-icons n-defer-h etr-1"></div>
                            <div class="icon sprite-icons n-defer  etr-1"></div>
                        </div>
                        <div class="icon-wr">
                            <div class="sprite-icons n-defer-h"></div>
                        </div>
                        <span class="">&nbsp;&nbsp;Отложить</span>
                        <span class="">&nbsp;&nbsp;Добавлено</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn put icon-wr a-c ef hv-14 tr-1 cart-good"  data-id="{{$good->id}}" data-price="{{$good->price}}" @if($good->img) data-img="/{{$good->getImgMainPath().$good->img}}" @endif data-name="{{$good->name}}">
            <div class="sprite-icons n-basket-3"></div>
        </div>
        <div class="hint">
            <img src="/img/cloud.png" alt=""/>
            <div class="t">Положить товар в корзину!</div>
        </div>
        <div class="quick-buy btn m-10 ef hv-15 tr-1 aligner tc  cart-good-quick" data-id="{{$good->id}}" data-price="{{$good->price}}" @if($good->img) data-img="/{{$good->getImgMainPath().$good->img}}" @endif data-name="{{$good->name}}">
            <div class="c-c child v-c">
                <div class="icon-wr a-c ech-i">
                    <span class="icon sprite-icons n-plane-h etr-1"></span>
                    <span class="icon sprite-icons n-plane etr-1"></span>
                </div>&nbsp;&nbsp;
                <span class="">Купить быстро!</span>
            </div>
        </div>
    </div>&#10;
</div>