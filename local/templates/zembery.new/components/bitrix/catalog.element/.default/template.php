<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

CModule::IncludeModule('ceteralabs.uservars');

global $USER, $arPriceColor;

/*$arPriceColor = array(
    80000 =>  '#d12e2e', // '#FF0302',
    110000 => '#cacc28', //'#E6EA0D',
    145000 => '#058Bc2', //#058B28',
    200000 => '#C86869',
);*/

$arPriceColor = array(
    85000 => '#62F38C',
    100000 => '#E6EA0D',
    105000 => '#FFFFBE',
    110000 => '#F9862D',
    115000 => '#058B28',
    120000 => '#B48DBA',
    130000 => '#C86869',
    145000 => '#FE39D1',
    200000 => '#FF0302',
);
if ($arResult['DISPLAY_PROPERTIES']['PRICE_RANGE']) {
    // задано кастомное (для данного поселка) цветовое разграничение цен
    $newPriceColor = array();
    $newPriceRange = explode(',', $arResult['DISPLAY_PROPERTIES']['PRICE_RANGE']['VALUE']);
    foreach ($arPriceColor as $key => $value) {
        if ($newKey = array_shift($newPriceRange)) {
            $newPriceColor[ intval($newKey) ] = $value;
        }
    }
    $arPriceColor = $newPriceColor;
}


$isAllSold = $arResult['DISPLAY_PROPERTIES']['ALL_SOLD']['VALUE'];

function getPriceColor($arData) {
    $arPrices = array();
    $arPriceColor = array();
    foreach ($arData as $arDataItem) if ($arDataItem['status'] == 'свободен' && $arDataItem['price_of'] > 0) $arPrices[] = $arDataItem['price_of'];
    $arPrices = array_unique($arPrices,SORT_NUMERIC);
    sort($arPrices, SORT_NUMERIC);
    $minPrice = $arPrices[0];
    $maxPrice = end($arPrices);
    $range = $maxPrice - $minPrice;
    $countPrice = count($arPrices);

    foreach ($arPrices as $key => $price) {
        $color = intval(140 + $key * 220 / ($countPrice-1));
        $arPriceColor[ $price ] = 'hsl(' . $color . ', 74%, 60%)';
    }

    return $arPriceColor;
}

function getColorOfStatusPrice( $arDataItem ) {
    global $arPriceColor;
    if ($arDataItem['status'] == 'продан') return '#6F787F';
    if ($arDataItem['status'] == 'резерв') return 'rgb(217, 217, 217)';
    if ($arDataItem['status'] == 'свободен') {
        $colorItem = '#6F787F';
        foreach ($arPriceColor as $price => $color) {
            if ($price <= $arDataItem['price_of']) $colorItem = $color;
        }
    }
    return $colorItem;
}
?>

