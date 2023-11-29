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

function advantagesImgAnim (entries, observer) {
    entries.forEach((entry)=>{
        if(entry.isIntersecting) {
            console.log('bim');
            advantagesImgs.forEach((elem)=>{
                if(elem.className !== 'viewed') {
                    console.log('bum!');
                    elem.classList.add('viewed');
                }
            });
        }
    });
}

const advantagesSect = document.querySelector('.advantages');
const advantagesImgs = document.querySelectorAll('.advantages img');
const observer = new IntersectionObserver(advantagesImgAnim, {
    threshold: 0.8,
});

observer.observe(advantagesSect);