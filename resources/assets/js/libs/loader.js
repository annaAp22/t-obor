$(function() {
    window.loader = $('#loader');

    window.showLoader = function() {
        if (window.loader.hasClass('hidden'))
            $(window.loader).removeClass('hidden');
    };

    window.hideLoader = function() {
        if (!window.loader.hasClass('hidden'))
            $(window.loader).addClass('hidden');
    }
});