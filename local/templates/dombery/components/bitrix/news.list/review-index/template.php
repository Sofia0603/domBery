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
<div class="form-row " >
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>170, 'height'=>350), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, false, false, 90);
		?>

		<div class="col-12 col-md-4 mb-4 mb-md-0"  >
			<h3><?=$arItem['FIELDS']['NAME']?></h3>

            <div>
                <!-- img class="float-left mr-2" src="<?=$img['src']?>" / -->

                <? if ($arItem['FIELDS']['PREVIEW_TEXT']) { ?>
                    <div class="font-16 mb-3"><?=$arItem['FIELDS']['PREVIEW_TEXT']?></div>
                <? } ?>

                <? if ($arItem['DISPLAY_PROPERTIES']['TOWNSHIP']) { ?>
                    <div class="font-14 gray mb-2">Поселок: <span class="border-bottom border-dashed"><?=$arItem['DISPLAY_PROPERTIES']['TOWNSHIP']['DISPLAY_VALUE']?></span></div>
                <? } ?>

                <? if ($arItem['FIELDS']['DATE_ACTIVE_FROM']) { ?>
                    <div class="font-14 gray "><?=reset(explode(' ', $arItem['FIELDS']['DATE_ACTIVE_FROM']))?></div>
                <? } ?>
            </div>
		</div>
	<?endforeach;?>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
