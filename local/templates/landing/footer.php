<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>

			<footer >
				<div class="container">
					<div class="row justify-content-center justify-content-sm-between align-items-center">
						<div class="col-12 col-sm-auto text-center mb-4 mb-sm-0">
							<img src="/images/logo.svg" />
						</div>

                        <div class="col-auto border-right d-xl-none ml-sm-auto">
                            <a class="d-block mb-2 weight-500" href="tel:<?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))?>">
                                <?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))?>
                            </a>

                            <div class="gray font-12">
                                <?$APPLICATION->IncludeFile('/local/include/inc-worktime.php', array(), array('SHOW_BORDER'=>true))?>
                            </div>
                        </div>

                        <div class="col-auto d-xl-none">
                            <a class="btn btn-primary btn-lg" href="https://zembery.ru/">Посмотеть еще поселки</a>
                        </div>

						<div class="col-12 col-xl mt-4 mt-xl-0">
							<?$APPLICATION->IncludeComponent(
									"bitrix:menu",
									"simple",
									array(
											"ROOT_MENU_TYPE" => "landing",
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
							);?>
						</div>

                        <div class="col-auto border-right d-none d-xl-block">
                            <a class="d-block mb-2 weight-500" href="tel:<?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))?>">
                                <?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))?>
                            </a>

                            <div class="gray font-12">
                                <?$APPLICATION->IncludeFile('/local/include/inc-worktime.php', array(), array('SHOW_BORDER'=>true))?>
                            </div>
                        </div>

                        <div class="col-auto d-none d-xl-block">
                            <a class="btn btn-primary btn-lg" href="https://zembery.ru/">Посмотеть еще поселки</a>
                        </div>

					</div>
				</div>

				<div class="footer-bottom mt-5">
					Материалы, представленные на сайте, не являются публичной офертой.<br>
					© <?php echo date("Y"); ?> Все права защищены.
				</div>
			</footer>

		<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;1,600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">

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
        		<p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="#">персональных данных</a></p>
       		</div>

            <div class="col-12 col-md-6 mb-3">
						    <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Обратный звонок">
            </div>
				</form>
			</div>
		</div>

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


	</body>
</html>
<?
global $pageClass;
CModule::IncludeModule("iblock");
if ($arPageMeta = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "CODE" => $pageClass), false, Array("nPageSize"=>1), array("NAME", "PREVIEW_TEXT", "DETAIL_TEXT"))->GetNext()) {
    $APPLICATION->SetPageProperty('title', $arPageMeta['PREVIEW_TEXT']);
    $APPLICATION->SetPageProperty('description', $arPageMeta['DETAIL_TEXT']);
    $APPLICATION->SetPageProperty("H1", $arPageMeta['NAME']);
}

