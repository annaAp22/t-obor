<form class="filtr" action="{{ route('goods.get') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="page" value="{{ ($paginator->hasMorePages()) ? $paginator->currentPage() + 1 : '' }}" />
    <input type="hidden" name="category_id" value="{{ isset($category) ? $category->id : '' }}" />
    <input type="hidden" name="brand_id" value="{{ isset($brand) ? $brand->id : '' }}" />
    <input type="hidden" name="tag_id" value="{{ isset($tag) ? $tag->id : '' }}" />

    <input type="hidden" name="hit" value="" />
    <input type="hidden" name="new" value="" />
    <input type="hidden" name="sort" value="" />

    <input type="hidden" name="price_from" value="{{ $minPrice }}" />
    <input type="hidden" name="price_to" value="{{ $maxPrice }}" />
    <input type="hidden" class="filter" name="sort" value="{{$sort}}">
    @if(!empty($filters1))
    @foreach($filters1 as $name1 => $value1)
    <input type="hidden" class="filter" name="{{$name1}}" value="{{$value1}}">
    @endforeach
    @endif

            <div class="filtr_search">
                {{ \App\Helpers\inflectByCount($goods->total(), ['one' => 'товар', 'many' => 'товара', 'others' => 'товаров']) }}
                в категории:  <a>{{ $goods->total() }}</a>
            </div>
            <div class="vief_part">
                <b>Цена:</b>
                <span>от</span>
                <input type="text" name="price_from" value="{{ $minPrice }}" class="filter" id="i_range_v1" data-pos="0">
                <span>до</span>
                <input type="text" name="price_to" value="{{ $maxPrice }}" class="filter" id="i_range_v2" data-pos="1">
                <div class="range filtr-range" data-min="{{ $minPrice }}" data-max="{{ $maxPrice }}">
                    <label for="range"></label>
                    <input type="text" id="range_v1" value="{{ $minPrice }}" readonly="">
                    <input type="text" id="range_v2" value="{{ $maxPrice }}" readonly="">

                    <div id="slider-range"></div>
                </div>
            </div>
            @if(isset($filters) && $filters->count())
                @php $i = 1; @endphp
                @foreach($filters as $filter)
                    @if($i % 2 == 1)
                        <div class="hide_filtr">
                    @endif

                        <label for="ui-id-{{ $filter->id }}-button">{{ $filter->name }}:
                        @if($filter->type == 'integer')
                            <input class="filter" type="number" name="attribute[{{ $filter->id }}]" />
                            <span class="filter-unit">{{ $filter->unit }}</span>
                        @elseif($filter->type == 'string')
                            <input class="filter" type="text" name="attribute[{{ $filter->id }}]" />
                        @elseif($filter->type == 'list')
                                <select id="ui-id-{{ $filter->id }}" style="display: none;" class="filter selectmenu" name="attribute[{{ $filter->id }}]">
                                    <option value="">Выберите из списка</option>
                                    @foreach($filter->getLists() as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                        @endif
                        </label>

                    @if(($i % 2 == 0) || $filter == $filters->last())
                        </div>
                    @endif
                    @php $i++; @endphp
                @endforeach
            @endif

</form>
@if(isset($filters) && $filters->count())
<div class="news_all filtr_all">
    <a href="#" class="viev_news"><b>показать больше фильтров</b> <i class="fa fa-long-arrow-down" aria-hidden="true"></i></a>
</div>
@endif
<div class="sort">
    Сортировать товары:
    <div class="sort_btn">
        <button class="btn_sort" data-sort="cheaper">Дешевле</button>
        <button class="btn_sort" data-sort="expensive">Дороже</button>
        <button class="btn_sort" data-sort="popular">По популярности</button>
        <button class="btn_sort" data-sort="new">По новинкам</button>
    </div>
</div>