$(function() {
    var $filters = $('#catalog-filters'),
        $sliders = $('.js-slider-filter'),
        $sorters = $('.catalog-sort_button'),
        $page = $filters.find('input[name=page]'),
        $productsCount = $('.block-title_count'),
        $items = $('.catalog-items'),
        $paginator = $('.catalog-next-page-btn'),
        dontTouchThis = [
            'page',
            '_token',
            'category_id',
            'brand_id',
            'tag_id',
            'price_from',
            'price_to'
        ],
        dontTouchSelector = '',
        resetPagination = function() {
            console.log('reset pagination');
            $page.val(1);
            $paginator.show();
            $filters.trigger('submit');
        };

    for(var index in dontTouchThis)
        dontTouchSelector += '[name!=' + dontTouchThis[index] + ']';

    if($page.val() == '') $paginator.hide();

    var sliders = {};
    $sliders.each(function (i, e) {
        var $this = $(this);
        var from = parseInt($this.data('from'));
        var to = parseInt($this.data('to'));
        $this.parent().append('<span class="slider-filter_from">' + from + ' р.' + '</span><span class="slider-filter_to">' + to + ' р.' + '</span>');
        $('#' + $this.data('obj-id-from')).text(from);
        $('#' + $this.data('obj-id-to')).text(to);
        sliders[i] = $this.slider({
            range: true,
            min: from,
            max: to,
            values: [from, to],
            slide: function (event, ui) {
                $('#' + $this.data('obj-id-from')).val('от ' + ui.values[0] + ' p.');
                $('#' + $this.data('obj-id-to')).val('до ' + ui.values[1] + ' p.');
                $('#catalog-filters input[name=price_from]').val(ui.values[0]);
                $('#catalog-filters input[name=price_to]').val(ui.values[1]);
            },
            change: function (event, ui) { resetPagination(); }
        });
    });
    $('#input-from, #input-to').on('change', function(e) {
        e.preventDefault();

        var val = $(this).val().match(/(\d+)/ig),
            ind = ($(this).attr('id') == 'input-from' ? 0 : 1),
            name = ($(this).attr('id') == 'input-from' ? 'price_from' : 'price_to'),
            direction = $(this).attr('id') == 'input-from' ? 'от ' : 'до ';
            $input = $filters.find('input[name=' + name + ']');

        $input.val(val);
        $(this).val(direction + val + ' р.');
        $('.js-slider-filter').slider('values', ind, val);
    });
    $filters.find('input[name^=attribute],select[name^=attribute]').on('change', function(e) {
        e.preventDefault();
        resetPagination();
    })

    $filters.on('submit', function(e) {
        e.preventDefault();

        window.showLoader();
        $.post($(this).attr('action'), $(this).serialize(), function(data) {
            if(data.clear) {
                $page.val(2);
                $items.html($(data.items));
            } else {
                $items.append($(data.items));
            }

            if(data.next_page === null) $paginator.hide();
            else $page.val(data.next_page);
            $productsCount.html(data.count);

            window.hideLoader();
        });
    });
    $sorters.on('click', function(e) {
        e.preventDefault();

        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $filters.find('input[type=hidden]' + dontTouchSelector).val('');
        } else {
            $('.catalog-sort_button').each(function(i, el) { $(el).removeClass('active'); });
            $(this).addClass('active');

            $filters.find('input[type=hidden]' + dontTouchSelector).val('');
            $filters.find('input[type=hidden][name=' + $(this).attr('name') + ']').val($(this).val());
        }

        resetPagination();
    });

    $paginator.on('click', function(e) {
        e.preventDefault();

        $filters.trigger('submit');
    });
});