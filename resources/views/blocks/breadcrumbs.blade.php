@if ($breadcrumbs)
    <ul class="bcrumbs">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$breadcrumb->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li>{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
        @if(count($breadcrumbs) > 1)
            @php
                $title = in_array(\Request::route()->getName(), [
                    'cart',
                 ]) ? 'Продолжить покупки' : 'назад';
            @endphp
        @endif
    </ul>
@endif

