@foreach($goods as $good)
    @include('catalog.goods.good_greed', ['good' => $good])
@endforeach