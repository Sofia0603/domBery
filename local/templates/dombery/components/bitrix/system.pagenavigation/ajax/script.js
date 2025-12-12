$(document).ready(function(){
    $('.page-main').on('click', '.btn-nextpage-ajax', function(){

        var targetSection = $(this).parent();
        var targetPagen = $(targetSection).data('navnum');
        var href = $(this).attr('href');

        $(this).load(href + ' *[data-navnum=' + targetPagen + '] > *', function(){
            $(this).children().unwrap();
        });

        return false;
    })
})
