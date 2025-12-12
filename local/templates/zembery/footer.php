<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
			</div>
		</section><!-- end main -->
		<!-- <div class="halloween-spider">
			<img src="/images/logo_halloween_spider.svg" />
		</div>
		<div class="halloween-spider right">
			<img src="/images/logo_halloween_spider.svg" />
		</div> -->

        <?
        if (!$GLOBALS['isWithoutBottomForm']) $APPLICATION->IncludeFile('/local/include/inc-bottom-callback.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"));
        ?>

			<footer >
				<!--<div class="container">
					<div class="row justify-content-between">
						<div class="col-12 col-sm-auto text-center">
							<a href="/"><img src="/images/logo.svg" /></a>
						</div>

						<div class="col-auto col-md-2 col-lg-2 col-xl-auto mb-4 footer-menu-col-1 d-lg-block">
							<?/*$APPLICATION->IncludeComponent(
									"bitrix:menu",
									"simple",
									array(
											"ROOT_MENU_TYPE" => "footer",
											"MAX_LEVEL" => "1",
											"USE_EXT" => "Y",
											"DELAY" => "N",
											"ALLOW_MULTI_SELECT" => "N",
											"MENU_CACHE_TYPE" => "A",
											"MENU_CACHE_TIME" => "3600",
											"MENU_CACHE_USE_GROUPS" => "N",
											"MENU_CACHE_GET_VARS" => array(),
											"COMPONENT_TEMPLATE" => "simple",
									),
									false
							);*/?>
						</div>

						<div class="col-auto col-md-2 col-lg-auto mb-4 footer-menu-col-2 d-lg-block">
							<?/*$APPLICATION->IncludeComponent(
									"bitrix:menu",
									"simple",
									array(
											"ROOT_MENU_TYPE" => "footer",
											"MAX_LEVEL" => "1",
											"USE_EXT" => "Y",
											"DELAY" => "N",
											"ALLOW_MULTI_SELECT" => "N",
											"MENU_CACHE_TYPE" => "A",
											"MENU_CACHE_TIME" => "3600",
											"MENU_CACHE_USE_GROUPS" => "N",
											"MENU_CACHE_GET_VARS" => array(),
											"COMPONENT_TEMPLATE" => "simple",
									),
									false
							);*/?>
						</div>

						<div class="col-auto col-md-3 col-lg-3 col-xl-auto mb-4 d-none d-sm-block">
							<div class="gray weight-500 mb-2">Контакты</div>
							<a class="d-block mb-2" href="tel:<?/*$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))*/?>">
								<?/*$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))*/?>
							</a>
							<?/*$APPLICATION->IncludeFile('/local/include/inc-contacts.php', array(), array('SHOW_BORDER'=>true))*/?>
							<br>
							<a class="green" href="mailto:<?/*$APPLICATION->IncludeFile('/local/include/inc-email.php', array(), array('SHOW_BORDER'=>false))*/?>">
								<?/*$APPLICATION->IncludeFile('/local/include/inc-email.php', array(), array('SHOW_BORDER'=>true))*/?>
							</a><br><br>
							<a class="green" href="/personaldata/">Политика в отношении<br>обработки персональных данных</a>
                        </div>

						<div class="col-sm-4 col-md-3 col-lg-auto mb-4  d-none d-sm-block">
							<div class="gray weight-500 mb-2">Время работы</div>
							<?/*$APPLICATION->IncludeFile('/local/include/inc-worktime-page_contacts.php', array(), array('SHOW_BORDER'=>true))*/?>
							<div class="gray weight-500 mb-2 mt-4">Общество с ограниченной <br>ответственностью "Зембери"</div>
							ИНН 5009127949<br>
							ОГРН 1215000060604
							<div class="mt-2 d-none ">
								<?/*$APPLICATION->IncludeFile('/local/include/inc-socnet.php', array(), array('SHOW_BORDER'=>true))*/?>
							</div>
						</div>

						<div class="col-auto mb-4 d-flex d-lg-block">
							<?/*$APPLICATION->IncludeFile('/local/include/inc-socnet.php', array(), array('SHOW_BORDER'=>true))*/?>

                            <div class="footer-pay-logo" >
                                <img src="/images/pay-logo-0.jpeg" />
                                <img src="/images/pay-logo-1.jpeg" />
                                <img src="/images/pay-logo-2.jpeg" />
                                <img src="/images/pay-logo-3.jpeg" />
                                <img src="/images/pay-logo-4.jpeg" />
                            </div>
						</div>
					</div>
				</div>-->

				<div class="footer-bottom mt-5">
					<br>
Общество с ограниченной ответственностью "Зембери" ИНН 5009127949 142000, Московская область, г Домодедово, мкр. Северный, ул Каширское Шоссе, д. 7, офис 406а<br>
					Материалы, представленные на сайте, не являются публичной офертой.<br>
					© <?php echo date("Y"); ?> Все права защищены.
				</div>
			</footer>

		<?/*		<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;1,600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">*/?>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
		<div id="callback" class="popup" style="display: none;">
			<img class="mb-2" src="/images/ico-question2-green.svg" />
			<h2>
				Остались вопросы?
			</h2>

			<div class="mb-3">
				<span class="gray">Свяжитесь с нами, по телефону</span> +7(495) 001-00-03 <span class="gray">или формой ниже, и мы с удовольствием обо всём расскажем.</span>
			</div>

			<div class="darkgray-bg rounded-lg px-3 pt-3">
				<form class="form-ajax row gx-2 justify-content-center" data-reachgoal="callback_form">
					<input type="hidden" name="form_name" value="Обратный звонок на главной странице">
					<div class="col-12 col-sm-6 mb-3">
						<input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
					</div>
					<div class="col-12 col-sm-6 mb-3">
						<input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
					</div>

            <? /* <input class="captchaSid" type="hidden" name="captcha_sid" value=""/>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend border">
                    <img class="jsReloadCaptcha captchaImg" alt="CAPTCHA"/>
                </div>

                <input class="form-control form-control-lg" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите код с картинки" required />
            </div> */ ?><input type="hidden" name="woc" value="1">
                    
			<div class="col-12">
        		<p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
       		</div>

            <div class="col-12 col-md-6 mb-3">
						    <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Обратный звонок">
            </div>
				</form>
			</div>
		</div>

		<? /*
<!-- Roistat Counter Start -->
<script>
(function(w, d, s, h, id) {
    w.roistatProjectId = id; w.roistatHost = h;
    var p = d.location.protocol == "https:" ? "https://" : "http://";
    var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init?referrer="+encodeURIComponent(d.location.href);
    var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
})(window, document, 'script', 'cloud.roistat.com', 'cf5a40c87b84a17dcd2468e49472d290');
</script>
<!-- Roistat Counter End -->

    <!-- BEGIN WHATSAPP INTEGRATION WITH ROISTAT -->

    <div class="js-whatsapp-message-container" style="display:none;">Обязательно отправьте это сообщение и дождитесь ответа. Ваш номер: {roistat_visit}</div>

    <script>

        (function() {

            if (window.roistat !== undefined) {

                handler();

            } else {

                var pastCallback = typeof window.onRoistatAllModulesLoaded === "function" ? window.onRoistatAllModulesLoaded : null;

                window.onRoistatAllModulesLoaded = function () {

                    if (pastCallback !== null) {

                        pastCallback();

                    }

                    handler();

                };

            }

            function handler() {

                function init() {

                    appendMessageToLinks();

                    var delays = [1000, 5000, 15000];

                    setTimeout(function func(i) {

                        if (i === undefined) {

                            i = 0;

                        }

                        appendMessageToLinks();

                        i++;

                        if (typeof delays[i] !== 'undefined') {

                            setTimeout(func, delays[i], i);

                        }

                    }, delays[0]);

                }

                function replaceQueryParam(url, param, value) {

                    var explodedUrl = url.split('?');

                    var baseUrl = explodedUrl[0] || '';

                    var query = '?' + (explodedUrl[1] || '');

                    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");

                    var queryWithoutParameter = query.replace(regex, "$1").replace(/&$/, '');

                    return baseUrl + (queryWithoutParameter.length > 2 ? queryWithoutParameter + '&' : '?') + (value ? param + "=" + value : '');

                }

                function appendMessageToLinks() {

                    var message = document.querySelector('.js-whatsapp-message-container').textContent;

                    var text = message.replace(/{roistat_visit}/g, window.roistatGetCookie('roistat_visit'));

                    text = encodeURI(text);

                    var linkElements = document.querySelectorAll('[href*="//wa.me"], [href*="//api.whatsapp.com/send"], [href*="//web.whatsapp.com/send"], [href^="whatsapp://send"]');

                    for (var elementKey in linkElements) {

                        if (linkElements.hasOwnProperty(elementKey)) {

                            var element = linkElements[elementKey];

                            element.href = replaceQueryParam(element.href, 'text', text);

                        }

                    }

                }

                if (document.readyState === 'loading') {

                    document.addEventListener('DOMContentLoaded', init);

                } else {

                    init();

                }

            };

        })();

    </script>

    <!-- END WHATSAPP INTEGRATION WITH ROISTAT -->

    <script>

        (function() {

            if (window.roistat !== undefined) {

                handler();

            } else {

                var pastCallback = typeof window.onRoistatAllModulesLoaded === "function" ? window.onRoistatAllModulesLoaded : null;

                window.onRoistatAllModulesLoaded = function () {

                    if (pastCallback !== null) {

                        pastCallback();

                    }

                    handler();

                };

            }

            function handler() {

                function init() {

                    appendMessageToLinks();

                    var delays = [1000, 5000, 15000];

                    setTimeout(function func(i) {

                        if (i === undefined) {

                            i = 0;

                        }

                        appendMessageToLinks();

                        i++;

                        if (typeof delays[i] !== 'undefined') {

                            setTimeout(func, delays[i], i);

                        }

                    }, delays[0]);

                }

                function replaceQueryParam(url, param, value) {

                    var explodedUrl = url.split('?');

                    var baseUrl = explodedUrl[0] || '';

                    var query = '?' + (explodedUrl[1] || '');

                    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");

                    var queryWithoutParameter = query.replace(regex, "$1").replace(/&$/, '');

                    return baseUrl + (queryWithoutParameter.length > 2 ? queryWithoutParameter  + '&' : '?') + (value ? param + "=" + value : '');

                }

                function appendMessageToLinks() {

                    var message = 'roistat_{roistat_visit}';

                    var text    = message.replace(/{roistat_visit}/g, window.roistatGetCookie('roistat_visit'));

                    text = encodeURI(text);

                    var linkElements = document.querySelectorAll('[href*="//t.me"]');

                    for (var elementKey in linkElements) {

                        if (linkElements.hasOwnProperty(elementKey)) {

                            var element = linkElements[elementKey];

                            element.href = replaceQueryParam(element.href, 'start', text);

                        }

                    }

                }

                if (document.readyState === 'loading') {

                    document.addEventListener('DOMContentLoaded', init);

                } else {

                    init();

                }

            };

        })();

    </script>
*/ ?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "json-list",
    Array(
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "DETAIL_URL" => "/#SECTION_CODE#/#ELEMENT_CODE#/",
        "ELEMENT_SORT_FIELD" => "NAME",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_ORDER2" => "desc",
        "HIDE_NOT_AVAILABLE" => "N",
        "IBLOCK_ID" => "1",
        "IBLOCK_TYPE" => "catalog",
        "INCLUDE_SUBSECTIONS" => "Y",
        "PAGE_ELEMENT_COUNT" => "999",
        "SET_BROWSER_TITLE" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
    )
);?>

