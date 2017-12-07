@if($tags->count())
<div class="sidebar_listing_nav">
    <h3>Cвойство/ назначение:</h3>
        <div class="">
            @foreach($tags->take(8) as $tag)
            <a class="" href="{{route('tags', $tag->sysname)}}">{{$tag->name}}</a><br>
            @endforeach
        </div>
        @if($tags->count() > 8)
        <div class="big-roll">
            <div class="">
                @foreach($tags->splice(8) as $tag)
                <a class="" href="{{route('tags', $tag->sysname)}}">{{$tag->name}}</a><br>
                @endforeach
            </div>
        </div>
        <div class="more btn roll-up-down">
            <div class="before child v-c">
                <span class="">Ещё</span>
            </div>
            <div class="after child v-c">
                <span class="">Меньше</span>
            </div>
        </div>
        @endif
</div>
@endif
