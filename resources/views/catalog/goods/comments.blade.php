<div class="ls">
    <!-- когда нет не единого отзыва-->
    @if(!$comments->count())
    <div class="" >
        <div class="total-c-7">Отзывов о товаре пока нет</div>
        <div class="ps">Станьте первым! Помогите в развитии сервиса, делитесь впечатлениями о товаре</div>
        <img src="/img/alarm.png" alt=""/>
    </div>
    @else
    <!-- а это отзывы -->
    @if($comments->count() > 3)
    <div class="reviews-nav child v-c">Листать отзывы
        <div class="items all-left">
            <div class="item sprite-icons n-checker-2 ef ch-i-3 active">
                <div class="icon sprite-icons n-checker-2-a etr-1"></div>
            </div>
            <div class="item sprite-icons n-checker-2 ef  ch-i-3">
                <div class="icon sprite-icons n-checker-2-a etr-1"></div>
            </div>
            <div class="item sprite-icons n-checker-2 ef  ch-i-3">
                <div class="icon sprite-icons n-checker-2-a etr-1"></div>
            </div>
        </div>
    </div>
    @endif
    <div id="comment-slider-1" class="comment-slider">
        @foreach($comments->chunk(3) as $block)
        <div class="item">
            @foreach($block as $comment)
            <div class="comment icon-wr">
                <div class="icon sprite-icons n-human ap"></div>
                <div class="two-side">
                    <div class="name ls">{{$comment->name}}</div>
                    <div class="date rs">{{$comment->datePicker()}}</div>
                </div>
                <div class="d">{{$comment->text}}</div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
    @if($comments->count() > 3)
    <div class="reviews-nav child v-c">Листать отзывы
        <div class="items all-left">
            <div class="item sprite-icons n-checker-2 ef ch-i-3 active">
                <div class="icon sprite-icons n-checker-2-a etr-1"></div>
            </div>
            <div class="item sprite-icons n-checker-2 ef  ch-i-3">
                <div class="icon sprite-icons n-checker-2-a etr-1"></div>
            </div>
            <div class="item sprite-icons n-checker-2 ef  ch-i-3">
                <div class="icon sprite-icons n-checker-2-a etr-1"></div>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
<div class="rs">
    <!-- когда отзыв уже отправлен-->
    <div class="comment-send" hidden>
        <div class="child v-c">
            <div class="sprite-icons n-mark-4"></div>&nbsp;&nbsp;&nbsp;
            <div class="total-c-7 c">Отзыв добавлен!</div>
        </div>
        <div class="thanks-win-2 default-win t-c">
            <div class="img sprite-icons n-thanks"></div>
            <div class="t-1">Ваш отзыв внесет ценный вклад в развитие сервиса</div>
        </div>
    </div>
    <!-- когда можно отправить отзыв-->
    <form id="comment-form" class="comment-form" name="comment_form" action="{{route('good.comment', $good->id)}}" method="post" enctype="application/x-www-form-urlencoded">
        <div class="total-c-7 c">Оставить свой отзыв</div>
        <input class="input-1" type="text" name="name" placeholder="Ваше Имя"/>
        <input class="input-1" type="email" name="email" placeholder="Ваша почта"/>
        <textArea class="input-1" name="text" placeholder="Текст Вашего отзыва"></textArea>
        <button class="btn m-13 r ef tr-1">Отправить отзыв</button>
    </form>
</div>