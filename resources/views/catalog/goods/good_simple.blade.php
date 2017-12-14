<div class="{{ !empty($class_item) ? $class_item : 'g-item' }}">
    <a class="wr-2" href="{{route('good', $good->sysname)}}"><div class="c">{{$good->name}}</div>
        @if($good->img)
        <div class="img icon-wr a-c good-img">
            <img src="/{{$good->getImgMainPath().$good->img}}" alt="{{$good->name}}"/>
        </div>
        @endif
    </a>
    <div class="price">{{number_format($good->price, 0, ',', ' ')}} руб.</div>
    <div class="btn put icon-wr a-c ef hv-14 tr-1 js-cart-gds"  data-id="{{$good->id}}" data-price="{{$good->price}}" @if($good->img) data-img="/{{$good->getImgMainPath().$good->img}}" @endif data-name="{{$good->name}}">
        <div class="sprite-icons n-basket-3"></div>
    </div>
    <div class="hint">
        <img src="/img/cloud.png" alt=""/>
        <div class="t">Положить товар в корзину!</div>
    </div>
    <div class="clearfix"></div>
    <div class="btn bm ef defer-gds @if($good->isDefer())) active @endif"  data-id="{{$good->id}}">
        <div class="icon-wr a-c-t ef ch-i">
            <div class="icon sprite-icons n-defer-h etr-1"></div>
            <div class="icon sprite-icons n-defer  etr-1"></div>
        </div>
        <div class="icon-wr a-c-t">
            <div class="icon sprite-icons n-defer-h"></div>
        </div>
        <span class="">Отложить</span>
        <span class="">Добавлено</span>
    </div>
    <div class="clearfix"></div>
</div>