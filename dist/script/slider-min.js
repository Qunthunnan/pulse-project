const slider=tns({container:".slider__catalog-slider",items:1,speed:500,controls:!1,mouseDrag:!0,navPosition:"bottom",responsive:{320:{nav:!0},576:{nav:!0},768:{nav:!1},991:{nav:!1}}});document.querySelector(".slider__prev-button").addEventListener("click",function(){slider.goTo("prev")}),document.querySelector(".slider__next-button").addEventListener("click",function(){slider.goTo("next")});