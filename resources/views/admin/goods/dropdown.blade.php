    @foreach($cats as $cat)
    <option value="{{$cat->id}}" @if((old() && old('categories') && in_array($cat->id, old('categories'))) || (!old() && !empty($good) && $good->categories->count() && $good->categories->find($cat->id)) || (isset($filters['id_category']) && $filters['id_category']==$cat->id))selected="selected"@endif>
    @for($i=0;$i<$index;$i++)
    &nbsp;
    @endfor
    {{$cat->name}}
    </option>
    @if($cat->categories->count()))
        @include('admin.goods.dropdown', ['cats' => $cat->categories()->orderBy('sort')->get(), 'index' => ($index+1), 'good' => !empty($good) ? $good : null])
    @endif
    @endforeach
