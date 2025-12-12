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

<? if ( $arResult['DISPLAY_PROPERTIES']['SVG_MAP'] && $arResult['DISPLAY_PROPERTIES']['GDATA'] ) { ?>
        <?
        $isActive = true;
        if ( $arResult['DISPLAY_PROPERTIES']['SVG_MAP'] && $arResult['DISPLAY_PROPERTIES']['GDATA'] ) {
            $isActive = false;
            $arData = json_decode($arResult['DISPLAY_PROPERTIES']['GDATA']['~VALUE']['TEXT'], true);
            $arPriceColor = getPriceColor($arData);
            ?>
            <div id="plan">
                <h2 class="mb-4 mt-2"><?=$arResult['NAME']?></h2>

                <div id="svg_wrap_wrap" class="position-relative">
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

            </div>
        <? } ?>
<? } ?>


