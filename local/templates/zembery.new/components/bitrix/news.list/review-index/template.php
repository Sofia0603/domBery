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

<div class="feedback__block">
    <?foreach($arResult["ITEMS"] as $key => $arItem):?>
    <? $index = ($key + 1) < 10 ? '0' . ($key + 1) : ($key + 1);?>
        <div class="feedback__card">
            <p class="feedback__card-number"><?=$index;?></p>
            <h5 class="feedback__card-name"><?=$arItem['FIELDS']['NAME']?></h5>
            <? if ($arItem['FIELDS']['PREVIEW_TEXT']) { ?>
                <p class="feedback__card-text">
                    <?=$arItem['FIELDS']['PREVIEW_TEXT']?>
                </p>
            <? } ?>
            <? if ($arItem['DISPLAY_PROPERTIES']['TOWNSHIP']) { ?>
                <p class="feedback__card-location">Посёлок: <span class="feedback__card-location_link"><?=$arItem['DISPLAY_PROPERTIES']['TOWNSHIP']['DISPLAY_VALUE']?></span></p>
            <? } ?>
            <? if ($arItem['FIELDS']['DATE_ACTIVE_FROM']) { ?>
                <p class="feedback__card-date"><?=reset(explode(' ', $arItem['FIELDS']['DATE_ACTIVE_FROM']))?></p>
            <? } ?>
        </div>
    <?endforeach;?>
</div>

