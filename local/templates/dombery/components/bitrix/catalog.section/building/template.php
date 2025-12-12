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
	$itemStyle = 'col-12 col-sm-6 col-md-6 col-lg-4 mb-4';
	$wrapStyle = 'row align-items-stretch';
}
?>
<div class="<?=$wrapStyle?> " data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>">
	<? foreach ($arResult['ITEMS'] as $key => $arItem) {
		$img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>480, 'height'=>360), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);
		?>


		<div class="<?=$itemStyle?> "  id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
			<div class="catalog-list-item <?=($isAllSold ? 'darkgray-bg' : '')?>">
                <div class="position-relative">
				    <img class="catalog-list-item-img" src="<?=$img['src']?>" />

                    <img class="catalog-building-label" src="/images/building-logo.png" width="72">
                    <? if ($arItem['DISPLAY_PROPERTIES']['SERIES']) { ?>
                        <div class="catalog-series-label"><?=$arItem['DISPLAY_PROPERTIES']['SERIES']['DISPLAY_VALUE']?></div>
                    <? } ?>
                </div>

				<h2 class="mb-1"><?=$arItem['NAME']?></h2>

				<? if ($arItem['DISPLAY_PROPERTIES']['SIZE']) { ?>
					<div class="gray"><?=$arItem['DISPLAY_PROPERTIES']['SIZE']['NAME'].': '.$arItem['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']?></div>
				<? } ?>


                 <? if ($arItem['PROPERTIES']['D_ONELINE_FLOOR']) { ?>
                    <div class="gray"><?=$arItem['PROPERTIES']['D_ONELINE_FLOOR']['NAME'].': '.$arItem['PROPERTIES']['D_ONELINE_FLOOR']['VALUE']?></div>
                <? } ?>


                 <? if ($arItem['PROPERTIES']['PRICE_FINISH']) { ?>
                    <div class="gray"><?=$arItem['PROPERTIES']['PRICE_FINISH']['NAME'].': '.$arItem['PROPERTIES']['PRICE_FINISH']['VALUE']?></div>
                <? } ?>

                 <!-- <?php if ($USER->IsAdmin()): ?>
                      <pre><?php print_r($arItem); ?></pre>
                   <?php endif; ?>-->


				<div class="flex-grow-1"></div>

				<div class="catalog-list-item-bottom ">
					<? if ($arItem['DISPLAY_PROPERTIES']['PRICE_FOR_FINISH']) { ?>
						<div class="d-flex justify-content-between align-items-center weight-500 mb-3">
							<span class="font-15 text-nowrap">
                                Цена:
                            </span>
							<span class="font-20 text-nowrap">
								<?=$arItem['DISPLAY_PROPERTIES']['PRICE_FOR_FINISH']['DISPLAY_VALUE']?>
							</span>
						</div>
					<? } ?>

                    <a class="btn btn-lightgray btn-lg btn-block weight-500 stretched-link" href="<?=$arItem['DETAIL_PAGE_URL'] ?>" >Подробнее</a>

				</div>
			</div>
		</div>
    <? }
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><?=$arResult["NAV_STRING"]; ?><?
	}
	?>
</div>
