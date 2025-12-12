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
        <a class="d-block position-relative" href="<?=$arItem['DISPLAY_PROPERTIES']['URL']['VALUE']?>">
            <img class="w-100 d-block d-md-none" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" />
            <img class="w-100 d-none d-md-block" src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" />
            <? if ($arItem['DISPLAY_PROPERTIES']['VIDEO']) { ?>
            <video class="video-in-slider" poster="<?=$arItem['DETAIL_PICTURE']['SRC']?>" no-controls autoplay loop playsinline muted tabindex="0">
                <source src="<?=$arItem['DISPLAY_PROPERTIES']['VIDEO']['FILE_VALUE']['SRC']?>"  />
                <video>
                    <? } ?>
        </a>
    <?endforeach;?>
</div>
