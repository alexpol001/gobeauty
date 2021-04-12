$(document).ready(function () {

    $('.page-header__mob-open').on('click', function () {
        $('.user').slideToggle(100, function () {
            if ($(this).css('display') === 'none') {
                $(this).removeAttr('style')
            }
        });
    });

    $('.service__list').slick({
        dots: true,
        infinite: true,
        adaptiveHeight: true,
        prevArrow: '<img class="prev-left" src="img/prev-left.png">',
        nextArrow: '<img class="prev-right" src="img/prev-right.png">',
        speed: 500,
        slidesToShow: 2,
        slidesToScroll: 2,
        responsive: [
            {
                breakpoint: 9999,
                settings: "unslick"
            },
            {
                breakpoint: 767,
                setting: {
                    speed: 300,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            }
        ]
    });

    $('.advantage__list').slick({
        dots: true,
        infinite: true,
        speed: 300,
        prevArrow: '<img class="left-arrow" src="img/left-arrow.png">',
        nextArrow: '<img class="right-arrow" src="img/right-arrow.png">',
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 9999,
                settings: "unslick"
            },
            {
                breakpoint: 767,
                setting: {
                    speed: 300,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });

    $('.reviews__slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        prevArrow: '<img class="left" src="img/left.png">',
        nextArrow: '<img class="right" src="img/right.png">',
        slidesToShow: 2,
        slidesToScroll: 2,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    adaptiveHeight: true,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 520,
                settings: {
                    slidesToShow: 1,
                    adaptiveHeight: true,
                    slidesToScroll: 1
                }
            }
        ]
    });
});
