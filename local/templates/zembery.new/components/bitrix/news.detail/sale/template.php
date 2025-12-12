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

$img = CFile::ResizeImageGet( $arResult['FIELDS']['DETAIL_PICTURE']['ID'] ? $arResult['FIELDS']['DETAIL_PICTURE']['ID'] : $arResult['FIELDS']['PREVIEW_PICTURE']['ID'], array('width'=>1200, 'height'=>1200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 90);
?>
<div class="sale-detail">
	<div class="row mb-4">
		<div class="col-12 col-lg-8">
			<h1 class="mb-4"><?=$arResult['NAME']?></h1>

            <div class="d-flex align-items-center">
                <? if ($arResult['FIELDS']['DATE_ACTIVE_FROM']) { ?>
                    <div class="gray "><?=reset(explode(' ', $arResult['FIELDS']['DATE_ACTIVE_FROM']))?></div>
                <? } ?>

                <? if ($arResult['DISPLAY_PROPERTIES']['ACTION_EXPIRED']) {
                    echo '<div class="sale-list-item-expired ml-auto position-static">'.$arResult['DISPLAY_PROPERTIES']['ACTION_EXPIRED']['NAME'].'</div>';
                } ?>
            </div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-12 col-lg-8 article">
			<? if ($img) { ?>
				<img class="d-block mx-auto mw-100 mb-4 rounded <?=($arResult['DISPLAY_PROPERTIES']['ACTION_EXPIRED'] ? 'is-expired':'')?>" src="<?=$img['src']?>" />
			<? } ?>
			
			<?=$arResult['FIELDS']['DETAIL_TEXT']?>
		</div>

		<div class="col-12 col-lg-4">
			<?$APPLICATION->IncludeFile('/local/include/inc-subscribe-sale-right.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"))?>
		</div>
	</div>
</div>
