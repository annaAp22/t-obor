<div id="follow" style="margin:0;background-color:transparent;z-index:99999;position:fixed;top:50%;margin-top: -56px;right: 15px;width: 30px;display: block;">
    <a href="{{route('admin.main')}}" target="_blank">
        <img src="/img/icons/home.png" alt="В панель администратора" title="В панель администратора">
    </a>
    @if ($url)
    <a href="{{$url}}" target="_blank">
        <img src="/img/icons/pancil.png" alt="Редактировать контент" title="Редактировать контент" style="margin: 7px 0px;">
    </a>
    @endif
    @if ($url_route)
    <a href="{{$url_route}}" target="_blank">
        <img src="/img/icons/category.png" alt="Редактировать мета-тэги" title="Редактировать мета-тэги" style="margin: 7px 0px;">
    </a>
    @endif
    <a id="button-up" href="#">
        <img src="/img/icons/top.png" alt="Наверх" title="Наверх">
    </a>
</div>