<div class="detail-1">
    <? if ($arResult['DISPLAY_PROPERTIES']['LABEL']) { ?>
        <div class="text-right">
            <span class="catalog-allsold-label btn-lg d-inline-block" style="background: #<?=$arResult['DISPLAY_PROPERTIES']['LABEL_COLOR']['VALUE_XML_ID']?>"><?=$arResult['DISPLAY_PROPERTIES']['LABEL']['DISPLAY_VALUE']?></span>
        </div>
    <? } ?>
    <div class="form-row">
        <div class="col mb-4">
            <h1 class="mb-0"><?=trim($arResult['DISPLAY_PROPERTIES']['DETAIL_TITLE'] ? $arResult['DISPLAY_PROPERTIES']['DETAIL_TITLE']['DISPLAY_VALUE'] : $arResult['NAME'])?><a
                        class="ml-3 jsFavorites" href="#" data-id="<?=$arResult['ID']?>"
                        title="Добавить в избранное" onclick="ym(89571751,'reachGoal','add_to_favorites'); return true;" ><i class="fal fa-star font-26"></i></a></h1>

            <? if ($arResult['DISPLAY_PROPERTIES']['ONE_LINE_PROP']) { ?>
                <div class="gray mt-2"><?=$arResult['DISPLAY_PROPERTIES']['ONE_LINE_PROP']['DISPLAY_VALUE']?></div>
            <? } ?>
        </div>

        <? if ($arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) { ?>
            <div class="col-12 col-lg-auto mb-4">
                <div class="detail-price font-28">
                    от <?=($arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE_SALE']['DISPLAY_VALUE']
                        ? $arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE_SALE']['DISPLAY_VALUE']
                        : $arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE'])?> за сот.
                </div>

                <? if ($arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE_SALE']) { ?>
                    <div class="gray mt-1">Цена без скидки: <?=$arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE']?> за сот.</div>
                <? } ?>

                <div class="detail-price-wrap">
                    <hr>
                    <div class="weight-500 mb-2">Узнайте как получить скидку!</div>
                    <a class="d-block weight-500 green font-14" href="/sale/">Подробнее</a>
                    <hr>
                    <div class="weight-500 mb-2">Хотите дешевле?</div>
                    <div class="mb-2 font-14">Оставьте свой e-mail и мы оповестим вас об изменении цены! Но напоминаем, цена может и вырасти. 🙂</div>
                    <a class="d-block weight-500 green font-14" href="#price_subscribe" data-fancybox>Подписаться на цену</a>
                </div>
            </div>

            <div id="price_subscribe" class="popup" style="display:none;">
                <img class="mb-2" src="/images/ico-send_mail.svg">
                <h2>
                    Подписаться на цену
                </h2>

                <div class="mb-3">
                    Оставьте свой e-mail и мы оповестим вас об изменении цены! Но напоминаем, цена может и вырасти. 🙂
                </div>

                <div class="darkgray-bg rounded-lg px-3 pt-3">
                        <form class="form-ajax form-row" action="/local/include/ajax-price-subscribe.php">
                            <input type="hidden" name="product" value="<?=$arResult['ID']?>">
                            <div class="col-12 col-sm mb-3">
                                <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required="">
                            </div>
                            <div class="col-12 col-sm mb-3">
                                <input class="form-control form-control-lg " type="text" name="email" placeholder="E-mail" required="" >
                            </div>
<div class="col-12">
        <p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
       </div>
                            <div class="col-12 col-md mb-3">
                                <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Подписаться">
                            </div>
                        </form>
                    </div>
            </div>
        <? } ?>
    </div>




	<div class="form-row align-items-start border-bottom border-dashed pb-4 mb-4 justify-content-between justify-content-md-start">

        <? if ($isAllSold) { ?>
            <div class="catalog-allsold-label btn-lg">Продано</div>
        <? } else { ?>
            <div class="col-12 col-sm-6 col-lg-auto mb-3 mb-lg-0">
                <a class="btn btn-lg btn-primary btn-block" href="#book" data-fancybox >Забронировать участок</a>
            </div>

            <div class="col-12 col-sm-6 col-lg-auto mb-3 mb-lg-0">
                <a class="btn btn-lg btn-light btn-block" href="#preview" data-fancybox >Запрос на просмотр</a>
            </div>
        <? } ?>

        <div class="col-12 col-sm-6 col-lg-auto mb-3 mb-lg-0 ml-0 ml-lg-auto">
            <a class="btn btn-lg btn-light btn-block jsCompare" href="#" data-id="<?=$arResult['ID']?>" title="Добавить к сравнению" onclick="ym(89571751, 'reachGoal', 'add_to_compare'); return true;">
                <span class="fa-stack fa-4x font-12 mr-3">
                    <i class="fal fa-list-alt fa-stack-2x"></i>
                    <i class="fas fa-inverse fa-plus-circle fa-stack-1x " style="position: relative;bottom: -8px;left: 10px;text-shadow: 1px 1px 0px black, -1px -1px 0px black, -1px 1px 0px black, 1px -1px 0px black;"></i>
                </span>
                Сравнить <span class="count"></span>
            </a>
        </div>

        <? if ($arResult['DISPLAY_PROPERTIES']['GEOPOINT']) { ?>
            <div class="col-12 col-sm-6 col-lg-auto">
                <a class="btn btn-lg btn-light btn-block" href="https://yandex.ru/maps/?rtext=~<?=$arResult['DISPLAY_PROPERTIES']['GEOPOINT']['VALUE']?>" target="_blank"><i class="far fa-route mr-3"></i>Построить маршрут</a>
            </div>
        <? } ?>
	</div>

	<div class="row justify-content-between align-items-start mb-3">
		<? foreach (array('CITY', 'SHOSSE', 'REGION', 'REMAINDER', 'REMOTENESS', 'GEOPOINT_SHOT') as $propCode) {
			if ($arResult['DISPLAY_PROPERTIES'][$propCode]) { ?>
				<div class="col-auto font-18 mb-3">
					<div class="font-14 gray mb-1"><?= $arResult['DISPLAY_PROPERTIES'][$propCode]['NAME'] ?>:</div>
					<?= $arResult['DISPLAY_PROPERTIES'][$propCode]['DISPLAY_VALUE'] ?> <?= $arResult['DISPLAY_PROPERTIES'][$propCode]['HINT'] ?>
				</div>
				<?
			}
		} ?>
	</div>

	<? if ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']) { ?>
		<div class="detail-slider">
			<? foreach ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] as $arPhotoItem) {
				$img = CFile::ResizeImageGet($arPhotoItem['ID'], array('width'=>736, 'height'=>414), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
				?>
				<a class="detail-slider-item" href="<?=$arPhotoItem['SRC']?>" data-fancybox="detail"><img class="<?=($isAllSold ? 'img-grayscale':'')?>" src="<?=$img['src']?>" /></a>
			<? } ?>
		</div>
	<? } ?>
