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

$sortType = ( $_REQUEST['sort'] ? $_REQUEST['sort'] : ($_SESSION['build_sort'] ? $_SESSION['build_sort'] : 'sort_asc') );
$_SESSION['build_sort'] = $sortType;
switch ($sortType) {
    case 'sort_asc' :
        $sortField = 'SORT';
        $sortOrder = 'ASC';
        break;
    case 'sort_desc' :
        $sortField = 'SORT';
        $sortOrder = 'DESC';
        break;
    case 'price_asc' :
        $sortField = 'PROPERTY_PRICE_FOR_FINISH';
        $sortOrder = 'ASC';
        break;
    case 'price_desc' :
        $sortField = 'PROPERTY_PRICE_FOR_FINISH';
        $sortOrder = 'DESC';
        break;
    /*case 'floor_asc' :
        $sortField = 'PROPERTY_ONELINE_FLOOR';
        $sortOrder = 'ASC';
        break;
    case 'floor_desc' :
        $sortField = 'PROPERTY_ONELINE_FLOOR';
        $sortOrder = 'DESC';
        break;*/
    case 'square_asc' :
        $sortField = 'PROPERTY_ONELINE_AREA';
        $sortOrder = 'ASC';
        break;
    case 'square_desc' :
        $sortField = 'PROPERTY_ONELINE_AREA';
        $sortOrder = 'DESC';
        break;
}
?>
<h1><?=$APPLICATION->GetTitle()?></h1>

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
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => 0, // $arCurSection['ID'],
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
		//"SEF_RULE" => "/filter/#SMART_FILTER_PATH#/apply/", // $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
		//"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"], // $arResult["VARIABLES"]["SMART_FILTER_PATH"],
      "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
      "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
      'SHOW_ALL_WO_SECTION'=>'Y',
	),
	$component,
	array('HIDE_ICONS' => 'Y')
	);

}

?>
<?
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

<div class="font-14 mb-4 form-row align-items-center">
    <div class="col-auto gray">Сортировать по:</div>

    <div class="col-auto <?=($sortField !== 'SORT' ? 'gray':'')?> ">
        <a href="?sort=sort_<?=($sortOrder == 'ASC' ? 'desc' : 'asc')?>">
            Умолчанию
            <?=( $sortType == 'sort_asc' ? '<i class="fal fa-long-arrow-down ml-1"></i>' : ($sortType == 'sort_desc' ? '<i class="fal fa-long-arrow-up ml-1"></i>' : '') )?>
        </a>
    </div>

    <div class="col-auto <?=($sortField !== 'PROPERTY_PRICE_FOR_FINISH' ? 'gray':'')?> ">
        <a href="?sort=price_<?=($sortOrder == 'ASC' ? 'desc' : 'asc')?>">
            Цене
            <?=( $sortType == 'price_asc' ? '<i class="fal fa-long-arrow-down ml-1"></i>' : ($sortType == 'price_desc' ? '<i class="fal fa-long-arrow-up ml-1"></i>' : '') )?>
        </a>
    </div>

    <? /* <div class="col-auto <?=($sortField !== 'PROPERTY_ONELINE_FLOOR' ? 'gray':'')?> ">
        <a href="?sort=floor_<?=($sortOrder == 'ASC' ? 'desc' : 'asc')?>">
            Этажности
            <?=( $sortType == 'floor_asc' ? '<i class="fal fa-long-arrow-down ml-1"></i>' : ($sortType == 'floor_desc' ? '<i class="fal fa-long-arrow-up ml-1"></i>' : '') )?>
        </a>
    </div> */ ?>

    <div class="col-auto <?=($sortField !== 'PROPERTY_ONELINE_AREA' ? 'gray':'')?> ">
        <a href="?sort=square_<?=($sortOrder == 'ASC' ? 'desc' : 'asc')?>">
            Площади
            <?=( $sortType == 'square_asc' ? '<i class="fal fa-long-arrow-down ml-1"></i>' : ($sortType == 'square_desc' ? '<i class="fal fa-long-arrow-up ml-1"></i>' : '') )?>
        </a>
    </div>
</div>

<?$intSectionID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"building",
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
		"INCLUDE_SUBSECTIONS" => "Y", //$arParams["INCLUDE_SUBSECTIONS"],
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
		"SET_STATUS_404" => "Y", // $arParams["SET_STATUS_404"],
		"SHOW_404" => "Y", //$arParams["SHOW_404"],
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

		"SECTION_ID" => 0, // $arResult["VARIABLES"]["SECTION_ID"],
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
		"ADD_SECTIONS_CHAIN" => "N",
		'ADD_TO_BASKET_ACTION' => $basketAction,
		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
      "SHOW_ALL_WO_SECTION" => "Y",
      "BY_LINK" => "Y",

	),
	$component
);?>

<?
$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
unset($basketAction);

//$APPLICATION->IncludeFile('/local/include/inc-subscribe-offer.php', array(), array('SHOW_BORDER'=>true, 'MODE' => "html"));
?>
<!-- <br><br><br> -->
