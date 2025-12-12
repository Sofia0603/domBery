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
	$itemStyle = 'col-6 col-sm-6 col-md-6 col-lg-3 mb-5';
	$wrapStyle = 'row';
}

?>
<div class="partners-list <?=$wrapStyle?>" data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>" >
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="<?=$itemStyle?> "  id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
			<div class="partners-list-item ">
				<div class="partners-list-item-img-area" >
					<img src="<?=$arItem['FIELDS']['PREVIEW_PICTURE']['SRC']?>" />
				</div>

				<div class="text-center"><?=$arItem['FIELDS']['NAME']?></div>

				<? if ($arItem['DISPLAY_PROPERTIES']['URL']) { ?>
					<a class="stretched-link" href="<?=$arItem['DISPLAY_PROPERTIES']['URL']['VALUE']?>" target="_blank" ></a>
				<? } ?>
			</div>
		</div>
	<?endforeach;?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
