<div class="filters" action="{{route('goods.get')}}">
    <input type="hidden" class="filter" name="sort" value="{{$sort}}">
    @if(!empty($filters))
    @foreach($filters as $name => $value)
    <input type="hidden" class="filter" name="{{$name}}" value="{{$value}}">
    @endforeach
    @endif

    <div class="c"><strong>Фильтры</strong> подбора товаров:</div>
    <div class="wr-2">
        <div class="block-1">
            <div class="wr-1 allocate child v-bt">
                <div class="range-scroll-info">
                    <span class="t-1">Цены:</span>
                    <span class="t-2">от</span>&nbsp;&nbsp;
                    <input class="r filter" id="min-val-1" name="price_from" type="text" value="{{$goods->min_price}}">&nbsp;&nbsp;
                    <span class="t-2">до</span>&nbsp;&nbsp;
                    <input class="r filter" id="max-val-1" name="price_to" type="text" value="{{$goods->max_price}}">
                </div>&#10;
                <div class="range-scroll-wr">
                    <div id="minPrice" class="l-label">{{$goods->min_price}} р.</div>
                    <div id="maxPrice" class="r-label">{{$goods->max_price}} р.</div>
                    <div id="range-scroll" class="range-scroll"></div>
                </div>&#10;
            </div>
        </div>
        <div class="big-roll ef h-tr-1">
            @foreach(\App\Models\Attribute::where('is_filter', 1)->get()->chunk(3) as $block)
            <div class="block-1">
                <div class="wr-1 child v-bt">
                @foreach($block as $attribute)
                    <div class="range-scroll-info">
                        <span class="t-1">{{$attribute->name}} @if($attribute->unit)({{$attribute->unit}})@endif:</span>
                        @if($attribute->type == 'list')
                        <select name="attribute[{{$attribute->id}}]"  class="r filter">
                            <option value=""></option>
                            @forelse($attribute->getLists() as $key => $value)
                                <option value="{{$value}}" @if(isset($filters['attributes'][$attribute->id]) && $filters['attributes'][$attribute->id]==$value)selected="selected"@endif>{{$value}}</option>
                            @endforeach
                        </select>
                        @else
                        <input class="r filter" name="attribute[{{$attribute->id}}]" type="text" value="">
                        @endif
                    </div>
                @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <div class="more btn m-23 ef tr-1 ch-h-i roll-up-down">
            <div class="before child v-c">
                <span class="">Показать ещё фильтры</span>&nbsp;&nbsp;&nbsp;
                <div class="icon-wr">
                    <div class="icon ap sprite-icons n-btn-4 etr-1"></div>
                    <div class="icon sprite-icons n-btn-3 etr-1"></div>
                </div>
            </div>
            <div class="after child v-c">
                <span class="">Меньше фильтров</span>&nbsp;&nbsp;&nbsp;
                <div class="icon-wr mirror-y">
                    <div class="icon ap sprite-icons n-btn-4 etr-1"></div>
                    <div class="icon sprite-icons n-btn-3 etr-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block-2 allocate child v-c">
    <div class="sort child v-b">
        <div class="c">Сортировать товары:</div>&#10;
        <button class="btn m-20 r ef tr-1 sort" data-sort="expensive">Дороже</button>&#10;
        <button class="btn m-20 r ef tr-1 sort" data-sort="cheaper">Дешевле</button>&#10;
        <button class="btn m-20 r ef tr-1 sort" data-sort="hit">Хиты продаж</button>&#10;
        <button class="btn m-20 r ef tr-1 sort" data-sort="act">Акции</button>&#10;
    </div>&#10;
    <div class="view child v-c">
        <div class="c">Вид:</div>
        <div id="show-greed" class="btn sprite-icons n-view-greed ef ch-i-3 active-one active">
            <div class="icon sprite-icons n-view-greed-a etr-1"></div>
        </div>
        <div id="show-rows" class="btn sprite-icons n-view-rows ef ch-i-3 active-one">
            <div class="icon sprite-icons n-view-rows-h etr-1"></div>
        </div>
    </div>&#10;
</div>