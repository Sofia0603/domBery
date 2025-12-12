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
	$wrapStyle = 'row align-items-stretch';
}
?>

<script>
	window.productsForMap = [
		<? foreach ($arResult['ITEMS'] as $key => $arItem) {
		$img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>494, 'height'=>370), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);
		$isAllSold = $arItem['DISPLAY_PROPERTIES']['ALL_SOLD']['VALUE'];
		?>
		{
			name: "<?=$arItem['NAME']?>",
			geopoint: "<?=$arItem['DISPLAY_PROPERTIES']['GEOPOINT']["VALUE"]?>",
			image: "<?=$img['src']?>",
			link: "/catalog<?=$arItem['DETAIL_PAGE_URL']?>",
			price: "<?=$arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE']?>",
			description: "<?=$arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']['DISPLAY_VALUE']?>",
			isAllSold: <?= $isAllSold ? 'true' : 'false' ?>,
			advantages: [
				<?php
				$advantages = $arItem['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'];
				foreach ($advantages as $key => $arAdvantage) {
					echo '"' . addslashes($arAdvantage) . '",'; 
				}
				?>
			]
		},
		<? } ?>
	];
</script>
