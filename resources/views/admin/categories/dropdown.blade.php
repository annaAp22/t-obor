    @foreach($cats as $cat)
    <option value="{{$cat->id}}" @if((old() && old('id_parent')==$cat->id) || (!old() && !empty($category) && $category->id_parent==$cat->id) || (isset($filters['id_category']) && $filters['id_category']==$cat->id))selected="selected"@endif>
    @for($i=0;$i<$index;$i++)
    &nbsp;
    @endfor
    {{$cat->name}}
    </option>
    @if($cat->categories->count()))
        @include('admin.categories.dropdown', ['cats' => $cat->categories()->where('id', '!=', !empty($category) ? $category->id : -1)->orderBy('sort')->get(), 'index' => ($index+1), 'category' => !empty($category) ? $category : null])
    @endif
    @endforeach
