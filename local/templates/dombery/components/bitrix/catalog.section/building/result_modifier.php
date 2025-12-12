<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

foreach ($arResult['ITEMS'] as $key => &$arItem) $arItem['NAME'] = str_replace('м2', 'м<sup>2</sup>', $arItem['NAME']);


