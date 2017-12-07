@if($brands->count())
<div class="allocate child v-b">
    <div class="total-c-10">Бренды</div>&#10;
    <div class="g-count-1">
        <strong>{{$brands->count()}}</strong>&nbsp;&nbsp;{{Lang::choice('бренд|бренда|брендов', $brands->count(), [], 'ru')}}
    </div>&#10;
</div>
<div id="brand-slider-2" class="brand-slider-2">
    <div class="wr">
        <div class="items">
            @foreach($brands as $brand)
            <a class="item aligner tc ef" href="{{route('brands', $brand->sysname)}}">
                @if($brand->img)
                <img src="/{{$brand->getImgPreviewPath().$brand->img}}" alt="{{$brand->name}}"/>
                @endif
                <div class="hover c-c  etr-1">
                    <div class="child v-t">
                        <div class="icon sprite-icons n-loop-3"></div><br/>
                        <div class="t">Подробнее</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @if($brands->count() > 4)
    <div class="nav-wr">
        <div class="prev btn m-8 ef ch-i tr-1 icon-wr a-c in-19 hv-11">
            <div class="icon sprite-icons n-left-btn-1-h"></div>
            <div class="icon sprite-icons n-left-btn-1"></div>
        </div>
        <div class="next btn m-8 ef ch-i tr-1 icon-wr a-c in-19 hv-11 mirror-x">
            <div class="icon sprite-icons n-left-btn-1-h"></div>
            <div class="icon sprite-icons n-left-btn-1"></div>
        </div>
    </div>
    @endif
</div>
@endif
