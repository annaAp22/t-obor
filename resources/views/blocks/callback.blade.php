<div class="cons">
    <div class="cons_botton">
        <h3>НУЖНА КОНСУЛЬТАЦИЯ?</h3>
        <form action="{{ route('callback') }}" method="post" id="consultation_form">
            {{ csrf_field() }}
            <div class="inputs">
                @if($errors->has())
                <div class="alert alert-danger" style="background-color: #f2dede;border-color: #ebccd1; color: #a94442;padding: 15px;margin-bottom: 20px;border: 1px solid transparent;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <p>Оставьте телефон и наш менеджер свяжется с Вами в течение часа</p>
                <label><i class="fa fa-user" aria-hidden="true"></i>
                    <input type="text" name="name" value="" placeholder="Ваше имя">
                </label>
                <label><i class="fa fa-phone" aria-hidden="true"></i>
                    <input type="text" class="phone-mask" name="phone" value="" placeholder="Ваш телефон">
                </label>
                <input type="submit" value="ОТПРАВИТЬ" class="btn">
            </div>
            <img src="/img/phone.png" alt="" class="mobile">
        </form>
    </div>
</div>