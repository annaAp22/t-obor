$(document).ready(function(){

    $('.heder_form input').focus(function(){
        $('.datalist').slideDown('slow');
    }).focusout(function(){
        $('.datalist').slideUp('slow');
    });

    $(".main_slider").not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        slidesToScroll: 1,
        dots: true
    });


    $('.product_slider_content').not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        prevArrow: '<button> <i class="fa fa-angle-left" aria-hidden="true"></i> Назад</button>',
        nextArrow: '<button class="slick-next"> <i class="fa fa-angle-right" aria-hidden="true"></i> Вперед</button>'
    });

    $('.news__slider').not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        prevArrow: '<button> <i class="fa fa-angle-left" aria-hidden="true"></i> </button>',
        nextArrow: '<button> <i class="fa fa-angle-right" aria-hidden="true"></i> </button>'
    });

    $('.product_slider_for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.product_slider_nav'
    });
    $('.product_slider_nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.product_slider_for',
        dots: false,
        vertical: true,
        focusOnSelect: true
    });

    //select
    $('select').selectmenu();

    //filtr
    $('.filtr_all .viev_news').click(function(){
        $(this).find('i').toggleClass('fa-long-arrow-up');
        $('.hide_filtr').slideToggle('slow');
        if ($(this).hasClass('hiden')) {
            $(this).removeClass('hiden').find('b').text('показать больше фильтров');
        }
        else{
            $(this).addClass('hiden').find('b').text('скрыть фильтры');
        }
        return false;
    });

    //end filtr

    $('.sidebar_listing_nav .viev_news').click(function(){
        $(this).find('i').toggleClass('fa-long-arrow-up');
        $('.lick_hiden').slideToggle('slow');
        if ($(this).hasClass('hiden')) {
            $(this).removeClass('hiden').find('b').text('РїРѕРєР°Р·Р°С‚СЊ Р±РѕР»СЊС€Рµ ');
        }
        else{
            $(this).addClass('hiden').find('b').text('СЃРєСЂС‹С‚СЊ ');
        }
        return false;
    });

    $('.product_slider_main .you__viev ul li').hover(
        function(){
            $('.product_slider_main .slick-list').height(600);
        },
        function(){
            $('.product_slider_main .slick-list').height(480);
        });


    $('.catalog_nav h3').click(function(){
        $('.catalog_nav ul').slideToggle('slow');
        $(this).toggleClass('active');
    });

    $('.type_form').click(function(){
        $('.type_form').each(function(){
            $(this).removeClass('active');
        });
        $(this).addClass('active');
    });

})