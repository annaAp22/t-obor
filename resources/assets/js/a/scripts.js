function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
    var i, j, kw, kd, km;

    // input sanitation & defaults
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
    return km + kw + kd;
}

/*всем кнопкам класс roll-up-down прописывает развертывание/сворачивание блока c классом big-roll,
 расположенным выше кнопки.
 блок класса big-roll может содержать 1 дочерний элемент, кнопка активируется/деактивируется*/
$('.roll-up-down').click(function(e){
    var prev = $(this).prev('.big-roll');
    //сворачиваем
    if ($(this).hasClass('active')) {
        prev.css('max-height', 0);
        prev.removeClass('active');
    }else {//разворачиваем
        prev.css('max-height', prev.children(':eq(0)').outerHeight() + 'px');
        setTimeout(function (e) {
            prev.addClass('active');
        }, parseInt(prev.css('transition-duration'))*1000);
    }
    $(this).toggleClass('active');

});

$(document).ready(function(){
    $('.phone-mask').mask('+7(999) 999-99-99');

    $('.feedback').click(function (e) {
        e.preventDefault();

        $('.shadow').show();
        $('.modal_coll').show();
    });

    $(document).on("click", ".to_link", function() {
        location.href = $(this).data('href');
    });

    $('.modal .close, .modal .btn_close').click(function (e) {
        $(this).closest('.modal').hide();
        $('.shadow').hide();
    });

    $(document).mouseup(function (e) {
        var container = $('.modal');
        if (container.has(e.target).length === 0){
            container.hide();
            $('.shadow').hide();
        }
    });

    $('form :input').keydown(function(){
        if($(this).css('border-color') == 'rgb(255, 0, 0)') {
            $(this).css({"border-color": "#d5dbc0"});
        }
    });

    $('#feedback-form').submit(function(e) {
        e.preventDefault();
        var $correct = true;
        $('#feedback-form :input').each(function(){
            if(!$(this).val() || $(this).val()=='') {
                $(this).css({"border-color": "red"});
                $correct = false;
            }
        });

        if($correct) {
            var $data = {
                'name' : $(this).find(':input[name="name"]').val(),
                'phone' : $(this).find(':input[name="phone"]').val()};
            $.post($(this).attr('action'), $data,  function(response){
                if(response.message) {
                    alert(response.message)
                } else {
                    $('.modal_coll .modal_content').hide();
                    $('.modal_coll .thank').show();
                }
            });
        }
    });

    $('#subscribe-form').submit(function(e) {
        e.preventDefault();
        var $correct = true;
        $('#subscribe-form :input').each(function(){
            if(!$(this).val() || $(this).val()=='') {
                $(this).css({"border" : "1px solid red"});
                $correct = false;
            }
        });
        if($correct) {
            var $data = {
                'email' : $(this).find(':input[name="email"]').val()};
            $.post($(this).attr('action'), $data,  function(response){
                if(response.message) {
                    alert(response.message)
                } else {
                    $('#subscribe-form :input').hide();
                    $('#subscribe-form .message').show();
                }
            });
        }
    });

    var animateToCart = function(el) {
        var indicator = '.shopcar .cart';

        el.clone()
            .css({'position' : 'absolute', 'z-index' : '11100', top: el.offset().top-100, left:el.offset().left-100})
            .appendTo("body")
            .animate({opacity: 0.05,
                left: $(indicator).offset()['left'],
                top: $(indicator).offset()['top'],
                width: 20}, 1000, function() {
                $(this).remove();
            });
    }

    var addCart = function($id, $qnt) {
        $qnt = $qnt || 1;
        $.get('/good/cart/add/' + $id + '/' + $qnt, function(data){
            var cart = $('.shopcar .cart');
            var cart_modal = $('.modal_add');
            if(data.count) {
                cart.find('b').text(data.count);
                cart_modal.find('.in_basket a').text(data.count);
                cart_modal.find('.in_basket span').text(data.count_name);
            }
        });
    }

    var showModalToCart = function(good) {
        $('.modal_add')
            .find('.product_img img').prop('src', good.data('img')).end()
            .find('.product_name b').text(good.data('name')).end()
            .find('.price b').text((number_format(good.data('price'), 0, ',', ' ') + ' руб.')).end()
            .find('.product_name .articul').text(good.data('articul')).end();
        if(good.data('priceold')) {
            $('.modal_add').find('.old_price span').text(number_format(good.data('priceold'), 0, ',', ' ') + ' руб.').end()
                .find('.old_price').show();
        } else {
            $('.modal_add').find('.old_price').hide();
        }

        $('.modal_add').show();
        $('.shadow').show();
    }


    $(document).on("click", ".defer-good", function() {
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }

        $.get('/good/defer/' + $(this).data('id'),function(data){
            $('.bookmarks b').text(data);
        });
    });

    $(document).on("click", ".cart-good", function(e) {
        e.preventDefault();
        //плавно перемещаем картинку товара в корзину
        var el = $(this).closest('.good-item');
        var qnt = 1;
        if(el.find('input[type="number"]').length) {
            qnt = Number(el.find('input[type="number"]').val());
        }
        var color = 0;
        if(el.find(':input[name="color"]').length) {
            color = Number(el.find(':input[name="color"]').val());
        }

        if(el.find('.img_blok img').length) {
            el = el.find('.img_blok img');
        }

        animateToCart(el);
        addCart($(this).data('id'), qnt, color);
        setTimeout(showModalToCart, 700, $(this));
    });

    $(document).on("click", ".cart-good-quick", function() {
        var good = $(this);
        $('.modal_order')
            .find('input[name=id]').val(good.data('id')).end()
            .find('.imp_product img').prop('src', good.data('img')).end()
            .find('.name').text(good.data('name')).end()
            .find('.price b').text((number_format(good.data('price'), 0, ',', ' ') + ' руб.'));
        if(good.data('priceold')) {
            $('.modal_order').find('.old_price span').text(number_format(good.data('priceold'), 0, ',', ' ') + ' руб.').end()
                .find('.old_price').show();
        } else {
            $('.modal_order').find('.old_price').hide();
        }
        $('.modal_order .form').show();
        $('.modal_order .thank').hide();
        $('.modal_order').show();
        $('.shadow').show();
    });

    $('#quick-call-form').submit(function(e) {
        e.preventDefault();
        var $correct = true;
        $('#quick-call-form :input').each(function(){
            if(!$(this).val() || $(this).val()=='') {
                $(this).css({"border-color": "red"});
                $correct = false;
            }
        });

        if($correct) {
            var $data = {'id' : $(this).find(':input[name="id"]').val(),
                'name' : $(this).find(':input[name="name"]').val(),
                'phone' : $(this).find(':input[name="phone"]').val()};
            $.post($(this).attr('action'), $data,  function(response){
                if(response.message) {
                    alert(response.message)
                } else {
                    $('.modal_order .form').hide();
                    $('.modal_order .thank').show();
                }
            });
        }

    });

    $('#consultation_form').submit(function(e) {
        e.preventDefault();
        var $correct = true;
        $('#consultation_form input').each(function(){
            if(!$(this).val() || $(this).val()=='') {
                $(this).css({"border-color": "red"});
                $correct = false;
            }
        });

        if($correct) {
            var $data = {'_token': $(this).find(':input[name="_token"]').val(),
                'name' : $(this).find(':input[name="name"]').val(),
                'phone' : $(this).find(':input[name="phone"]').val()};

            $.post($(this).attr('action'), $data,  function(response){
                if(response.result=='ok') {
                    var $responsMessage = response.message ? response.message : 'Ваша заявка оформлена, пожалуйста дождитесь пока наш менеджер свяжется с Вами!';
                    $('#consultation_form :input[name="name"]').val('');
                    $('#consultation_form :input[name="phone"]').val('');
                    $('.inputs p').text($responsMessage).css('color', '#ced247');
                    console.log($responsMessage);
                } else {
                    console.log(response.message ? response.message : 'При запросе произошла ошибка. Попробуйте снова.');
                }
            });
        }
    });

    $('#write_us').submit(function(e) {
        e.preventDefault();
        var $correct = true;
        $('#write_us input').each(function(){
            if(!$(this).val() || $(this).val()=='') {
                $(this).css({"border-color": "red"});
                $correct = false;
            }
        });
        $('#write_us textarea').each(function(){
            if(!$(this).val() || $(this).val()=='') {
                $(this).css({"border-color": "red"});
                $correct = false;
            }
        });

        if($correct) {
            var $data = {'_token': $(this).find(':input[name="_token"]').val(),
                'name' : $(this).find(':input[name="name"]').val(),
                'phone' : $(this).find(':input[name="phone"]').val(),
                'email' : $(this).find(':input[name="email"]').val(),
                'text' : $(this).find(':input[name="text"]').val()
            };
            $.post($(this).attr('action'), $data,  function(response){
                if(response.result=='ok') {
                    var $responsMessage = response.message ? response.message : 'Ваш вопрос успешно отправлен!';
                    $('#write_us :input[name="name"]').val('');
                    $('#write_us :input[name="phone"]').val('');
                    $('#write_us :input[name="email"]').val('');
                    $('#write_us textarea').val('');
                    $('#write_us p').text($responsMessage).css('color', '#ced247');
                    console.log($responsMessage);
                } else {
                    console.log(response.message ? response.message : 'При запросе произошла ошибка. Попробуйте снова.');
                }
            });
        }
    });

    var goodsMore = function ($page) {
        var $main = $('.filtr');
        var $data = {};
        $data.page = $page;
        $main.find(':input.filter').each(function(){
            if($(this).val()) {
                $data[$(this).attr('name')] = $(this).val();
            }
        });

        $.post($main.attr('action'), $data,  function(response){
            if(response.result == 'ok') {
                if(response.clear) {
                    $('.filtr_search').find('a').text(response.goods.total);
                    $('.main_product_list ul').empty();
                }
                if(response.view) {
                    $('.filtr_search').find('a').text(response.goods.total);
                    $('.main_product_list ul').append(response.view);
                }

                if(response.next_page) {
                    console.log(response.next_page);
                    $('.goods-more').data('page', response.next_page);
                    if(!$('.goods-more').is(":visible")) {
                        $('.goods-more').show();
                    }
                } else {
                    $('.goods-more').hide();
                }

            }
        });
    }

    $(document).on("click", ".goods-more", function(e) {
        e.preventDefault();
        goodsMore($(this).data('page') ? $(this).data('page') : 1 );
    });

    $(document).on("change", ".filtr :input.filter", function(e) {
        goodsMore(1);
    });

    $('.selectmenu').on('selectmenuchange', function() {
        goodsMore(1);
    });

    $('.sort .btn_sort').click(function() {
        $('.sort .btn_sort').removeClass('active');
        $(this).addClass('active');
        $('.filtr input[name=sort]').val($(this).data('sort'));
        goodsMore(1);
    });

    //range
    range_min =  Number($( ".filtr-range" ).data('min'));
    range_max =  Number($( ".filtr-range" ).data('max'));
    $( "#slider-range" ).slider({
        range: true,
        min: range_min,
        max: range_max,
        values: [ range_min, range_max ],
        slide: function( event, ui ) {
            $( "#range_v1" ).val( ui.values[ 0 ] );
            $( "#range_v2" ).val( ui.values[ 1 ] );
            $( "#i_range_v1" ).val( ui.values[ 0 ] );
            $( "#i_range_v2" ).val( ui.values[ 1 ] );
        },
        change: function(event, ui) {
            goodsMore(1);
        }
    });

    $('#i_range_v1, #i_range_v2').change(function(){
        var value =  Number($(this).val());
        if(isNaN(value)) {
            value = 0
        }
        if(value < range_min) {
            value = range_min;
            $(this).val(range_min);
        } else if (value > range_max) {
            value = range_max
            $(this).val(range_max);
        }
        $( "#slider-range" ).slider('values', $(this).data('pos'), value);
        $( "#" + $(this).attr('id').substring(2)).val( value );
    });

    // фильтрация ввода в поля
    jQuery('#i_range_v1, #i_range_v2').keypress(function(event){
        var key, keyChar;
        if(!event) var event = window.event;

        if (event.keyCode) key = event.keyCode;
        else if(event.which) key = event.which;

        if(key==null || key==0 || key==8 || key==13 || key==9 || key==46 || key==37 || key==39 ) return true;
        keyChar=String.fromCharCode(key);

        if(!/\d/.test(keyChar))	return false;

    });

    if($('.filtr_all').length) {
        if(!$('.hide_filtr').length) {
            $('.filtr_all').hide();
        }
    }

    var calc = function() {
        if($('.cart .table_basket tbody tr').length) {
            var $amount = 0;
            $('.cart .table_basket tbody tr').each(function () {
                var $el = $(this).find('input[name ^= goods]');
                var amount = parseInt($el.data('price')) * parseInt($el.val());
                $(this).find('.price-amount b').text(number_format(amount, 0, ',', ' ') + ' руб.');
                $amount += amount;
            });
            $('.cart .table_basket_footer b').text(number_format($amount, 0, ',', ' ') + ' руб.');
        } else {
            $('.cart').empty();
            $('.cart').append('<h2 style="color: darkred"> Корзина пуста</h2>');
        }
    }

    $('.cart input[name ^="goods"]').click(function() {
        calc();
    });

    $('.cart .del').click(function() {
        var $tr = $(this).closest('tr');
        $tr.fadeTo("normal", 0, function () {
            $tr.remove();
            calc();
        });

        $.post($(this).closest('tr').data('actiondel'), {'id': $(this).data('id')},  function(response){
            console.log(response);
            $('.shopcar .cart').find('b').text(response.count);
        });
    });

    $('.cart .submit').click(function(e){
        e.preventDefault();
        $(this).closest('form').submit();
    });

    if($('.cart .table_basket').length) {
        calc();
    }


    $("#autocomplite").autocomplete({source: "/goods/search", minLength: 2}).autocomplete( "instance" )._renderItem = function(ul, item) {

        return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a href='" + item.url + "' class='ui-state-active'><img src='" + item.img + "'><span class='name_t'>" + item.name + "</span><span>" + item.price + "</span></a>")
            .appendTo(ul);
    };


    var order = function () {
        var $cost = parseInt($('.decor input[name=delivery_id]:checked').data('price'));
        $('.decor .payment_cost').text(number_format($cost, 0, ',', ' ') + ' руб.')
        var $amount = parseInt($('.decor .cart_amount').data('amount')) + $cost;
        $('.decor .total').text(number_format($amount, 0, ',', ' ') + ' руб.');
    }

    $('.decor input[name=delivery_id]').change(function(){
        order();
    });

    if($('.decor input[name=delivery_id]').length) {
        order();
    }

});