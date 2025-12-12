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
<div class="mainslider"  >
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
			<div class="mainslider-item " style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>)">
				<div class="mainslider-item-content">
					<div class="mainslider-item-title"><?=$arItem['NAME']?></div>
					<div class="font-20 px-lg-5 px-md-4"><?=$arItem['PREVIEW_TEXT']?></div>
				</div>
			</div>
	<?endforeach;?>
</div>
