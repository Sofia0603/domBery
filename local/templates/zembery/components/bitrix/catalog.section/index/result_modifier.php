<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

if (!isset($arParams['LINE_ELEMENT_COUNT']))
	$arParams['LINE_ELEMENT_COUNT'] = 3;
$arParams['LINE_ELEMENT_COUNT'] = intval($arParams['LINE_ELEMENT_COUNT']);
if (2 > $arParams['LINE_ELEMENT_COUNT'] || 5 < $arParams['LINE_ELEMENT_COUNT'])
	$arParams['LINE_ELEMENT_COUNT'] = 3;

foreach ($arResult['ITEMS'] as $key => &$arItem) {
	$arOneLineProp = array();
	if ($arItem['DISPLAY_PROPERTIES']['SHOSSE']) $arOneLineProp[] = $arItem['DISPLAY_PROPERTIES']['SHOSSE']['DISPLAY_VALUE'] . ' шоссе';
	if ($arItem['DISPLAY_PROPERTIES']['REGION']) $arOneLineProp[] = $arItem['DISPLAY_PROPERTIES']['REGION']['DISPLAY_VALUE'] . ' г. о.';
    if ($arItem['DISPLAY_PROPERTIES']['REMOTENESS']) $arOneLineProp[] = $arItem['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE'] . '&nbsp;км&nbsp;от&nbsp;МКАД';
	if ($arOneLineProp) $arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']['DISPLAY_VALUE'] = implode(', ', $arOneLineProp);
	unset($arItem['DISPLAY_PROPERTIES']['SHOSSE']);
	unset($arItem['DISPLAY_PROPERTIES']['REGION']);

	if ($arItem['DISPLAY_PROPERTIES']['ADVANTAGES']) {
		foreach ($arItem['DISPLAY_PROPERTIES']['ADVANTAGES']['VALUE_XML_ID'] as $keyAdv => $arAdvItem) {
			$arItem['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'][ $keyAdv ] = '<span class="advantages-item advantages-item-mini" >';
			$arItem['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'][ $keyAdv ] .= '<img src="/images/ico-'.$arAdvItem.'.svg" title="'.$arItem['DISPLAY_PROPERTIES']['ADVANTAGES']['VALUE'][ $keyAdv ].'" />';
			$arItem['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'][ $keyAdv ] .= '</span>';
		}
	}

	if ($arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) {
		$arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE'] = CCurrencyLang::CurrencyFormat( $arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['VALUE'], 'RUB' );
	}
}

