export const modal = function () {
    $('[data-modal=consultation]').on('click', function() {
        $('.overlay, #consultation').fadeIn('slow');
    });

    $('.modal__close').on('click', function() {
        $('.overlay, #consultation, #buy-done, #buy').fadeOut('slow');
    });

    $('.button_product-card').each(function(i) {
        $(this).on('click', function() {
            $('#buy .modal__subtitle').text($('.product-card__title').eq(i).text());
            $('.overlay, #buy').fadeIn('slow');
        })
    });
}

