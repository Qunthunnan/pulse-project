import {tns} from 'tiny-slider';

export const catalogSlider = function () {
    const slider = tns({
        container: '.slider__catalog-slider',
        items : 1,
        speed: 500,
        controls: false,
        mouseDrag: true,
        navPosition: "bottom",
        responsive: {
             320: {
                 nav: true
             },
             576: {
                 nav: true
             },
             768: {
                 nav: false
             },
             991: {
                 nav: false
             }
           }
    });
    
    document.querySelector('.slider__prev-button').addEventListener('click', function () {
        slider.goTo('prev');
      });
    
    document.querySelector('.slider__next-button').addEventListener('click', function () {
        slider.goTo('next');
      });
}