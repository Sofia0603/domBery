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
$this->setFrameMode(true);?>

<h2 class="completed">Построенные и строящиеся дома</h2>
<div class="row align-items-stretch">
		<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), 
			array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$img = CFile::ResizeImageGet( $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['DETAIL_PICTURE']['ID'], 
			array('width'=>580, 'height'=>395), BX_RESIZE_IMAGE_EXACT, false, false, false, 80);
		?>
		<div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-5">
			<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
				<div class="catalog-list-item">
					<div class="position-relative">
						<img class="catalog-list-item-img" src="<?=$img['src']?>">
						<?if ($arItem['PROPERTIES']['SOLD']['VALUE'] == 'Y'):?>
							<div class="sold out">Продан</div>
						<?else:?>
							<div class="sold in-sale">На продажу</div>
						<?endif;?>
					</div>
					<h3><?=$arItem['NAME']?></h3>
					<h4><?=$arItem['PROPERTIES']['PLACE']['VALUE']?></h4>
					<h4>Площадь: <?=$arItem['PROPERTIES']['SQUARE']['VALUE']?> м<sup>2</sup></h4>
					<div class="separator"></div>
					<div class="price"><div class="left">Стоимость:</div><div class="right"><?=number_format(str_replace(' ','',$arItem['PROPERTIES']['PRICE']['VALUE']), 0, '', ' ');?> &#8381;</div></div>
					<?/*				<div class="price"><div class="left">Сдан:</div><div class="right"><?=$arItem['PROPERTIES']['SDAN']['VALUE'];?></div></div>*/?>
					<a class="detail-button" href="<?=$arItem['DETAIL_PAGE_URL']?>">Подробнее</a>
				</div>
			</a>
		</div>
		<?endforeach;?>
		<a href="/building/" class="all-items btn-primary">Посмотреть все дома</a>
</div>
