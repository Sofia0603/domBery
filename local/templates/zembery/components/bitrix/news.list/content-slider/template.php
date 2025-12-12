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
<div class="detail-slider">
    <?foreach($arResult["ITEMS"] as $key => $arItem) {
        $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>736, 'height'=>414), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
        ?>
        <a class="detail-slider-item" href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" data-fancybox="detail"><img class="" src="<?=$img['src']?>" /></a>
    <? } ?>
</div>
