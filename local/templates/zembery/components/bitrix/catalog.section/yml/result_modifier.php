<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */


foreach ($arResult['ITEMS'] as $key => &$arItem) {
    if ($arItem['PROPERTIES']['GDATA']['~VALUE']) {
        $arItem['PROPERTIES']['GDATA']['DATA'] = json_decode($arItem['PROPERTIES']['GDATA']['~VALUE']['TEXT'], true);
    }
}

//$arResult['ITEMS'] = array_slice($arResult['ITEMS'], 0, 2);