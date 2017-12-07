//= libs/jquery.min.js
//= libs/owl.carousel.min.js
//= libs/jquery.formstyler.js
//= libs/jquery-ui.js
//= libs/jquery.fancybox.js

jQuery(document).ready(function ($) {

    var carousels = {};
    $('.js-carousel').each(function (i, e) {
        var $this = $(this);
        carousels[i] = $this.owlCarousel({
            items: $this.data('slide-count'),
            nav: $this.data('arrows'),
            dots: $this.data('dots'),
            navText: ['', ''],
            autoplay: true,
            autoplayTimeout: 8000,
            loop: true,
            autoplayHoverPause: true
        })
    });


    setTimeout(function () {
        $('.js-form-slyler').styler();
    }, 100);

    $('.js-show-more').on('click', function (e) {
        e.preventDefault();
        var text = $(this).data('active-text');
        var $this = $(this);
        $this.data('active-text', $this.text());

        $this.toggleClass('active');
        $this.closest('.js-show-more-wrap').find('.js-show-more-obj').toggleClass('active');
        setTimeout(function () {
            $this.text(text);
            if ($this.hasClass('active'))
                $this.closest('.js-show-more-wrap').addClass('visible');
            else
                $this.closest('.js-show-more-wrap').removeClass('visible');
        }, 500);
    });

    $('.js-select-styler').styler();


    var productSlideObj = $('.js-product-object_images').owlCarousel({
        items: 1,
        nav: false,
        dots: false,
        loop: false,
        center: true
    });


    $('.js-product-img-dot').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);

        $this.siblings().removeClass('active').end().addClass('active');
        productSlideObj.trigger('to.owl.carousel', $this.index());

    });

    $('.js-product-img-nav').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $thumbs = $('.js-product-img-dot');
        var $thumbActive = $('.js-product-img-dot.active');
        var index = $thumbActive.index();

        $thumbs.removeClass('active');


        if ($this.hasClass('owl-prev')) {

            if (index == 0) {
                productSlideObj.trigger('to.owl.carousel', $thumbs.size() - 1);
                $thumbs.eq($thumbs.size() - 1).addClass('active');
            } else {
                productSlideObj.trigger('prev.owl.carousel');
                $thumbs.eq(index - 1).addClass('active');
            }

        } else {

            if (index == $thumbs.size() - 1) {
                productSlideObj.trigger('to.owl.carousel', 0);
                $thumbs.eq(0).addClass('active');
            } else {
                productSlideObj.trigger('next.owl.carousel');
                $thumbs.eq(index + 1).addClass('active');
            }

        }

    });

    $('.js-tabs-button').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $this = $(this);
        $this.siblings().removeClass('active').end().addClass('active');
        $this.closest('.js-tabs').find('.js-tabs-item').hide().eq($this.index()).show();
    });


    $('.phone-input').mask("+7 (999) 999 99 99", {placeholder: '+7 (xxx) xxx xx xx'});

    // Кнопки для управления кол-вом покупаемого товара
    var counterButtonsCallback = function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $this = $(this);
        var input = $this.siblings('input');
        var inputVal = parseInt(input.val());

        if ($this.hasClass('product_counter_obj_minus') && inputVal > 1) {
            inputVal--;
        } else if ($this.hasClass('product_counter_obj_plus') && inputVal >= 1) {
            inputVal++;
        }
        input.val(inputVal);
        input.trigger('change');
    };
    $('.cart-wrap_table tbody').on('click', 'tr td.col4 button', counterButtonsCallback);
    $('#cart-modal .js-counter.product_counter_obj').on('click', 'button', counterButtonsCallback);
    $('#quick-order .js-counter.product_counter_obj').on('click', 'button', counterButtonsCallback);
    $('#quick-order .js-counter.product_counter_obj').on('click', 'button', counterButtonsCallback);
    $('.product-object .product-object_data .product_counter').on('click', 'button', counterButtonsCallback);

    // Обноавление кол-ва в карточке товара
    $('#details-quantity-input').on('change', function(e) {
        var $parentNode = $(this).parents('.product-object_data'),
            $fastbuyBtn = $parentNode.find('button.fast-buy-button'),
            $cartBtn = $parentNode.find('button.add-to-cart-btn'),
            quantity = $(this).val();

        $fastbuyBtn.data('quantity', quantity);
        $cartBtn.data('quantity', quantity);
    });

    // Кнопки закрытия модальных окон
    var closeFancyBoxCallback = function(e) {
        e.preventDefault();
        $.fancybox.getInstance().close();
    };
    $('#thanks button.btn-blue').on('click', closeFancyBoxCallback);
    $('#cart-modal .cart-modal_bottom button.btn-blue-border').on('click', closeFancyBoxCallback);


});

