<!-- кнопка лифта страницы-->
<div id="toTop" class="to-top hover-child" style="display: block;">
    <div class="icon sprite-icons n-btn-top"></div>
    <span class="">Наверх</span>
</div>
<!-- кнопка бесплатного звонка-->
<div class="free-call-btn ef">
    <div class="btn etr-1 ">
        <div class="icon sprite-icons n-tel-3"></div>
        <div class="t">Бесплатный<br/>звонок</div>
    </div>
    <div class="wr thrown-el l">
        <form id="free-call-form" class="free-call-form" name="free_call_form" action="{{route('callback')}}" method="post" enctype="application/x-www-form-urlencoded">
            <input name="_token" type="hidden" value="{{csrf_token()}}">
            <div class="c">Укажите личные данные, чтобы мы связались с Вами</div>
            <div class="allocate">
                <input class="name input r block-1" type="text" name="name" placeholder="Ваше имя"/>&#10;
                <input class="name input r block-1 block-2 phone-mask" type="text" name="phone" placeholder="Ваш телефон"/>&#10;
                <button class="btn r block-1 ef tr-1" type="submit">Подтвердить</button>
            </div>
        </form>
    </div>
</div>
<!-- кнопка отправки письма -->
<div class="write-letter-btn open-modal" data-modal="#send-letter">
    <div class="icon sprite-icons n-email-3"></div>
    <div class="t">Написать <br/>письмо</div>
</div>