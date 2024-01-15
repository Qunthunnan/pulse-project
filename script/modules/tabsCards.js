export const tabs = function () {
    $('ul.catalog__tabs-list').on('click', 'li:not(.catalog__tab-active)', function() {
      $(this).addClass('catalog__tab-active').siblings().removeClass('catalog__tab-active')
        .closest('div.catalog__tabs').find('div.catalog__tabs-content').removeClass('catalog__tabs-content-active').eq($(this).index()).addClass('catalog__tabs-content-active');
    });
}