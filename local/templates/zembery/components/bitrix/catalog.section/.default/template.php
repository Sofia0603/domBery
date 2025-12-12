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

<div class="<?=$wrapStyle?> " data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>">
	<? foreach ($arResult['ITEMS'] as $key => $arItem) {
		$img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>494, 'height'=>370), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);
        $isAllSold = $arItem['DISPLAY_PROPERTIES']['ALL_SOLD']['VALUE'];
		?>
		<div class="<?=$itemStyle?> "  id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
			<a href="<?=$arItem['DETAIL_PAGE_URL'] ?>" >
			<div class="catalog-list-item <?=($isAllSold ? 'darkgray-bg' : '')?>">
                <div class="position-relative">
				    <img class="catalog-list-item-img" src="<?=$img['src']?>" alt="Земельный посёлок <?=$arItem['NAME']?>" />

                    <? if ($isAllSold) {
                        echo '<div class="catalog-allsold-label">Продано</div>';
                    }
                    if ($arItem['DISPLAY_PROPERTIES']['LABEL']) {
                        echo '<div class="catalog-allsold-label" style="background: #'.$arItem['DISPLAY_PROPERTIES']['LABEL_COLOR']['VALUE_XML_ID'].'">'.$arItem['DISPLAY_PROPERTIES']['LABEL']['DISPLAY_VALUE'].'</div>';
                    }
                    ?>
					<? if ($arItem['DISPLAY_PROPERTIES']['PURPOSE']) { ?>
						<button class="element__purpose" disabled><?=$arItem['DISPLAY_PROPERTIES']['PURPOSE']['VALUE'] ?></button>
                    <? } ?>
                </div>

                <h2><?=$arItem['NAME']?></h2>

				<? if ($arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']) { ?>
				<div class="gray mb-3" style="height: 60px"><?=$arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']['DISPLAY_VALUE']?></div>
				<? } ?>

				<? if ($arItem['DISPLAY_PROPERTIES']['ADVANTAGES']) { ?>
					<div class="font-15 weight-500 mb-1">Преимущества:</div>
					<div class="advantages-list">
						<?=implode(' ', $arItem['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'])?>
					</div>
				<? } ?>

				<div class="flex-grow-1"></div>

				<div class="catalog-list-item-bottom">
					<? if ($arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) { ?>
						<div class="d-flex justify-content-between align-items-center weight-500 mb-3">
							<span class="font-15 text-nowrap">Цена за сотку, от:</span>
							<span class="font-20 text-nowrap">
								<?=$arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE']?>
							</span>
						</div>
					<? } ?>
					<? if ($arItem['DISPLAY_PROPERTIES']['PURPOSE']) { ?>
						<div class="d-flex justify-content-between align-items-center weight-500 mb-3">
							<span class="font-15 text-nowrap">Назначение:</span>
							<span class="font-20 text-nowrap">
								<button class="element__purpose-bottom" disabled>Промышленная</button>
							</span>
						</div>
					<? } else { ?>
        						<div class="element__sale" style="height: 40px;"></div>
                     <? } ?>

                    <a class="btn btn-lightgray btn-lg btn-block weight-500 stretched-link" href="<?=$arItem['DETAIL_PAGE_URL'] ?>" >Подробнее</a>

				</div>
			</div>
			</a>
		</div>

    <? }
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><?=$arResult["NAV_STRING"]; ?><?
	}
	?>
</div>