</div>

<div class="my-5">

</div>


<div class="row mb-4">
	<? if ($arResult['DISPLAY_PROPERTIES']['ADVANTAGES']) { ?>
		<div class="col-12 col-md mb-4">
			<h2 class="mb-4">Преимущества посёлка</h2>
			<div class="advantages-list">
				<?=implode(' ', $arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'])?>
			</div>
		</div>
	<? } ?>

	<? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS'] || $arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']) { ?>
		<div class="col-12 col-md mb-4">
			<h2 class="mb-4">Доступность</h2>
			<div class="form-row">

				<? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS'] || $arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']) { ?>
				<div class="col-auto mb-3">
					<div class="border rounded-lg p-3 d-flex align-items-center">
						<i class="far fa-car mr-3 font-26"></i>
						<div class="font-13">
							<div class="weight-500 font-16">
                                <?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE']?>
                                <?=($arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE'] && $arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']['DISPLAY_VALUE'] ? '<i class="fas fa-circle mx-1 font-6"></i>' : '')?>
                                <?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']['DISPLAY_VALUE']?>
                            </div>
							<div class="gray">на машине от МКАД</div>
						</div>
					</div>
				</div>
				<? } ?>

				<? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']) { ?>
					<div class="col-auto mb-3">
						<div class="border rounded-lg p-3 d-flex align-items-center">
							<i class="far fa-train mr-3 font-26"></i>
							<div class="font-13">
								<div class="weight-500 font-16"><?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']['DISPLAY_VALUE']?> минут</div>
								<div class="gray">на Ж/Д от центра</div>
							</div>
						</div>
					</div>
				<? } ?>
			</div>
		</div>
	<? } ?>
</div>

<? if ($arResult['DISPLAY_PROPERTIES']['ROUTE'] || $arResult['DISPLAY_PROPERTIES']['GEOPOINT']) { ?>
	<div class="row">

		<? if ($arResult['DISPLAY_PROPERTIES']['ROUTE']) { ?>
			<div class="col-12 <?=($arResult['DISPLAY_PROPERTIES']['GEOPOINT'] ? 'col-lg-12':'')?> mb-5">
				<h2 class="mb-4"><?=$arResult['DISPLAY_PROPERTIES']['ROUTE']['NAME']?></h2>
				<div class="font-18">
					<?=$arResult['DISPLAY_PROPERTIES']['ROUTE']['DISPLAY_VALUE']?>
				</div>
			</div>
		<? } ?>

        <? if ($arResult['DISPLAY_PROPERTIES']['GEOINSIDE']) { ?>
            <div class="col-12 <?=($arResult['DISPLAY_PROPERTIES']['ROUTE'] ? 'col-lg-12':'')?> mb-5">
                <h2 class="mb-4"><?=$arResult['DISPLAY_PROPERTIES']['GEOINSIDE']['NAME']?></h2>
                <div class="map-wrap">
                    <?=$arResult['DISPLAY_PROPERTIES']['GEOINSIDE']['DISPLAY_VALUE']?>
                </div>
            </div>
        <? } elseif ($arResult['DISPLAY_PROPERTIES']['GEOPOINT']) { ?>
			<div class="col-12 <?=($arResult['DISPLAY_PROPERTIES']['ROUTE'] ? 'col-lg-12':'')?> mb-5">
				<h2 class="mb-4"><?=$arResult['DISPLAY_PROPERTIES']['GEOPOINT']['NAME']?></h2>
				<div class="map-wrap">
					<?=$arResult['DISPLAY_PROPERTIES']['GEOPOINT']['DISPLAY_VALUE']?>
				</div>
			</div>
		<? } ?>
	</div>
<? } ?>

