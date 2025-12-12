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

if ($arParams['IS_SLYDER'] == "Y") {
	$itemStyle = '';
	$wrapStyle = 'news-slider';
} else {
	$itemStyle = 'col-12 col-sm-6 col-md-6 col-lg-4 mb-5';
	$wrapStyle = 'row';
}

?>
<div class="news-list <?=$wrapStyle?>" data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>" ><?
	foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$img = CFile::ResizeImageGet( $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['DETAIL_PICTURE']['ID'], array('width'=>580, 'height'=>395), BX_RESIZE_IMAGE_EXACT, false, false, false, 80);
		?>
		<div class="<?=$itemStyle?> "  id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
			<div class="news-list-item ">
				<? if ($img) { ?>
					<div class="news-list-item-img-area" >
						<img class="mw-100" src="<?=$img['src']?>" />

						<? if ($arItem['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']) { ?>
                            <div class="news-list-item-img-label-wrap">
                                <? if (is_array($arItem['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE'])) {
                                    foreach ($arItem['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE'] as $lnk_township) {
                                        echo '<div class="news-list-item-img-label">'. strip_tags( $lnk_township ) . '</div>';
                                    }
                                } else { ?>
                                    <div class="news-list-item-img-label">
                                        <?=strip_tags( $arItem['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE'])?>
                                    </div>
                                <? } ?>
                            </div>
						<? } ?>
					</div>

				<? } ?>

				<h3><?=$arItem['FIELDS']['NAME']?></h3>

				<? if ($arItem['FIELDS']['PREVIEW_TEXT']) { ?>
					<div class="mb-2"><?=$arItem['FIELDS']['PREVIEW_TEXT']?></div>
				<? } ?>

				<? if ($arItem['FIELDS']['DATE_ACTIVE_FROM']) { ?>
					<div class="font-14 gray "><?=reset(explode(' ', $arItem['FIELDS']['DATE_ACTIVE_FROM']))?></div>
				<? } ?>

				<a class="stretched-link" href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>
			</div>
		</div><?
	endforeach;
    if($arParams["DISPLAY_BOTTOM_PAGER"]):
        echo $arResult["NAV_STRING"];
    endif;

?></div>
