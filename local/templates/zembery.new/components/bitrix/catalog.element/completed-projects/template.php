<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

global $USER, $arPriceColor;

?>

<div class="detail-1">
    <div class="form-row align-items-stretch mb-lg-4">
        <div class="col-12 col-lg mb-4 mb-lg-0">
            <h1 class="mb-2">
                <?=trim($arResult['DISPLAY_PROPERTIES']['DETAIL_TITLE'] ? $arResult['DISPLAY_PROPERTIES']['DETAIL_TITLE']['DISPLAY_VALUE'] : $arResult['NAME'])?>
            </h1>
            <? if ($arResult['DISPLAY_PROPERTIES']['SIZE']) { ?>
                <div class="gray"><?=$arResult['DISPLAY_PROPERTIES']['SIZE']['NAME'].': '.$arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']?></div>
            <? } ?>
        </div>
    </div>

	<? if ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']) { ?>
		<div class="detail-slider">
			<? foreach ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] as $arPhotoItem) {
				$img = CFile::ResizeImageGet($arPhotoItem['ID'], array('width'=>736, 'height'=>414), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
				?>
				<a class="detail-slider-item" href="<?=$arPhotoItem['SRC']?>" data-fancybox="detail"><img class="<?=($isAllSold ? 'img-grayscale':'')?>" src="<?=$img['src']?>" /></a>
			<? } ?>
		</div>
	<? } ?>
</div>

<? if ($arResult['PREVIEW_TEXT']) { ?>
    <div class="my-5 pb-3">

        <div class="font-18" >
            <?=$arResult['PREVIEW_TEXT']?>
        </div>
    </div>
<? } ?>

<? if ($arResult['DETAIL_TEXT']) { ?>
	<div class="my-5 pb-3">
		<h2 class="mb-4">Описание</h2>

		<div class="text-limitation font-18" data-height="600">
			<?=$arResult['DETAIL_TEXT']?>
		</div>
	</div>
<? } ?>

