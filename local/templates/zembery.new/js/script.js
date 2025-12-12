var timer = 0;
var q = '';

jQuery(document).ready(function($){

    $('[data-fancybox]').fancybox({
        helpers: { overlay: { locked: false } }
    })

    $('.form-ajax').submit(function(){
        var required_field = false;
        var form = $(this);

        var reachGoal = $(this).data('reachgoal');
        if (!!!reachGoal) reachGoal = 'send_form';
        ym(89571751,'reachGoal', reachGoal);

        var url = $(this).attr('action');
        if (url == undefined) url = '/local/include/ajax-feedback.php';
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: form.serialize()
        }).done(function(data) {

            if (data.success) {
                if (!!data.load_from) {
                    console.log('data.load_from', data.load_from);
                    $('.fancybox-slide--current > div').load(data.load_from);
                    setTimeout(function () {
                        form.trigger("reset");
                    }, 3000);
                    if (!!!data.load_from) {
                        setTimeout(function () {
                            $.fancybox.close();
                        }, 5000);
                    }
                } else {
                    $(form).append('<div class="alert alert-success w-100" role="alert">' + data.msg + '</div>')
                    form.trigger("reset");
                }
            } else {
                $(form).append('<div class="alert alert-danger  w-100" role="alert">' + data.errors + '</div>')
            }

            if (!!!data.load_from) {
                setTimeout(function () {
                    $('.form-ajax .alert').remove();
                }, 5000);
            }

        }).fail(function() {
            alert('Что то пошло не так попробуйте позже!');
        });
        return false;
    })

    $('.news-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        infinite: false,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                }
            }
        ]
    });

    $('.mainslider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 8000,
    });

    $('.text-limitation').each(function(){
        var block = $(this);
        var limit = block.data('height');
        var height = block.height();
        console.log('limit', limit);
        console.log('height', height);

        if (height > limit) {
            block.addClass('text-limited').height(limit).
            after('<button class="btn-limited-more"><span>Показать ещё</span></button>').
            next('button').click(function(){
                $(this).prev('.text-limited').removeClass('text-limited').height('auto');
                $(this).remove();
            });
        }
    })

    if ( $('.header-scrollmenu .top-menu a.active').length > 0 ) {
        a_posLeft = $('.header-scrollmenu .top-menu a.active').parent().position().left;
        //console.log('a_posLeft ' + a_posLeft);
        menu_width = $('.header-scrollmenu .top-menu').innerWidth();
        //console.log('menu_width ' + menu_width);
        scroll_left = a_posLeft - menu_width / 2;
        //console.log('scroll_left ' + scroll_left);
        $('.header-scrollmenu .top-menu').scrollLeft(scroll_left);
    }

    var scale = 100;
    $('.scale-btn-inc').click(function (){
        scale = scale + 20;
        $('#svg_wrap > svg').css('width', scale + '%');
        console.log('scale inc', scale);
    });

    $('.scale-btn-dec').click(function (){
        scale = scale - 20;
        if (scale < 100) scale = 100;
        $('#svg_wrap > svg').css('width', scale + '%');
        console.log('scale dec', scale);
    });

    $('.detail-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        infinite: true,
        variableWidth: true,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    /******************************/

    $('.jsShowCart').click(function(){
        if ( $('#cart').hasClass('active') ) {
            $('#cart').removeClass('active');
            $('.cart-iframe-wrap > *').remove();
        } else {
            $('#cart > .cart-iframe-wrap').append('<iframe id="cart-iframe" src="/personal/cart/" frameborder="" ></iframe>');
            $('#cart').addClass('active');
        }
    })
    $('.jsCartClose').click(function(){
        $('#cart').removeClass('active');
        $('.cart-iframe-wrap > *').remove();
        console.log('remove');
    })


    $('.mainmenu-btn-sublevel').click(function () {
        $(this).prev('a').toggleClass('expand');
        return false;
    })

    $('.btn-mmenu').click(function(){
        $('body').toggleClass('open-menu');
        $('.mainmenu-sublevel-open').removeClass('mainmenu-sublevel-open');
        return false;
    })



    $('.mask-phone').mask('+7 999 999-99-99', {clearIfNotMatch: true});


    $('.jsReloadCaptcha').click( function(){
        var form = $(this).closest('form');
        $.getJSON('/local/include/ajax-reload-captcha.php', function(data) {
            $(form).find('.captchaImg').attr('src','/bitrix/tools/captcha.php?captcha_sid='+data);
            $(form).find('.captchaSid').val(data);
            //$parent.find('.whiteBlock').hide();
        });
        return false;
    });
    $('.jsReloadCaptcha').each( function(){
        var form = $(this).closest('form');
        $.getJSON('/local/include/ajax-reload-captcha.php', function(data) {
            $(form).find('.captchaImg').attr('src','/bitrix/tools/captcha.php?captcha_sid='+data);
            $(form).find('.captchaSid').val(data);
        });
        return false;
    });

    $('.ajax-header-search-form .header-search-text').keyup(function() {
        if ( q == this.value ) return true;
        q = this.value;
        clearTimeout(timer);
        timer = setTimeout(get_search_result, 1000);
    });
    $('.ajax-header-search-form .header-search-text').focusout(function(){
        setTimeout(function (){
            $('.ajax-search-page').remove();
        }, 300);
    });

    $('.jsScrollTo').click(function () {
        $('html, body').stop().animate({
            scrollTop: $( $(this).attr('href') ).offset().top - 140
        }, 500);
        return false;
    })

    $('.jsViewPassword').mousedown(function(){
        $(this).siblings('input').prop('type', 'text');
    });
    $('.jsViewPassword').mouseup(function(){
        $(this).siblings('input').prop('type', 'password');
    });

})

function get_search_result() {
    $.ajax({
        url: '/local/include/ajax-search-suggest.php',
        method: 'get',
        dataType: 'html',
        data: { q: q }
    }).done(function(data) {
        $('.ajax-search-page').remove();
        if (!!data) {
            $('.ajax-header-search-form').after( data );
        }
    });
}

function popupmsg(content) {
    $.fancybox.open({
        src: '<div class="popup-msg">' + content + '</div>',
        type : 'inline',
        opts : {
            afterLoad: function (instance, current) {
                setTimeout(function(){
                    instance.close();
                }, 5000);
            }
        }
    });
}

function scroll2(anchor) {
    $('html, body').stop().animate({
        scrollTop: $('#' + anchor).offset().top - 120
    }, 500);
    return false;
}
