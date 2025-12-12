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

<div class="mainslider -v2 d-flex">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<a class="d-block " href="<?=$arItem['DISPLAY_PROPERTIES']['URL']['VALUE']?>">
            <img class="w-100 d-block d-md-none" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" />
            <img class="w-100 d-none d-md-block" src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" />
		</a>
	<?endforeach;?>
</div>