<script defer>
    $(window).on("load", function() {
        var fired = false;

        $(window).one("mouseover click scroll", function() {
            if(!fired) {
                fired = true;
                $('#fired').load('/local/include/ajax-fired.php?page=<?=$_SERVER['REQUEST_URI']?>');
            }
        });

        setTimeout(function () {
            if(!fired) {
                fired = true;
                $('#fired').load('/local/include/ajax-fired.php?page=<?=$_SERVER['REQUEST_URI']?>');
            }
        }, 3000)
    });
</script>
<div id="fired"></div>
	</body>
</html>
<?
global $pageClass;
CModule::IncludeModule("iblock");
if ($arPageMeta = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "CODE" => $pageClass), false, Array("nPageSize"=>1), array("NAME", "PREVIEW_TEXT", "DETAIL_TEXT"))->GetNext()) {
    if ($arPageMeta['PREVIEW_TEXT']) $APPLICATION->SetPageProperty('title', $arPageMeta['PREVIEW_TEXT']);
    if ($arPageMeta['DETAIL_TEXT']) $APPLICATION->SetPageProperty('description', $arPageMeta['DETAIL_TEXT']);
    if ($arPageMeta['NAME']) $APPLICATION->SetPageProperty("H1", $arPageMeta['NAME']);
}

#сохраняем utm-метки в cookie
if(isset($_GET["utm_source"])) setcookie("utm_source",$_GET["utm_source"],time()+3600*24*30,"/");
if(isset($_GET["utm_medium"])) setcookie("utm_medium",$_GET["utm_medium"],time()+3600*24*30,"/");
if(isset($_GET["utm_campaign"])) setcookie("utm_campaign",$_GET["utm_campaign"],time()+3600*24*30,"/");
if(isset($_GET["utm_content"])) setcookie("utm_content",$_GET["utm_content"],time()+3600*24*30,"/");
if(isset($_GET["utm_term"])) setcookie("utm_term",$_GET["utm_term"],time()+3600*24*30,"/");

