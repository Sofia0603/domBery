<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<h1><?=$arParams['PAGER_TITLE']?></h1>

<div class="mb-4">
	<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"pills",
			array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => "",
					"SECTION_CODE" => "",
					"CURRENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
					"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
					"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
					"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
					"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
			),
			$component,
			array("HIDE_ICONS" => "Y")
	);?>
</div>

<div class="row mb-4 mb-5">
	<div class="col-12 col-lg-8 mb-5">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"vacancy",
			Array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"NEWS_COUNT" => $arParams["NEWS_COUNT"],

				"SORT_BY1" => $arParams["SORT_BY1"],
				"SORT_ORDER1" => $arParams["SORT_ORDER1"],
				"SORT_BY2" => $arParams["SORT_BY2"],
				"SORT_ORDER2" => $arParams["SORT_ORDER2"],

				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
				"CHECK_DATES" => $arParams["CHECK_DATES"],
				"STRICT_SECTION_CHECK" => $arParams["STRICT_SECTION_CHECK"],
				"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
				"SEARCH_PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"],

				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

				"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
				"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"SET_BROWSER_TITLE" => "Y",
				"SET_META_KEYWORDS" => "Y",
				"SET_META_DESCRIPTION" => "Y",
				"MESSAGE_404" => $arParams["MESSAGE_404"],
				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
				"SHOW_404" => $arParams["SHOW_404"],
				"FILE_404" => $arParams["FILE_404"],
				"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
				"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
				"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
				"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],

				"PARENT_SECTION" => $arResult["VARIABLES"]["SECTION_ID"],
				"PARENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"INCLUDE_SUBSECTIONS" => "Y",

				"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
				"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
				"MEDIA_PROPERTY" => $arParams["MEDIA_PROPERTY"],
				"SLIDER_PROPERTY" => $arParams["SLIDER_PROPERTY"],

				"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
				"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
				"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
				"PAGER_TITLE" => $arParams["PAGER_TITLE"],
				"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
				"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
				"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
				"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
				"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
				"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
				"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

				"USE_RATING" => $arParams["USE_RATING"],
				"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
				"MAX_VOTE" => $arParams["MAX_VOTE"],
				"VOTE_NAMES" => $arParams["VOTE_NAMES"],

				"USE_SHARE" => $arParams["LIST_USE_SHARE"],
				"SHARE_HIDE" => $arParams["SHARE_HIDE"],
				"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
				"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
				"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
				"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],

				"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
			),
			$component
		);?>

	</div>

	<div class="col-12 col-lg-4">
		<div class="gray-bg p-4 rounded-lg">
			<img class="mb-2" src="/images/ico-question-green.svg" />
			<h2>
				Не нашли вакансию?
			</h2>

			<div class="gray mb-3">
				Квалифицированные сотрудники отвечали на все мои вопросы, дружелюбно рассказывали о плюсах и минусах разных посёлков
			</div>

			<a class="btn btn-lg btn-primary btn-block" href="#resume" data-fancybox >Отправить резюме</a>
		</div>

		<div id="resume" class="popup-mini" style="display: none;">
			<h2 class="mb-4">
				Не нашли вакансию?
			</h2>
			<form class="form-ajax form-row">
				<input type="hidden" name="form_name" value="Отправить резюме на странице вакансий">
				<div class="col-12  mb-3">
					<input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
				</div>
				<div class="col-12  mb-3">
					<input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
				</div>
				<div class="col-12  mb-3">
					<input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Отправить резюме">
				</div>
			</form>
		</div>
	</div>
</div>

<br><br><br><br>
