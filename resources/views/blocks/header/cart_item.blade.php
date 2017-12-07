<a href="{{route('good', $good->sysname)}}" class="item-b allocate" data-id="{{$good->id}}">
    <div class="child v-t">
        <div class="num m-1 r rt-1 etr-1">{{$cnt}}</div>
        @if($good->img)
        <div class="icon-wr">
            <img src="/{{$good->getImgPreviewPath().$good->img}}" width="29px" />
        </div>
        @endif
        <div class="c">{{$good->name}}</div>
    </div>&#10;
    <div class="price">{{$good->price}} р.</div>&#10;
</a>