<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
    </div>
    </section>
    <!-- end main -->
        <?
        if (!$GLOBALS['isWithoutBottomForm']) $APPLICATION->IncludeFile('/local/include/inc-dombery-bottom-callback.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"));
        ?>

			<footer >
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-12 col-sm-auto text-center">
							<a href="/"><img src="/images/logo.svg" /></a>
						</div>

						<div class="col-auto mb-4 footer-menu-col-1 d-lg-block" style="display:none!important;">
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
						</div>

						<div class="col-auto mb-4 footer-menu-col-2 d-lg-block" style="display:none!important;">
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
						</div>

						<div class="col-12 col-sm-auto ">
							<div class="gray weight-500 mb-2">Контакты</div>
							<a class="d-block mb-2" href="tel:<?$APPLICATION->IncludeFile('/local/include/inc-phone-dombery.php', array(), array('SHOW_BORDER'=>false))?>">
								<?$APPLICATION->IncludeFile('/local/include/inc-phone-dombery.php', array(), array('SHOW_BORDER'=>true))?>
							</a>
							<?$APPLICATION->IncludeFile('/local/include/inc-contacts-dombery.php', array(), array('SHOW_BORDER'=>true))?>
							<br>
							<a class="green" href="matlto:<?$APPLICATION->IncludeFile('/local/include/inc-email-dombery.php', array(), array('SHOW_BORDER'=>false))?>">
								<?$APPLICATION->IncludeFile('/local/include/inc-email-dombery.php', array(), array('SHOW_BORDER'=>true))?>
							</a>
                        </div>

						<div class="col-12 col-sm-auto ">
							<div class="gray weight-500 mb-2">Время работы</div>
							<?$APPLICATION->IncludeFile('/local/include/inc-worktime-dombery.php', array(), array('SHOW_BORDER'=>true))?>
							<div class="gray weight-500 mb-2 mt-4">
                  <?$APPLICATION->IncludeFile('/local/include/inc-footer1-dombery.php', array(), array('SHOW_BORDER'=>true))?>
              </div>
                <?$APPLICATION->IncludeFile('/local/include/inc-footer2-dombery.php', array(), array('SHOW_BORDER'=>true))?>

							<div class="mt-2 d-md-none ">
								<?$APPLICATION->IncludeFile('/local/include/inc-socnet-dombery.php', array(), array('SHOW_BORDER'=>true))?>
							</div>
						</div>

						<div class="col-auto mb-4 d-none d-md-block">
							<?$APPLICATION->IncludeFile('/local/include/inc-socnet-dombery.php', array(), array('SHOW_BORDER'=>true))?>
						</div>
					</div>
				</div>

				<div class="footer-bottom mt-5">
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
				<form class="form-ajax form-row" data-reachgoal="callback_form" action="/local/include/ajax-feedback-dombery.php">
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

