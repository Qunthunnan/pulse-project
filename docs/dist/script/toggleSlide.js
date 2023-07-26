function toggleSlide(item) {
    $(item).each(function(i) {
        $(this).on('click', function(e) {
            e.preventDefault();
            $('.product-card__title-content').eq(i).toggleClass('product-card__title-content-active');
            $('.product-card__more-content').eq(i).toggleClass('product-card__more-content-active');
        })
    });
};

toggleSlide('.product-card__more');
toggleSlide('.product-card__back');