<? if (
        $arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN'] ||
        ( $arResult['DISPLAY_PROPERTIES']['SVG_MAP'] && $arResult['DISPLAY_PROPERTIES']['GDATA'] ) ||
        $arResult['DISPLAY_PROPERTIES']['IMAGE_KADASTR'] ||
        $arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN'] ||
        $arResult['DISPLAY_PROPERTIES']['TOUR']
    ) { ?>
	<div class="wide-gray-bg py-5" >
		<ul class="nav nav-tabs pt-4">
			<?
            $isActive = true;
            if ($arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN'] || ( $arResult['DISPLAY_PROPERTIES']['SVG_MAP'] && $arResult['DISPLAY_PROPERTIES']['GDATA'] ) ) { ?>
				<li class="nav-item">
					<a class="nav-link jsScrollTo a_ctive" d_ata-toggle="tab" href="#plan"><?=$arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN']['NAME']?></a>
				</li>
			<?
                $isActive = false;
            } ?>

			<? if ($arResult['DISPLAY_PROPERTIES']['IMAGE_KADASTR']) { ?>
				<li class="nav-item">
					<a class="nav-link jsScrollTo <?=($isActive ? 'active':'')?> "
                       d_ata-toggle="tab" href="#kadastr"><?=$arResult['DISPLAY_PROPERTIES']['IMAGE_KADASTR']['NAME']?></a>
				</li>
			<?
                $isActive = false;
            } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['TOUR']) { ?>
                <li class="nav-item">
                    <a class="nav-link jsScrollTo <?=($isActive ? 'active':'')?> "
                       d_ata-toggle="tab" href="#tour"><?=$arResult['DISPLAY_PROPERTIES']['TOUR']['NAME']?></a>
                </li>
            <?
                $isActive = false;
            } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN']) { ?>
                <li class="nav-item">
                    <a class="nav-link jsScrollTo <?=($isActive ? 'active':'')?> "
                       d_ata-toggle="tab" href="#iframe_plan"><?=$arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN']['NAME']?></a>
                </li>
            <?
                $isActive = false;
            } ?>


            <? if ($arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN'] || $arResult['DISPLAY_PROPERTIES']['SVG_MAP']) { ?>
                <li class="nav-item ml-auto">
                    <a class="nav-link jsScrollTo " href="#share-popup" data-fancybox>Поделиться<i class="fal fa-share-alt ml-2"></i></a>
                </li>
            <? } ?>
		</ul>

		<div class="t_ab-content pb-5">
			<?
            $isActive = true;
            if ( $arResult['DISPLAY_PROPERTIES']['SVG_MAP'] && $arResult['DISPLAY_PROPERTIES']['GDATA'] ) {
                $isActive = false;
                $arData = json_decode($arResult['DISPLAY_PROPERTIES']['GDATA']['~VALUE']['TEXT'], true);
                $arPriceColor = getPriceColor($arData);
                ?>

                <div class="t_ab-pane f_ade s_how a_ctive" id="plan">
                    <h2 class="mb-4 mt-5"><?=$arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN']['NAME']?></h2>

                    <div id="svg_wrap_wrap">
                        <div id="svg_wrap">
                            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                            <lottie-player src="/images/cursorhandswiperight.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></lottie-player>
                            <img class="compas" src="/images/compas.svg" />
                            
                            <?
                            $svgRaw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $arResult['DISPLAY_PROPERTIES']['SVG_MAP']['FILE_VALUE']['SRC']);
                            $svgRaw = str_replace( array('fill="none"', 'path id="', 'text id="'), array('fill="rgba(0,0,0,0)"', 'path id="Vector_', 'text id="Text_'), $svgRaw);
                            //echo $svgRaw;
                            //$svgRaw = preg_replace('/(.*)<text(.*)fill=\"(\S*)\"(.*)\>(.*)/i', '\\1<text\\2fill="#FFFFFF"\\4>\\5', $svgRaw);

                            foreach ( $arData as $arDataItem ) {
                                $pathStr = '<path id="Vector_'.$arDataItem['num'].'" ';
                                $color = getColorOfStatusPrice($arDataItem);
                                //echo '<!-- '.$color.' -->';
                                if ($color) {
                                    $arPregSplit = preg_split('/' . $pathStr . '(.*)fill=\"(\S*)\"(.*)\/>/', $svgRaw, -1, PREG_SPLIT_DELIM_CAPTURE);
                                    if ($arPregSplit[4]) {
                                        $svgRaw = $arPregSplit[0] . $pathStr . $arPregSplit[1] . ' fill="' . $color . '"' . $arPregSplit[3] . '/>' . $arPregSplit[4];
                                    }

                                    // debug
                                    //if ($USER->IsAdmin() && $arDataItem['num'] > 114 && $arDataItem['num'] < 118) {
                                        //echo '<pre>'.$arDataItem['num'].'---'.print_r($arPregSplit, true).'</pre>';
                                    //}
                                }
                            }

                            echo $svgRaw;

                            // создаем png-версию svg карты для отправки на почту
                            $svgRaw = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . "\n" . $svgRaw;
                            //echo '<code>'.$svgRaw.'</code>';
                            $jpgFileNameSvgMap = '/upload/map/' . md5( $svgRaw ) . '.jpg';
                            if ( !is_file( $_SERVER['DOCUMENT_ROOT'] .  $jpgFileNameSvgMap ) ) {
                                $image = new Imagick();
                                try {
                                    $image->readImageBlob($svgRaw);
                                    //$image->setImageFormat("png24");
                                    $image->setImageFormat('jpeg');
                                    $image->setImageCompressionQuality(90);
                                    //$image->resizeImage(1024, 768, imagick::FILTER_LANCZOS, 1);
                                    $image->writeImage($_SERVER['DOCUMENT_ROOT'] .  $jpgFileNameSvgMap);
                                } catch (Exception $e) {
                                    unset($jpgFileNameSvgMap);
                                }
                            }
                            ?>
                        </div>
                        <span class="scale-btn scale-btn-inc"><i class="fal fa-search-plus"></i></span>
                        <span class="scale-btn scale-btn-dec"><i class="fal fa-search-minus"></i></span>
                    </div>

                    <?
                    // debug
                    //if ($USER->IsAdmin()) {
                    //    echo '<img class="mw-100" src="'.$jpgFileNameSvgMap.'" />';
                    //    echo '<pre><code>'.htmlentities($svgRaw).'</code></pre>';
                    //}

                    $htmlLegend = '<div class="svg-map-legend">
                        <p><span class="svg-map-legend-item" style="background: #6F787F;height: 1.5em;width: 1.5em;display: inline-block;vertical-align: middle;"></span> Участок продан</p>
                        <p><span class="svg-map-legend-item" style="background: rgb(217,217,217);height: 1.5em;width: 1.5em;display: inline-block;vertical-align: middle;"></span> Резерв</p>';
                        foreach ($arPriceColor as $price => $color) {
                            $formatPrice = CurrencyFormat($price,'RUB');
                            //$htmlLegend = str_replace('#TO#', ' - '.$formatPrice, $htmlLegend ); // закоментированы две строки, которые выводят цену диапазоном от/до
                            //$htmlLegend .= '<p><span class="svg-map-legend-item" style="background: '.$color.';height: 1.5em;width: 1.5em;display: inline-block;vertical-align: middle;"></span> '. $formatPrice . ' #TO# за сотку</p>';
                            $htmlLegend .= '<p><span class="svg-map-legend-item" style="background: '.$color.';height: 1.5em;width: 1.5em;display: inline-block;vertical-align: middle;"></span> '. $formatPrice . ' за сотку</p>';
                        }
                    $htmlLegend .= '</div>';
                    $htmlLegend = str_replace('#TO#', '', $htmlLegend );
                    echo $htmlLegend;
                    ?>

                    <div id="svg_data_rect" class="svg_data_rect" style="display:none;"></div>

                    <div style="display: none;">
                        <?
                        $COST_REGISTRATION_VILLAGE = \Ceteralabs\UserVars::GetVar('COST_REGISTRATION_VILLAGE');
                        foreach ( $arData as $arDataItem ) {
                            if ($arDataItem['status'] == 'свободен') {                ?>
                                <div id="Vector_<?=$arDataItem['num']?>_popup">
                                    <h3 class="mb-3">Участок <?=$arDataItem['num']?> в <?=$arResult['NAME']?></h3>
                                    <div class="mb-3">
                                        <? if ($arDataItem['price_of'] > 0) { ?>
                                            Статус участка: <b><?=$arDataItem['status']?></b><br>
                                            Кадастровый номер: <b><?=$arDataItem['num_kadastr']?></b><br>
                                            Площадь участка: <b><?=$arDataItem['volume']?></b><br>
                                            Стоимость за сотку: <b><?=CurrencyFormat($arDataItem['price_of'], 'RUB')?></b><br>
                                            Полная стоимость участка: <b><?=CurrencyFormat($arDataItem['fullprice'], 'RUB')?></b><br>
                                            Стоимость оформления: <b><?=CurrencyFormat($COST_REGISTRATION_VILLAGE['VALUE'], 'RUB')?></b>
                                        <? } else { ?>
                                            <b><?=$arDataItem['price_of']?></b><br>
                                            Статус участка: <b><?=$arDataItem['status']?></b><br>
                                            Кадастровый номер: <b><?=$arDataItem['num_kadastr']?></b><br>
                                            Площадь участка: <b><?=$arDataItem['volume']?></b><br>
                                        <? } ?>
                                    </div>
                                    <div class="mb-2">
                                        <a class="btn btn-block btn-lg btn-primary btn-block" href="#book" data-fancybox onclick="$('#book input[name=plot_number]').val( <?=$arDataItem['num']?> )" >Забронировать участок</a>
                                    </div>
                                    <div>
                                        <a class="btn btn-block btn-lg btn-light btn-block" href="#preview" data-fancybox onclick="$('#preview input[name=message]').val( <?=$arDataItem['num']?> )" >Запрос на просмотр</a>
                                    </div>
                                </div>
                            <? }
                        } ?>
                    </div>

                    <script>
                        $(document).ready(function (){
                            $.fancybox.defaults.hideScrollbar = false;

                            <? foreach ( $arData as $arDataItem ) {
                                if ($arDataItem['status'] == 'свободен') {                ?>
                                    $('#Vector_<?=$arDataItem['num']?>, [id^="Text_<?=$arDataItem['num']?>_"]').click(function (){
                                        $.fancybox.close();
                                        $.fancybox.open( $('#Vector_<?=$arDataItem['num']?>_popup'), {helpers: { overlay: { locked: false } }} );
                                        return false;
                                    }).mouseout(function (){
                                        $('#svg_data_rect').hide().html('');
                                    }).mouseover(function (){
                                        <? if ($arDataItem['price_of'] > 0) { ?>
                                            $('#svg_data_rect').html('<h3 class="mb-3">Участок <?=$arDataItem['num']?></h3><div class="mb-3">Статус участка: <b><?=$arDataItem['status']?></b><br>Площадь участка: <b><?=$arDataItem['volume']?></b><br>Стоимость за сотку: <b><?=CurrencyFormat($arDataItem['price_of'], 'RUB')?></b><br>Полная стоимость участка: <b><?=CurrencyFormat($arDataItem['fullprice'], 'RUB')?></b></div>').
                                        <? } else { ?>
                                            $('#svg_data_rect').html('<h3 class="mb-3">Участок <?=$arDataItem['num']?></h3><div class="mb-3"><b><?=$arDataItem['price_of']?></b><br>Статус участка: <b><?=$arDataItem['status']?></b><br>Площадь участка: <b><?=$arDataItem['volume']?></b></div>').
                                        <? } ?>
                                        show();
                                    });
                                <? }
                            } ?>
                        })
                    </script>

                    <? if ($USER->IsAdmin()) {
                        // yarmol
                        //echo '<pre>'.print_r($arData, true).'</pre>';
                        //echo '<pre>'.print_r($arPriceColor2, true).'</pre>';
                    } ?>

                </div>
            <? } elseif ($arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN']) {
                $isActive = false;
                ?>
				<div class="t_ab-pane f_ade s_how a_ctive" id="plan">
                    <h2 class="mb-4 mt-5"><?=$arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN']['NAME']?></h2>

					<img class="mw-100 d-block" src="<?=$arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN']['FILE_VALUE']['SRC']?>" />
				</div>
			<? } ?>

			<? if ($arResult['DISPLAY_PROPERTIES']['IMAGE_KADASTR']) { ?>
				<div class="t_ab-pane f_ade <?=( false && $isActive ? 'show active':'')?>" id="kadastr">
                    <h2 class="mb-4 mt-5"><?=$arResult['DISPLAY_PROPERTIES']['IMAGE_KADASTR']['NAME']?></h2>

					<img class="mw-100 d-block" src="<?=$arResult['DISPLAY_PROPERTIES']['IMAGE_KADASTR']['FILE_VALUE']['SRC']?>" />

					<? if ($arResult['DISPLAY_PROPERTIES']['URL_KADASTR']) { ?>
						<a class="btn btn-lg btn-outline-primary mt-4" href="<?=$arResult['DISPLAY_PROPERTIES']['URL_KADASTR']['VALUE']?>" target="_blank">Перейти на сайт Росреестра</a>
					<? } ?>
				</div>
			<?
                $isActive = false;
            } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['TOUR']) { ?>
                <div class="t_ab-pane f_ade overflow-hidden <?=(false && $isActive ? 'show active':'')?> " id="tour">
                    <h2 class="mb-4 mt-5"><?=$arResult['DISPLAY_PROPERTIES']['TOUR']['NAME']?></h2>

                    <iframe  frameborder="0"src="<?=$arResult['DISPLAY_PROPERTIES']['TOUR']['VALUE']?>" width="100%" height="640" align="left" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true">
                        Ваш браузер не поддерживает плавающие фреймы!
                    </iframe>
                </div>
            <?
                $isActive = false;
            } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN']) { ?>
                <div class="t_ab-pane f_ade overflow-hidden <?=(false && $isActive ? 'show active':'')?> " id="iframe_plan">
                    <h2 class="mb-4 mt-5"><?=$arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN']['NAME']?></h2>

                    <iframe  frameborder="0"src="<?=$arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN']['VALUE']?>" width="100%" height="640" align="left" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true">
                        Ваш браузер не поддерживает плавающие фреймы!
                    </iframe>
                </div>
            <?
                $isActive = false;
            } ?>
		</div>

        <?
        // попап расшаривания карты на мыло
        if ($arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN'] || $arResult['DISPLAY_PROPERTIES']['SVG_MAP']) { ?>
            <div id="share-popup" class="popup" style="display: none;">
                <i class="far fa-share-alt green font-26 mb-3"></i>
                <h2>
                    Хотите поделиться описанием поселка?
                </h2>

                <div class="mb-3"></div>

                <div class="darkgray-bg rounded-lg px-3 pt-3">
                    <form class="form-ajax form-row align-items-center" action="/local/include/ajax-share.php">
                        <input type="hidden" name="form_name" value="Поделиться поселком">
                        <input type="hidden" name="product_name" value="<?=$arResult['NAME']?>">
                        <input type="hidden" name="page_url" value="<?=$APPLICATION->GetCurPage(false)?>">
                        <input type="hidden" name="map_image" value="<?=($jpgFileNameSvgMap ? $jpgFileNameSvgMap : $arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN']['FILE_VALUE']['SRC'])?>">
                        <input type="hidden" name="html_legend" value="<?=htmlentities($htmlLegend)?>">

                        <div class="col-12 col-sm-6 mb-3">
                            <input class="form-control form-control-lg" type="email" name="email" placeholder="E-mail" required="">
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required="" maxlength="18">
                        </div>

                        <? /*
                        <div class="col-12 col-sm-6 mb-3">
                            <input class="captchaSid" name="captcha_code" value="" type="hidden">
                            <input class="form-control form-control-lg" name="captcha_word" type="text" required placeholder="Введите код с картинки" >
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <img class="captchaImg jsReloadCaptcha" src="">
                        </div>
 */ ?>

                        <div class="col-12 mb-3">
                            <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Поделиться">
                        </div>

                    </form>
                </div>
            </div>
        <? } ?>
	</div>
