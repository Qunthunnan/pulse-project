$(document).ready(function() {
    new WOW().init();
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1600) {
            $('.to-top').fadeIn();
        } else {
            $('.to-top').fadeOut();
        }
    });

    $("a[href=#top]").click(function(){
        const _href = $(this).attr("href");
        $("html, body").animate({scrollTop: $(_href).offset().top+"px"});
        return false;
    });
});