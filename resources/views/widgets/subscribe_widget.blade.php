<div class="subscribe">
    <div  class="{{$config['class']}}">
        <form id="subscribe-form{{$config['form_index']}}" class="subscribe-form{{$config['form_index']}}" name="subscribe_form" action="{{route('subscribe')}}" method="post" enctype="application/x-www-form-urlencoded">
            <!-- когда уже не надо оформлять подписку -->
            <div class="thanks thanks-win-3 default-win t-c" hidden=""  style="padding: 20px 20px;">
                <div class="img sprite-icons n-thanks"></div>
                <div class="t-1">Теперь Вы подписаны на все самое свежее и интересно!</div>
            </div>
            <!-- когда можно оформить подписку. Внимание !!! Скрываем элемент если надо через visibility, ибо занимаемое им пространство должно остаться -->
            <div class="wr-2" style="visibility:visible;">
                <div class="{{$config['caption_class']}} child v-c">
                    <div class="icon sprite-icons n-tilde"></div>
                    <div class="{{$config['total_class']}}">Ещё больше полезного о садоводстве!</div>
                    @if($config['total_icon_right'])
                    <div class="icon sprite-icons n-tilde"></div>
                    @endif
                </div>
                <div class="wr">
                    <div class="d">Хотите получать регулярную информацию о скидках, акциях, новинках и полезных статьях?</div>
                    <div class="allocate">
                        <div class="input-wr">
                            <div class="icon btn sprite-icons n-email"></div>
                            <input class="r" name="email" placeholder="Ваша электронная почта" type="email">
                        </div>

                        <button class="btn m-7 r ef in-12 hv-12 tr-1" type="submit">Подписаться</button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
        <div class="clearfix"></div>
        <img class="man" src="/img/man.png" alt="">
    </div>
</div>
