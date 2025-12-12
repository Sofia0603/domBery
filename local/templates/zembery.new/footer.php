<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>

		<!-- <div class="halloween-spider">
			<img src="/images/logo_halloween_spider.svg" />
		</div>
		<div class="halloween-spider right">
			<img src="/images/logo_halloween_spider.svg" />
		</div> -->

        <?
        if (!$GLOBALS['isWithoutBottomForm']) $APPLICATION->IncludeFile('/local/include/inc-bottom-callback.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"));
        ?>

    <footer class="footer">
        <div class="container">
            <div class="row justify-content-center justify-content-md-between">
                <div class="col-12 col-md-auto">
                    <img class="footer__logo" src="<?=SITE_TEMPLATE_PATH?>/image/Logo-ZemBery footer.svg" alt="" />
                </div>
                <div class="col-auto">
                    <nav class="footer__links footer__links-first footer-menu-col-1">
                        <?$APPLICATION->IncludeComponent(
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
							);?>
                    </nav>
                </div>
                <div class="col-auto">
                    <nav class="footer__links footer__links-second footer-menu-col-2">
                    <?$APPLICATION->IncludeComponent(
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
							);?>
                    </nav>
                </div>
                <div class="col-auto">
                    <div class="footer__contact">
                        <h6 class="footer__title">Контакты</h6>
                        <a class="footer__paragraph" href="tel:<?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))?>">
                            <?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))?>
                        </a>
                        <p class="footer__paragraph">Московская область, г. Домодедово, Каширское шоссе, 7</p>
                        <a class="footer__contact-email" href="mailto:<?$APPLICATION->IncludeFile('/local/include/inc-email.php', array(), array('SHOW_BORDER'=>false))?>">
                            <?$APPLICATION->IncludeFile('/local/include/inc-email.php', array(), array('SHOW_BORDER'=>true))?>
                        </a>
                    </div>
                    <div class="footer__time">
                        <h6 class="footer__title">Время работы</h6>
                        <p class="footer__paragraph"><?$APPLICATION->IncludeFile('/local/include/inc-worktime.php', array(), array('SHOW_BORDER'=>true))?></p>
                    </div>
                </div>
                
                <div class="col-auto">
                    <div class="footer__social-networks">
                        <a href="https://vk.com/club224391057" target="_blank"><img src="<?=SITE_TEMPLATE_PATH?>/image/Vk, Vkontakte.svg" alt="Лого VK" /></a>
                        <a href="https://wa.me/+79163351130" target="_blank"><img src="<?=SITE_TEMPLATE_PATH?>/image/Group.svg" alt="Лого WhatsApp" /></a>
                        <a href="https://t.me/zembery1" target="_blank"><img src="<?=SITE_TEMPLATE_PATH?>/image/telegram-2-app-circle.svg" alt="Лого TG" /></a>
                    </div>
                </div>
            </div>

        </div>

    </footer>
    <div class="prava">
        <div class="container">
            <p class="prava__text">&#xA9; 2024 Все права защищены.</p>
        </div>
    </div>

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
				<form class="form-ajax form-row" data-reachgoal="callback_form">
					<input type="hidden" name="form_name" value="Обратный звонок на главной странице">
					<div class="col-12 col-sm mb-3">
						<input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
					</div>
					<div class="col-12 col-sm mb-3">
						<input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
					</div>
					<div class="col-12 col-md mb-3">
						<input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Обратный звонок">
					</div>
				</form>
			</div>
		</div>
        </div>
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

