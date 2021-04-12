$(document).ready(function () {

    function portfolioInit() {
        $('.cabinet__description-promo').slick({
            dots: true,
            infinite: true,
            adaptiveHeight: true,
            prevArrow: '<img class="prev-left" src="/img/prev-left.png">',
            nextArrow: '<img class="prev-right" src="/img/prev-right.png">',
            speed: 500,
            slidesToShow: 2,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        adaptiveHeight: true,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        adaptiveHeight: true,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    portfolioInit();

    $('#filter-client-orders').on('change', function () {
        var url = "/cabinet/client-orders/" + $(this).val();
        $(location).attr('href', url);
    });

    $('#filter-client-geo-search').on('change', function () {
        var url = "/cabinet/geo-masters/" + $(this).val();
        $(location).attr('href', url);
    });

    $('#filter-master-orders').on('change', function () {
        var url = "/cabinet/master-orders/" + $(this).val();
        $(location).attr('href', url);
    });

    $('#filter-client-notification').on('change', function () {
        var url = "/cabinet/client-notification/" + $(this).val();
        $(location).attr('href', url);
    });

    $('#filter-master-notification').on('change', function () {
        var url = "/cabinet/master-notification/" + $(this).val();
        $(location).attr('href', url);
    });

    $('#filter-search-orders').on('change', function () {
        var url = "/cabinet/search-order/" + $(this).val();
        $(location).attr('href', url);
    });

    $('#more-geo').on('click', function (e) {
        e.preventDefault();
        var exclude = $.map($('.cabinet-profile'), function(o){ return $(o).data('master-id')});
        exclude[exclude.length] = $('#filter-client-geo-search').val();
        $.ajax({
            url: "geo-masters",
            dataType: "html",
            data: "exclude=" + exclude,
            success: function(data){
                $(".cabinet-list .list-wrap").append(data);
                if ($('#masters-end').length) {
                    $('#more-geo').hide();
                }
                portfolioInit();
            },
            error: function (e) {
                alert('Произошла ошибка')
            }
        });
    });
});
