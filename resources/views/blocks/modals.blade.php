<div class="modal modal_coll" style="display: none;">
    <div class="close"></div>
    <div class="modal_content">
        <h3>Заказать обратный звонок</h3>
        <p>Оставьте телефон и наш менеджер свяжется с Вами в течение часа</p>
        <form action="{{ route('callback') }}" method="post" id="feedback-form">
            <label><i class="fa fa-user" aria-hidden="true"></i> <input type="text" name="name" placeholder="Ваше имя"></label>
            <label><i class="fa fa-phone" aria-hidden="true"></i> <input type="text" name="phone" class="phone-mask" placeholder="Ваш телефон"></label>
            <input type="submit" value="ОТПРАВИТЬ" class="btn">
        </form>
    </div>

    <div class="thank" style="display: none;">
        <b>СПАСИБО!</b>
        В ближайшее время мы свяжемся с Вами. <br> Пожалуйста, не отключайте телефон.
    </div>
</div>

<div class="modal modal_add" style="display: none;">
    <div class="close"></div>

    <div class="gds_add-txt">Товар добавлен в корзину</div>
    <div class="gds_block">
        <div class="gds_img">
            <img src="" alt="">
        </div>
        <div class="gds_name">
            <b> </b>
            <span>Артикул:</span> <el class="articul"></el>
        </div>
        <div class="price">
            <div class="old_price">
                <span></span>
            </div>
            <b></b>
        </div>
    </div>
    <div class="btns">
        <button class="btn to_link" data-href="{{route('cart')}}">ОФОРМИТЬ ЗАКАЗ</button>
        <button class="btn btn_white btn_close">Продолжить покупки</button>
        <div class="in_basket">
            В вашей корзине:
            <b><a href="{{route('cart')}}">{{ count(session()->get('goods.cart')) }}</a> 
                <span>{{ \App\Helpers\inflectByCount(count(session()->get('goods.cart')), ['one' => 'товар', 'many' => 'товара', 'others' => 'товаров']) }}</span>
            </b>
        </div>
    </div>
</div>

<div class="modal modal_order" style="display: none;">
    <div class="close"></div>
    <div class="img_blok popup_gds">
        <div class="imp_gds">
            <img src="">
        </div>
        <div class="name"></div>
        <div class="price">
            <div class="old_price">
                <span>14 220 руб.</span>
            </div>
            <b>13 345 руб.</b>
        </div>
    </div>
    <div class="form">
        <h3>Заказать обратный звонок</h3>
        <p>Оставьте телефон и наш менеджер свяжется с Вами в течение часа</p>
        <form id="quick-call-form" action="{{ route('order.fast') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="">
            <label><i class="fa fa-user" aria-hidden="true"></i> <input type="text" name="name" placeholder="Ваше имя"></label>
            <label><i class="fa fa-phone" aria-hidden="true"></i> <input type="text" class="phone-mask" name="phone" placeholder="Ваш телефон"></label>
            <input type="submit" value="ОТПРАВИТЬ" class="btn">
        </form>
    </div>

    <div class="thank" style="display: none;">
        <b>СПАСИБО!</b>
        В ближайшее время мы свяжемся с Вами. Пожалуйста, не отключайте телефон.
    </div>

</div>