<? } ?>

<?php if ($arResult['DISPLAY_PROPERTIES']['DIAGRAMMA']['DISPLAY_VALUE']) { ?>
    <div class="wide-darkgray-bg py-5 text-center" >
        <h2 class="mb-4">Готовность коммуникаций</h2>

        <div class="row align-items-start justify-content-around flex-wrap">
            <? foreach ($arResult['DISPLAY_PROPERTIES']['DIAGRAMMA']['DISPLAY_VALUE'] as $arDiagram) { ?>
                <div class="diagram-item">
                    <div class="pie" style="--p:<?=intval($arDiagram['SUB_VALUES']['DIAG_VALUE']['VALUE'])?>"> <?=intval($arDiagram['SUB_VALUES']['DIAG_VALUE']['VALUE'])?>%</div>

                    <div class="font-18 pt-3 pb-1">
                        <?=$arDiagram['SUB_VALUES']['DIAG_NAME']['VALUE']?>
                    </div>

                    <? if ($arDiagram['SUB_VALUES']['DIAG_DATE']['VALUE']) { ?>
                        <div class="gray font-14">
                            Дата окончания:<br>
                            <?=$arDiagram['SUB_VALUES']['DIAG_DATE']['VALUE']?>
                        </div>
                    <? } ?>

                    <? if ($arDiagram['SUB_VALUES']['DIAG_LINK']['VALUE']) { ?>
                        <a class="green " href="<?=$arDiagram['SUB_VALUES']['DIAG_LINK']['VALUE']?>" >Подробнее<i class="fal fa-external-link fa-xs ml-2"></i></a>
                    <? } ?>
                </div>
            <? } ?>
        </div>
    </div>
<?php } ?>


