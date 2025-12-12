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
<div class="review-list " data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>" >
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>170, 'height'=>350), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, false, false, 90);

		if ($key > 0) echo '<hr class="my-4 border-dashed" />';
		?>

		<div class="<?=$itemStyle?> "  id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
			<h2><?=$arItem['FIELDS']['NAME']?></h2>

            <div class="row">
                <? if ($img) { ?>
                    <a class="col-12 col-sm-auto" href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" data-fancybox ><img class="" src="<?=$img['src']?>" /></a>
                <? } ?>

                <div class="col-12 col-sm">
                    <? if ($arItem['FIELDS']['PREVIEW_TEXT']) { ?>
                        <div class="font-18 mb-3"><?=$arItem['FIELDS']['PREVIEW_TEXT']?></div>
                    <? } ?>

                    <? if ($arItem['DISPLAY_PROPERTIES']['TOWNSHIP']) { ?>
                        <div class="font-14 gray mb-2">Поселок: <span class="border-bottom border-dashed"><?=$arItem['DISPLAY_PROPERTIES']['TOWNSHIP']['DISPLAY_VALUE']?></span></div>
                    <? } ?>

                    <? if ($arItem['FIELDS']['DATE_ACTIVE_FROM']) { ?>
                        <div class="font-14 gray "><?=reset(explode(' ', $arItem['FIELDS']['DATE_ACTIVE_FROM']))?></div>
                    <? } ?>
                </div>
            </div>
		</div>
	<?endforeach;?>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
