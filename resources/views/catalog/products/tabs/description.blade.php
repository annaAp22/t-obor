<div class="js-tabs-item product-tabs_body_item wrp-typograph" style="display: block">
    {!! $product->text !!}
    @if($product->attributes->count())
        <h3>Технические характеристики:</h3>
        <table class="mod-two-half">
            @foreach($product->attributes as $attr)
                <tr>
                    <td>{{ $attr->name }}</td>
                    <td>{{ $attr->pivot->value }} {{ $attr->unit }}</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