<? if ($arResult['DETAIL_TEXT']) { ?>
	<div class="my-5">
		<h2 class="mb-4">Описание</h2>

		<div class="text-limitation font-18" data-height="600">
			<?=$arResult['DETAIL_TEXT']?>
		</div>
	</div>
<? } ?>

<div id="book" class="popup" style="display: none;">
    <img class="mb-2" src="/images/ico-question-green.svg" />
    <h2>
        Забронировать участок
    </h2>

    <div class="mb-3">
        <span class="gray"><?=$arResult['NAME']?></span>
    </div>

    <div class="darkgray-bg rounded-lg px-3 pt-3">
        <form class="form-ajax form-row justify-content-center" action="/local/include/ajax-bron-create.php">
            <input type="hidden" name="form_name" value="Забронировать участок в <?=$arResult['NAME']?>">
            <input type="hidden" name="PRODUCT_ID" value="<?=$arResult['ID']?>">
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg" type="text" name="name" placeholder="ФИО" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg " type="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg " type="text" name="plot_number" placeholder="Номер участка" required>
            </div>
            <div class="col-12 col-md-8 text-center mb-3">
                <input class="btn btn-primary btn-lg btn-block " type="submit" name="submit" placeholder="Забронировать">
            </div>
            <div class="col-12 col-md-10 text-center mb-3">
                <p class="gray">Нажимая "Отправить" вы соглашаетесь с <a href="/oferta/" target="_blank">офертой</a></p>
            </div>
        </form>
    </div>
