<!-- Google Tag Manager -->
<script defer>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WC2MWQH');
</script>
<!-- End Google Tag Manager -->


<? if( strncmp($_REQUEST['page'], '/personal/', 10) == 0 ) { // is /personal/ ?>

<? } else { // not /personal/ ?>

    <script defer>
        (function(w,d,u){
            var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn-ru.bitrix24.ru/b28227822/crm/site_button/loader_1_2lg8vz.js');
    </script>

    <!-- Marquiz script start -->

    <?php
    $uri = $_SERVER['REQUEST_URI'];
    $target = '/catalog-map/';
    if (strstr($uri, $target) == false) {
    ?>
    <script defer>
        (function(w, d, s, o){
            var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() {
                if (document.readyState !== 'loading') Marquiz.init(o);
                else document.addEventListener("DOMContentLoaded", function() {
                    Marquiz.init(o);
                });
            };
            d.head.insertBefore(j, d.head.firstElementChild);
        })(window, document, 'script', {
                host: '//quiz.marquiz.ru',
                region: 'ru',
                id: '672b3b3879efd000261e7f29',
                autoOpen: false,
                autoOpenFreq: 'once',
                openOnExit: false,
                disableOnMobile: false
            }
        );
    </script>



    <!-- Marquiz script end -->

    <script defer>(function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Widget', {id: '672b3b3879efd000261e7f29', position: 'left', delay: 15, autoOpen: 120})</script>
    <?php }?>
    <? } ?>
