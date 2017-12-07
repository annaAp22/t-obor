<!-- шапка с фиксированной позицией-->
<div id="header-fixed" class="header-fixed">
    <div class="wrapper allocate child v-c">
        <a class="" href="{{route('index')}}"><img src="/img/logo-3.png" alt=""/></a>&#10;
        <form id="search-form-2" class="search-form" name="search_form_2" action="{{route('search')}}" method="post" enctype="application/x-www-form-urlencoded">
            <input name="_token" type="hidden" value="{{csrf_token()}}">
            <input type="text" name="text" placeholder="Введите поисковой запрос . . . "/>
            <button class="sprite-icons n-loop" type="submit"></button>
        </form>&#10;
        @if($global_settings->has('phones'))
        <span class="tel tel-2">{!! $global_settings->get('phones')->value[1] !!}</span>&#10;
        @endif

        <div class="child v-c">
            <div class="view-info block-icn-2 ef tr-2 ch-i m-r-10">
                <a href="{{route('views')}}">
                    <div class="icon-wr a-c ef ">
                        <div class="icon sprite-icons n-views-h tr-3"></div>
                        <div class="icon sprite-icons n-views tr-3"></div>
                    </div>
                    <div class="t">Смотрели</div>
                    <div class="num m-1 r rt-2 etr-1">{{count(session()->get('goods.view'))}}</div>
                </a>
            </div>
            <a class="bookmarks block-icn-3 ef tr-2 ch-i m-r-10" href="{{route('bookmarks')}}">
                <div class="icon-wr a-c ef">
                    <div class="icon sprite-icons n-bookmarks-h etr-1"></div>
                    <div class="icon sprite-icons n-bookmarks etr-1"></div>
                </div>
                <div class="t">Закладки</div>
                <div class="num m-1 r rt-1 etr-1">{{count(session()->get('goods.defer'))}}</div>
            </a>
            @widget('CartWidget', ['class_basket_info' => 'basket-info-2 ef tr-1',
                                    'class_open' => 'open btn a-v-c to-r icon-wr a-c active-parent',
                                    'class_t' => false])
        </div>
    </div>
</div>