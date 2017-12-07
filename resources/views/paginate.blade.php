@if ($paginator->lastPage() > 1)
<div id="pages-slider-1" class="pages-slider">
    <div class="pages ef atr-1 ">
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <a class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        @endfor
    </div>
    <div class="pages-nav">
        @if($paginator->currentPage() > 1)
        <a href="{{$paginator->previousPageUrl()}}">
            <div class="prev btn m-6 ef ch-i tr-1 icon-wr a-c in-19 hv-11">
                <div class="icon sprite-icons n-left-btn-2-h"></div>
                <div class="icon sprite-icons n-left-btn-2"></div>
            </div>
        </a>
        @endif
        @if($paginator->currentPage() != $paginator->lastPage())
        <a href="{{$paginator->nextPageUrl()}}">
            <div class="next btn m-6 ef ch-i tr-1 icon-wr a-c in-19 hv-11 mirror-x">
                <div class="icon sprite-icons n-left-btn-2-h"></div>
                <div class="icon sprite-icons n-left-btn-2"></div>
            </div>
        </a>
        @endif
    </div>
</div>

@endif
