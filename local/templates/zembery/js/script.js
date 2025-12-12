var timer = 0;
var q = '';

function auto_layout_keyboard( str ) {
    replacer = {
        "q":"й", "w":"ц", "e":"у", "r":"к", "t":"е", "y":"н", "u":"г",
        "i":"ш", "o":"щ", "p":"з", "[":"х", "]":"ъ", "a":"ф", "s":"ы",
        "d":"в", "f":"а", "g":"п", "h":"р", "j":"о", "k":"л", "l":"д",
        ";":"ж", "'":"э", "z":"я", "x":"ч", "c":"с", "v":"м", "b":"и",
        "n":"т", "m":"ь", ",":"б", ".":"ю", "/":".",
        "й":"q", "ц":"w", "у":"e", "к":"r", "е":"t", "н":"y", "г":"u",
        "ш":"i", "щ":"o", "з":"p", "х":"[", "ъ":"]", "ф":"a", "ы":"s",
        "в":"d", "а":"f", "п":"g", "р":"h", "о":"j", "л":"k", "д":"l",
        "ж":";", "э":"'", "я":"z", "ч":"x", "с":"c", "м":"v", "и":"b",
        "т":"n", "ь":"m", "б":",", "ю":"."
    };

    return str.replace(/[A-zА-я/,.;\'\]\[]/g, function ( x ){
        return x == x.toLowerCase() ? replacer[ x ] : replacer[ x.toLowerCase() ].toUpperCase();
    });
}

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

        // добавляем параметр для борьбы со спамом
        url = url + '?AJAX=Y';

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
                    /*alert('Заявка успешно отправлена!');
                    $.fancybox.close();*/
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
        autoplay: false,
        autoplaySpeed: 2000,
    });

    $('.specialSlider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 2000,
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
    $('.specialItems').slick({
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



    $('.mask-phone').mask(
        '+7 Y99 999-99-99',
        {
            clearIfNotMatch: true,
            'translation': {
                Y: {pattern: /[012345679]/}
            }
        });


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
    });

    $('.ajax-header-search-form .header-search-text, .ajax-header-search-form .fly-search-text').keyup(function() {
        if ( q == this.value ) return true;
        q = this.value;
        q = q.toLowerCase();
        q_lk = auto_layout_keyboard(q);
        //console.log( q, q_lk );
        var form = $(this).parents('form');
        //$(this).parents('form').addClass('focus');
        //clearTimeout(timer);
        //timer = setTimeout(get_search_result, 1000);

        var ajaxsearchpage = "";
        if (q.length > 1) {
            $.each(arSearchData, function (inf, item) {
                if (item.NAME.toLowerCase().indexOf(q) > -1 || item.NAME.toLowerCase().indexOf(q_lk) > -1) {
                    ajaxsearchpage += '<a class="ajax-search-item" href="' + item.URL + '">' + item.NAME + '</a>';
                }
            })
        }
        $('.ajax-search-page').remove();
        if (ajaxsearchpage.length > 0) {
            form.append('<div class="ajax-search-page">' + ajaxsearchpage + '</div>');
        }
    });
     $('.ajax-header-search-form .header-search-text, .ajax-header-search-form .fly-search-text').focusout(function(){
        //$(this).parents('form').removeClass('focus');
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
            $('.ajax-header-search-form.focus').after( data );
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
//description
      $(document).ready(function () {
        $(".variable-width").slick({
          dots: false,
          infinite: true,
          speed: 300,
          slidesToShow: 1,
          centerMode: false,
          variableWidth: true,
        });

        // Обработчик для кнопки "Назад"
        $(".description__button-left").on("click", function () {
          $(".variable-width").slick("slickPrev");
        });

        // Обработчик для кнопки "Вперед"
        $(".description__button-right").on("click", function () {
          $(".variable-width").slick("slickNext");
        });
      });


$(document).ready(function () {
        // Инициализация слайдера
        var $slider = $(".feedback__slider").slick({
          dots: false,
          infinite: false,
          speed: 300,
          slidesToShow: 3,
          slidesToScroll: 3,
          responsive: [
            {
              breakpoint: 1222,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              },
            },
          ],
        });

        // Обработчики событий для кнопок
        $(".feedback__button__left").on("click", function () {
          $slider.slick("slickPrev"); // Переход к предыдущему слайду
        });

        $(".feedback__button__right").on("click", function () {
          $slider.slick("slickNext"); // Переход к следующему слайду
        });
      });




document.querySelectorAll(".map_button").forEach((el) => {
  el.addEventListener(
    "click",
    function (e) {
      // Убираем активный класс у всех кнопок
      document.querySelectorAll(".map_button").forEach((button) => {
        button.classList.remove("active");
      });
      // Добавляем активный класс к нажатой кнопке
      this.classList.add("active");
      // Получаем значение атрибута data-view нажатой кнопки
      const view = this.getAttribute("data-view");
      // Переключаем видимость блоков контента
      document.querySelectorAll(".about__block").forEach((block) => {
        if (block.getAttribute("data-view") === view) {
          block.classList.remove("d-none"); // Убираем класс для отображения блока
        } else {
          block.classList.add("d-none"); // Скрываем остальные блоки
        }
      });
    },
    true
  );
});
