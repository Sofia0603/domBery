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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);


if ($_SESSION['sort']) $sortType = $_SESSION['sort'];
if ($_REQUEST['sort']) $sortType = $_SESSION['sort'] = $_REQUEST['sort'];

switch ($sortType) {
    case 'price_asc' :
        $sortField = 'PROPERTY_PRICE_PER_SQUARE';
        $sortOrder = 'ASC';
        break;
    case 'price_desc' :
        $sortField = 'PROPERTY_PRICE_PER_SQUARE';
        $sortOrder = 'DESC';
        break;
    case 'remoteness_asc' :
        $sortField = 'PROPERTY_REMOTENESS';
        $sortOrder = 'ASC';
        break;
    case 'remoteness_desc' :
        $sortField = 'PROPERTY_REMOTENESS';
        $sortOrder = 'DESC';
        break;
    default:
        $sortField = 'SORT';
        $sortOrder = 'ASC';
}

$APPLICATION->SetPageProperty("H1", $APPLICATION->GetTitle());
?>
<h1><?=$APPLICATION->ShowProperty('H1')?></h1>

<?
if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
$verticalGrid = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");


if ($arParams['USE_FILTER'] == 'Y') {
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);

	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"])) {
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	} elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"]) {
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
	}

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (Loader::includeModule("iblock"))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->Fetch())
				{
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}

	if (!isset($arCurSection)) {
		$arCurSection = array();
	}

	$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter",
	"new-filter",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arCurSection['ID'],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SAVE_IN_SESSION" => "N",
		"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		"SEF_MODE" => $arParams["SEF_MODE"],
		"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
		"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
	),
	$component,
	array('HIDE_ICONS' => 'Y')
	);

}


if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
}
else
{
	$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
}
$intSectionID = 0;

?>

<div class="font-14 mb-4 row gx-2 align-items-center">
    <div class="col-auto gray">Сортировать по:</div>

    <div class="col-auto <?=($sortField !== 'PROPERTY_PRICE_PER_SQUARE' ? 'gray':'')?> ">
        <a href="?sort=price_<?=($sortOrder == 'ASC' ? 'desc' : 'asc')?>">
            Цене
            <?=( $sortType == 'price_asc' ? '<i class="fal fa-long-arrow-down ms-1"></i>' : ($sortType == 'price_desc' ? '<i class="fal fa-long-arrow-up ms-1"></i>' : '') )?>
        </a>
    </div>

    <div class="col-auto <?=($sortField !== 'PROPERTY_REMOTENESS' ? 'gray':'')?> ">
        <a href="?sort=remoteness_<?=($sortOrder == 'ASC' ? 'desc' : 'asc')?>">
            Удаленности
            <?=( $sortType == 'remoteness_asc' ? '<i class="fal fa-long-arrow-down ms-1"></i>' : ($sortType == 'remoteness_desc' ? '<i class="fal fa-long-arrow-up ms-1"></i>' : '') )?>
        </a>
    </div>
</div>

<?$intSectionID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_SORT_FIELD2" => $sortField, // $arParams["ELEMENT_SORT_FIELD"],
		"ELEMENT_SORT_ORDER2" => $sortOrder, // $arParams["ELEMENT_SORT_ORDER"],
		"ELEMENT_SORT_FIELD" => 'PROPERTY_ALL_SOLD', //$arParams["ELEMENT_SORT_FIELD2"],
		"ELEMENT_SORT_ORDER" => 'ASC', //$arParams["ELEMENT_SORT_ORDER2"],
		"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
		"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

		"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
		"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
		'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
		'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
		'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
		'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
		'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"], // "N",
		'ADD_TO_BASKET_ACTION' => $basketAction,
		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
	),
	$component
);?>

<?
$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
unset($basketAction);

$APPLICATION->IncludeFile('/local/include/inc-subscribe-offer.php', array(), array('SHOW_BORDER'=>true, 'MODE' => "html"));
?>
<!--<div class="py-5">
<p>Подмосковье предлагает обширные возможности для покупки земельных участков, однако, при поиске подходящего необходимо обратить внимание на несколько ключевых аспектов, чтобы сделать правильный выбор:</p>
<ol>
<li><strong>Локация и доступность </strong>являются одними из важнейших факторов при выборе земельного участка в подмосковье. Рассмотрите близость крупных городов или населенных пунктов, наличие удобных транспортных магистралей и общественного транспорта. Также обратите внимание на близость к объектам инфраструктуры, таким как магазины, школы, больницы и развлекательные центры.</li>
<li><strong>Планирование и инфраструктура.</strong> Изучите планы развития района. Узнайте, есть ли планы по строительству новых дорог, магазинов, школ или других объектов, которые могут повлиять на комфортность проживания или ценность вашего подмосковного участка земли при продаже в будущем. Также важно проверить наличие коммуникаций, таких как электричество, вода, канализация и доступ к интернету.</li>
<li><strong>Изучите природные условия</strong>. Обратите внимание на рельеф местности, наличие лесов, рек, озер или других природных объектов. Они могут оказывать влияние на микроклимат и возможности для рекреации. Также узнайте о состоянии экологии в районе, чтобы убедиться, что окружающая среда безопасна. Мы советуем обратить внимание на земельные участки в домодедовском районе, который признан одним из самых экологичных, именно в нем находится большинство наших участков на продажу.</li>
<li><strong>Правовой статус</strong>. Обязательно проверьте все необходимые документы и убедитесь в их правильности и легитимности. Особое внимание уделите праву собственности, наличию ограничений или обременений, а также соблюдению зонирования и других правил строительства.</li>
<li><strong>Консультация с экспертами.</strong> Не стесняйтесь обратиться за консультацией к профессионалам в области недвижимости или юридическому сопровождению. Опытные риелторы и юристы помогут вам в выборе, предоставят информацию о рынке, помогут оценить риски и будут вашими союзниками во время оформления сделки. <br /><br /></li>
</ol>
<p>Выбор земельного участка в Подмосковье - ответственный и важный шаг. Учтите факторы локации, доступности, инфраструктуры, природных условий и правового статуса участка. Консультируйтесь с профессионалами, чтобы принять информированное решение.</p>
<p><br /></p>
</div> -->
