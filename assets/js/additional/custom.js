window.loader = function (elem, hidden) {
    if (hidden == true) {
        $('body').css({overflow:'hidden'});
    }
    $(elem).css({position:'relative'}).append('<div class="loader"><div class="loading-pulse"></div></div>');
}

window.removeLoader = function () {
    $('.loader').remove();
    $('body').css({overflow:''});
}

$("input[name='search']").on('keydown', function(e) {
    if (e.which == 13) {
        let button = $(this).data('button')
        e.preventDefault();
        $(button).trigger('click');
    }
});