<div class="{{$config['class']}}">
    <!-- еще одна форма получение скидки. активировать, чтобы показать окно благодарности-->
    <form id="sales-form{{$config['form_index']}}" class="sales-form{{$config['form_index']}}" name="sales_form{{$config['form_index']}}" action="{{route('subscribe')}}" method="post" enctype="application/x-www-form-urlencoded">
        <input type="hidden" name="act" value="1" />
        <img class="img" src="/img/handcart{{$config['form_index']}}.png" alt=""/>
        <div class="wr wr-info">
            <div class="c">Получить информацию о скидках</div>
            <div class="d">Подпишитесь на нашу рассылку, чтобы быть в курсе последних акций, новостей, новинок</div>
            <div class="allocate wr-1">
                <input class="r" type="email" name="email" placeholder="Ваша почта"/>&#10;
                <button type="submit" class="btn r m-5 ef hv-13 tr-1">Получить</button>&#10;
            </div>
        </div>
        <!-- а это благодарност за отправку письма на получение скидки -->
        <div class="sales-win-2 thanks" hidden>
            <img class="img" src="/img/handcart{{$config['form_index']}}.png" alt=""/>
            <div class="wr allocate child v-b">
                <div class="c">Спасибо!</div>
                <div class="d">Вы подписались на рассылку новостей, акций и новинок</div>
            </div>
        </div>
    </form>
</div>