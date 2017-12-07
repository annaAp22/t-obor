<div class="map">
    <ul>
        <li>
            <b>Адрес:</b>
            {{ $global_settings['address']->value }}
        </li>
        <li>
            <b>Электронная <br> почта:</b>
            {{ $global_settings['email_support']->value }}
        </li>
        <li>
            <b>Телефон:</b>
            @if(is_array($global_settings['phone_number']->value))
            {{ $global_settings['phone_number']->value['1'] }}<br>
            {{ $global_settings['phone_number']->value['2'] }}<br>
            {{ $global_settings['phone_number']->value['3'] }}<br>
            (Viber, WhatsApp)
            @else
            {{ $global_settings['phone_number']->value }}
            @endif
        </li>
        <li>
            <b>Режим работы:</b>
            пн.-пт.: {{ $global_settings['schedule']->value['start_workday'] }}-{{ $global_settings['schedule']->value['end_workday'] }},
            <br> сб.: {{ $global_settings['schedule']->value['start_weekend'] }}-{{ $global_settings['schedule']->value['end_weekend'] }}<br> вс: выходной день
        </li>
    </ul>
    <script type="text/javascript" charset="utf-8" async="" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=u0ouN3yeO8ptMVNDqc0Hlp1XuDparrZm&amp;width=100%25&amp;height=380&amp;lang=ru_UA&amp;sourceType=constructor&amp;scroll=true"></script>
</div>

