@extends('layouts.main')
@section('content')
<div class="content">
    <h3 class="title">Страница не найдена...</h3>
    Ошибка. Похоже, запрашиваемая страница не найдена. Воспользуйтесь каталогом товаров или поиском по сайту
    <img src="/img/err404.jpg" alt="" class="img_error">
    <a href="{{ route('index') }}" style="text-decoration: none;">
        <div class="btn btn_white btn_back">Вернуться на главную</div>
    </a>
</div>
@stop