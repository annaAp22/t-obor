@foreach($goods as $good)
    @include('catalog.goods.good_row', ['good' => $good])
@endforeach