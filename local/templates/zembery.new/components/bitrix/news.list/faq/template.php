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
<div class="faq-list " data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>" >
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

		if ($key > 0) echo '<hr class="my-4 border-dashed" />';
		?>
		<div class="faq-list-item "  id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
			<h2 class="btn-collapse <?=($key>-1 ? 'collapsed':'')?>" data-toggle="collapse" href="#" data-target="#target<?=$this->GetEditAreaId($arItem['ID']);?>"><?=$arItem['FIELDS']['NAME']?></h2>

			<? if ($arItem['FIELDS']['PREVIEW_TEXT']) { ?>
				<div class="font-18 mb-3 collapse <?//=($key==0 ? 'show':'')?>" id="target<?=$this->GetEditAreaId($arItem['ID']);?>">
					<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
				</div>
			<? } ?>
		</div>
	<?endforeach;?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
