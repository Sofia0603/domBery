/**
 * Created by yarmol on 01.06.2022.
 */
$(document).ready(function(){
    $('.detail-top-slider').slick({
        infinite: true,
        slidesToShow: 1,
        arrows: false,
        dots: true,
    });

    $('.detail-price').click(function () {
        $(this).toggleClass('open');
    })

    $('.detail-price-wrap').mouseleave(function(){
        $(this).siblings('.open').removeClass('open');
    });


    $('.jsFavorites').click(function(){
        var favoritesJson = BX.getCookie('favorites');

        console.log('favoritesJson', favoritesJson);

        if (!!favoritesJson) {
            var favoritesArr = JSON.parse(favoritesJson);
        } else {
            favoritesArr = new Array();
        }

        var id = $(this).data('id');

        console.log('index of', favoritesArr.indexOf(id));
        console.log('favoritesArr', favoritesArr);

        if (favoritesArr.includes(id)) {
            $(this).removeClass('green');
            favoritesArr.splice( favoritesArr.indexOf(id), 1 );
        } else {
            $(this).addClass('green');
            favoritesArr.push(id);
        }

        console.log('favoritesArr', favoritesArr);

        BX.setCookie('favorites', JSON.stringify(favoritesArr), {expires: 2592000, path: '/'});
        $(this).blur();
        return false;
    })

    $('.jsCompare').click(function(){
        var AddedGoodId = $(this).data('id');

        if ( $(this).hasClass("green") ) {
            $(this).removeClass("green");
            $.get("/local/include/ajax-compare-action.php",
                {
                    action: "DELETE_FROM_COMPARE_LIST", id: AddedGoodId},
                function(data) {
                    //$("#compare_list_count").html(data);
                    popupmsg('<div class="text-center"><h5>' + data.MESSAGE + '</h5><br>' +
                        '<p>Вы можете перейти к сравнению, или добавить еще один объект.<br> Для добавления еще одного объекта перейдите на его страницу<br> и нажмите кнопку Сравнить.</p>' +
                        '<a class="btn btn-primary mr-4" href="/compare/">Сравнить</a> <a class="btn btn-outline-primary" href="/catalog/">Добавить еще к сравнению</a>')
                    $('.jsCompare > .count').html('(' + data.COUNT + ')');
                }
            );
        } else {
            $(this).addClass("green");
            $.get("/local/include/ajax-compare-action.php",
                {
                    action: "ADD_TO_COMPARE_LIST", id: AddedGoodId},
                function(data) {
                    //$("#compare_list_count").html(data);
                    popupmsg('<div class="text-center"><h5>' + data.MESSAGE + '</h5><br>' +
                        '<p>Вы можете перейти к сравнению, или добавить еще один объект.<br> Для добавления еще одного объекта перейдите на его страницу<br> и нажмите кнопку Сравнить.</p>' +
                        '<a class="btn btn-primary mr-4" href="/compare/">Сравнить</a> <a class="btn btn-outline-primary" href="/catalog/">Добавить еще к сравнению</a>')
                    $('.jsCompare > .count').html('(' + data.COUNT + ')');
                }
            );
        }

        return false;
    })

})
