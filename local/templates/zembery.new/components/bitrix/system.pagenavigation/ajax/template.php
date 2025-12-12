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

if ($arResult['NavPageNomer'] < $arResult['NavPageCount']) { ?>
	<a class="btn-nextpage-ajax" href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>"><span><i class="fal fa-sync mr-3"></i>Показать ещё</span></a>
<? }
