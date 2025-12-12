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
			<h2 class="btn-collapse <?=($key>0 ? 'collapsed':'')?>" data-toggle="collapse" href="#" data-target="#target<?=$this->GetEditAreaId($arItem['ID']);?>"><?=$arItem['FIELDS']['NAME']?></h2>

			<div class=" collapse pt-3 font-18 <?=($key==0 ? 'show':'')?>" id="target<?=$this->GetEditAreaId($arItem['ID']);?>">

				<div class="font-18 mb-3" >
					<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
				</div>

				<? foreach ($arItem['DISPLAY_PROPERTIES']['DESCRIPTION']['DISPLAY_VALUE'] as $descrKey => $descriptionHtml) { ?>
					<div class="weight-600 mb-2"><?=$arItem['DISPLAY_PROPERTIES']['DESCRIPTION']['DESCRIPTION'][$descrKey]?></div>
					<div class="mb-4"><?=$descriptionHtml?></div>
				<? } ?>

				<a class="btn btn-lg btn-primary my-3" href="#resume-<?$arItem['ID']?>" data-fancybox >Откликнуться</a>
			</div>

			<div id="resume-<?$arItem['ID']?>" class="popup-mini" style="display: none;">
				<h2 class="mb-4">
					Откликнуться на вакансию "<?=$arItem['NAME']?>"
				</h2>
				<form class="form-ajax form-row">
					<input type="hidden" name="form_name" value="Откликнуться на вакансию <?=$arItem['NAME']?>">
					<div class="col-12  mb-3">
						<input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
					</div>
					<div class="col-12  mb-3">
						<input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
					</div>
					<div class="col-12  mb-3">
						<input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Отправить резюме">
					</div>
				</form>
			</div>
		</div>
	<?endforeach;?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
