<!DOCTYPE html>
<html lang="ru">
<head>
    {!! Meta::render() !!}
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" />
    <link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

</head>
<body>
@include('blocks.header.index')
<div class="main">
    <div class="row-blk">
        <div class="content_block big_content_block">
            <nav>
                <div class="catalog_nav">
                    @widget('CatalogWidget')
                </div>
                @include('blocks.header.menu')
            </nav>    
            @section('breadcrumbs')
            @show
            <div class="content cart">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('blocks.footer.index')
@include('blocks.modals')

{{-- UNUSED --}}
{{--        @include('blocks.buttons')--}}
{{--        @include('blocks.header.fixed')--}}


    <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>