</div>

<div id="preview" class="popup" style="display: none;">
    <img class="mb-2" src="/images/ico-question2-green.svg" />
    <h2>
        Запрос на просмотр
    </h2>

    <div class="mb-3">
        <span class="gray">Свяжитесь с нами, по телефону</span> +7(495) 001-00-03 <span class="gray">или формой ниже, и мы с удовольствием обо всём расскажем.</span>
    </div>

    <div class="darkgray-bg rounded-lg px-3 pt-3">
        <form class="form-ajax form-row justify-content-center">
            <input type="hidden" name="form_name" value="Запрос на просмотр участка в <?=$arResult['NAME']?>">
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
            </div>
            <div class="col-12 mb-3">
                <input class="form-control form-control-lg" type="text" name="message" placeholder="Укажите номер одного или нескольких участков" >
            </div>
            <div class="col-12 col-md-8 text-center mb-3">
                <input class="btn btn-primary btn-lg btn-block " type="submit" name="submit" placeholder="Забронировать">
            </div>
        </form>
    </div>
</div>

<? if ($arResult['DISPLAY_PROPERTIES']['SALE_VILLAGE']) {
    $arSaleVillage = explode( ' ', str_replace( array(',', '.', '  ', '   '), ' ', $arResult['DISPLAY_PROPERTIES']['SALE_VILLAGE']['VALUE'] ) );
    ?>
    <style>
        path#Vector_<?=implode(',path#Vector_', $arSaleVillage)?> {
            -webkit-animation: sale-animation 1s infinite;  /* Safari 4+ */
            -moz-animation: sale-animation 1s infinite;  /* Fx 5+ */
            -o-animation: sale-animation 1s infinite;  /* Opera 12+ */
            animation: sale-animation 1s infinite;  /* IE 10+, Fx 29+ */
        }
    </style>
<? } ?>

