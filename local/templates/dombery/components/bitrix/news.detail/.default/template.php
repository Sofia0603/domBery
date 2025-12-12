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

$img = CFile::ResizeImageGet( $arResult['FIELDS']['DETAIL_PICTURE']['ID'] ? $arResult['FIELDS']['DETAIL_PICTURE']['ID'] : $arResult['FIELDS']['PREVIEW_PICTURE']['ID'], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 90);
?>
<div class="news-detail">
	<div class="row mb-4">
		<div class="col-12 col-lg-8">
            <? if ($arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']) { ?>
                <div class="mb-3">
                    <?=$arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE']?>
                </div>
            <? } ?>

			<h1 class="mb-4"><?=$arResult['NAME']?></h1>

			<? if ($arResult['FIELDS']['DATE_ACTIVE_FROM']) { ?>
				<div class="gray "><?=reset(explode(' ', $arResult['FIELDS']['DATE_ACTIVE_FROM']))?></div>
			<? } ?>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-12 col-lg-8 article">
			<? if ($img) { ?>
				<img class="d-block mx-auto mw-100 mb-4 rounded" src="<?=$img['src']?>" />
			<? } ?>
			
			<?=$arResult['FIELDS']['DETAIL_TEXT']?>
		</div>

		<div class="col-12 col-lg-4">
			<?$APPLICATION->IncludeFile('/local/include/inc-subscribe-right.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"))?>
		</div>
	</div>
</div>

