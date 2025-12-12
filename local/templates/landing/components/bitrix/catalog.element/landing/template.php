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

if (empty($arResult['PROPERTIES']['LANDING_MORE_PHOTO']['VALUE'])) {
    define("ERROR_404", "Y");
    \CHTTP::setStatus("404 Not Found");
    die();
}

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
$this->addExternalCss(SITE_TEMPLATE_PATH."/css/fake-order.min.css");
$this->addExternalJS(SITE_TEMPLATE_PATH."/js/fake-order.min.js");
$this->addExternalJS(SITE_TEMPLATE_PATH."/js/fake-order-config.js");
?>
<div class="detail-top">
    <div class="detail-top-slider">
        <? foreach ($arResult['PROPERTIES']['LANDING_MORE_PHOTO']['VALUE'] as $photoId) {
            $imgSrc = CFile::getPath($photoId);
            ?>
            <div class="detail-top-slider-item" style="background-image: url('<?=$imgSrc?>')"></div>
        <? } ?>
    </div>

    <div class="detail-top-content">
        <div class="container h-100">
            <div class="row align-items-center justify-content-between h-100">
                <div class="col-12 d-none d-md-block d-lg-none">
                    <div class="detail-top-title"><?=$arResult['NAME']?></div>
                </div>

                <div class="col-12 col-md-6 col-lg-6 col-xl-5 mb-5 mb-md-0">
                    <div class="detail-top-title d-md-none d-lg-block"><?=$arResult['NAME']?></div>

                    <div class="font-24 mb-4">Коттеджный поселок в тихом, экологичном  месте недалеко от Москвы, для вашего комфорта</div>

                    <a class="btn btn-primary" href="#preview" data-fancybox="">Записаться на просмотр</a>
                </div>

                <div class="col-12 col-md-6 col-lg-6 col-xl-5">
                    <div class="detail-top-info">
                        <? if ($arResult['DISPLAY_PROPERTIES']['SHOSSE'] || $arResult['DISPLAY_PROPERTIES']['REMOTENESS']) { ?>
                            <div class="detail-top-info-item">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9994 8.33334V8.33334C27.0495 12.3834 27.0495 18.9499 22.9994 23L18.171 27.8284C17.5066 28.4928 16.6055 28.866 15.666 28.866C14.7265 28.866 13.8254 28.4928 13.1611 27.8284L8.33267 23C4.28258 18.9499 4.28258 12.3834 8.33267 8.33334V8.33334C12.3828 4.28325 18.9493 4.28325 22.9994 8.33334Z" stroke="white" stroke-width="1.71178" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="15.6658" cy="15.6667" r="3.77124" stroke="white" stroke-width="1.71178" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                <?
                                if ($arResult['DISPLAY_PROPERTIES']['SHOSSE']) echo $arResult['DISPLAY_PROPERTIES']['SHOSSE']['DISPLAY_VALUE'].' шоссе';
                                if ($arResult['DISPLAY_PROPERTIES']['SHOSSE'] && $arResult['DISPLAY_PROPERTIES']['REMOTENESS']) echo '<br>';
                                if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS']) echo $arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE'].' от МКАД';
                                ?>
                            </div>
                        <? } ?>

                        <? if ($arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) { ?>
                            <div class="detail-top-info-item">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24.4853 7.51472C29.1715 12.201 29.1715 19.799 24.4853 24.4853C19.799 29.1715 12.201 29.1715 7.51472 24.4853C2.82843 19.799 2.82843 12.201 7.51472 7.51472C12.201 2.82843 19.799 2.82843 24.4853 7.51472" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.0605 22V10H18.0979C19.8685 10 21.3045 11.3427 21.3045 13C21.3045 14.6573 19.8685 16 18.0979 16" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.0927 16H10.666" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M17.3327 19.6667H10.666" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Сотка от <?=$arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE']?>
                            </div>
                        <? } ?>

                        <? if (!empty($arResult['PROPERTIES']['LANDING_INFO_IPOTEKA']['VALUE'])) { ?>
                            <div class="detail-top-info-item">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.66602 26.6667C6.34791 22.9848 12.3175 22.9848 15.9993 26.6667" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8.01237 20V23.9978" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.54094 9.45869L4.20894 12.7907C4.01828 12.9814 3.96125 13.2681 4.06444 13.5172C4.16762 13.7663 4.4107 13.9287 4.68034 13.9287H11.3443C11.614 13.9287 11.857 13.7663 11.9602 13.5172C12.0634 13.2681 12.0064 12.9814 11.8157 12.7907L8.48374 9.45869C8.22339 9.19834 7.80128 9.19834 7.54094 9.45869Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M28 21.3334V5.33337H24V7.5556" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M19.334 21.3333V16H23.334V21.3333" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M29.334 21.3333H17.334" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 9.77737L21.3333 5.33337L29.3333 12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.75854 13.9287L2.89704 18.4994C2.6679 18.7706 2.61696 19.1501 2.76647 19.4721C2.91599 19.7941 3.23879 20.0001 3.59382 20H12.4329C12.7879 20 13.1106 19.794 13.2601 19.472C13.4096 19.15 13.3586 18.7706 13.1296 18.4994L9.26806 13.9288" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                <?=$arResult['PROPERTIES']['LANDING_INFO_IPOTEKA']['VALUE']?>
                            </div>
                        <? } ?>

                        <? if (!empty($arResult['PROPERTIES']['LANDING_INFO_GOTOVNOST']['VALUE'])) { ?>
                            <div class="detail-top-info-item">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.0007 4V8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M22.0007 4V8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 28H8C5.79086 28 4 26.2091 4 24V10C4 7.79086 5.79086 6 8 6H24C26.2091 6 28 7.79086 28 10V16" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="23.9993" cy="24" r="5.33333" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M25.7937 22.944L23.5537 25.1826L22.207 23.84" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0007 15.5875V17.8889C16.0007 18.6253 15.4037 19.2222 14.6673 19.2222H10.6673C9.93094 19.2222 9.33398 18.6253 9.33398 17.8889V15.5235C9.33398 15.0172 9.56414 14.5384 9.95952 14.2221L11.5862 12.9207C12.1949 12.4338 13.0598 12.4338 13.6685 12.9207L15.3751 14.2861C15.7705 14.6024 16.0007 15.0812 16.0007 15.5875V15.5875Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                <?=$arResult['PROPERTIES']['LANDING_INFO_GOTOVNOST']['VALUE']?>
                            </div>
                        <? } ?>

                        <? if (!empty($arResult['PROPERTIES']['LANDING_INFO_POMOSH']['VALUE'])) { ?>
                            <div class="detail-top-info-item">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9994 28.005H6.66387C5.1905 28.005 3.99609 26.8106 3.99609 25.3372V6.66277C3.99609 5.1894 5.1905 3.995 6.66387 3.995H22.6705C24.1439 3.995 25.3383 5.1894 25.3383 6.66277V10.6644" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 28.0049L19.5001 27.5727C19.7464 27.5423 19.9754 27.4306 20.1511 27.2553L28.6319 18.7744C29.5713 17.8391 29.5749 16.3194 28.6399 15.3797L28.6319 15.373V15.373C27.6966 14.4337 26.1769 14.4301 25.2372 15.365V15.373L16.8337 23.7765C16.6627 23.9463 16.5522 24.1675 16.5189 24.4061L16 28.0049Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6649 22.6694V22.6694C9.55987 22.6694 8.66406 21.7736 8.66406 20.6686V20.6686C8.66406 19.5635 9.55987 18.6677 10.6649 18.6677V18.6677C11.7699 18.6677 12.6657 19.5635 12.6657 20.6686V20.6686C12.6657 21.7736 11.7699 22.6694 10.6649 22.6694Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8.66406 9.33052H19.3352" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8.66406 13.9991H13.9996" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                <?=$arResult['PROPERTIES']['LANDING_INFO_POMOSH']['VALUE']?>
                            </div>
                        <? } ?>

                        <? if (!empty($arResult['PROPERTIES']['LANDING_INFO_COMMUNICATIONS']['VALUE'])) { ?>
                            <div class="detail-top-info-item">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M26.2913 12.8147V5.32888C26.2913 4.5922 25.6941 3.995 24.9574 3.995H22.4804C21.7437 3.995 21.1465 4.5922 21.1465 5.32888V8.40483" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.99609 14.2846L14.267 5.4809C15.2654 4.62697 16.7368 4.62697 17.7351 5.4809L28.0061 14.2846" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.7369 21.0327L24.9374 22.6333C25.3922 23.2396 25.4653 24.0508 25.1264 24.7286C24.7875 25.4065 24.0946 25.8347 23.3368 25.8347V25.8347C22.5789 25.8347 21.8861 25.4065 21.5472 24.7286C21.2083 24.0508 21.2814 23.2396 21.7361 22.6333L22.9366 21.0327C23.017 20.927 23.1362 20.8576 23.2678 20.8398C23.3994 20.8221 23.5327 20.8574 23.6382 20.938C23.6751 20.9652 23.7082 20.997 23.7369 21.0327Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M23.3367 29.3388C20.9089 29.3388 18.7201 27.8763 17.7911 25.6334C16.862 23.3904 17.3755 20.8086 19.0923 19.0919C20.809 17.3752 23.3907 16.8616 25.6337 17.7907C27.8767 18.7198 29.3392 20.9085 29.3392 23.3363C29.3392 26.6514 26.6517 29.3388 23.3367 29.3388" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5.71094 12.8146V25.3371C5.71094 26.8105 6.90534 28.0049 8.37872 28.0049H14.6667" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                <?=$arResult['PROPERTIES']['LANDING_INFO_COMMUNICATIONS']['VALUE']?>
                            </div>
                        <? } ?>

                        <div class="pt-3">
                            <a class="btn btn-lg btn-light btn-block" href="#book" data-fancybox="">Забронировать участок</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="overflow-hidden">
    <div class="container">

        <div class="py-5">
            <div class="row">
                <? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']) { ?>
                    <div class="col-12 col-lg mb-4 mb-lg-0">
                        <div class="detail-greencard" style="background-image: url(/images/green-remoteness_railway-bg.png)">
                            <div class="font-48 weight-700">
                                <?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']['DISPLAY_VALUE']?>
                            </div>
                            <div class="font-24 weight-100 mb-3">
                                на Ж/Д от центра
                            </div>

                            <? if ($arResult['DISPLAY_PROPERTIES']['ROUTE_BUS']) { ?>
                                <a class="btn btn-light green" href="#route_bus" data-fancybox="">Подробнее</a>
                            <? } ?>
                        </div>
                    </div>
                <? } ?>

                <? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS']) { ?>
                    <div class="col-12 col-lg">
                        <div class="detail-greencard" style="background-image: url(/images/green-remoteness-bg.png)">
                            <div class="font-48 weight-700">
                                <?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE']?>
                            </div>
                            <div class="font-24 weight-100 mb-3">
                                на машине от МКАД
                            </div>

                            <? if ($arResult['DISPLAY_PROPERTIES']['ROUTE_CAR']) { ?>
                                <a class="btn btn-light green" href="#route_car" data-fancybox="">Подробнее</a>
                            <? } ?>
                        </div>
                    </div>
                <? } ?>

                <? if ($arResult['DISPLAY_PROPERTIES']['ROUTE_BUS']) { ?>
                    <div id="route_bus" class="popup-route" style="display: none">
                        <div class="popup-greencard " >
                            Как добраться<br>
                            на Ж/Д
                            <img src="/images/green-remoteness_railway-bg.png" height="180" />
                        </div>

                        <div class="my-3">
                            <?=$arResult['DISPLAY_PROPERTIES']['ROUTE_BUS']['DISPLAY_VALUE']?>
                        </div>

                        <? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']) { ?>
                            <div class="mt-4 mb-3 d-flex align-items-center justify-content-between font-22 weight-700">
                                <? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']) { ?>
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 3V5H19V3H13ZM24.7188 5.28125L23.2812 6.71875L24.0625 7.5L23.0312 8.5625C21.125 6.97266 18.668 6 16 6C9.9375 6 5 10.9375 5 17C5 23.0625 9.9375 28 16 28C22.0625 28 27 23.0625 27 17C27 14.332 26.0273 11.875 24.4375 9.96875L25.5 8.9375L26.2812 9.71875L27.7188 8.28125L24.7188 5.28125ZM16 8C20.9805 8 25 12.0195 25 17C25 21.9805 20.9805 26 16 26C11.0195 26 7 21.9805 7 17C7 12.0195 11.0195 8 16 8ZM11.7188 11.2812L10.2812 12.7188L14.0625 16.5C14.0195 16.6602 14 16.8281 14 17C14 18.1055 14.8945 19 16 19C17.1055 19 18 18.1055 18 17C18 15.8945 17.1055 15 16 15C15.8281 15 15.6602 15.0195 15.5 15.0625L11.7188 11.2812Z" fill="black"/>
                                    </svg>
                                    <span class="ms-2 me-auto"><?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS_RAILWAY']['DISPLAY_VALUE']?></span>
                                <? } ?>

                            </div>
                        <? } ?>
                    </div>
                <? } ?>

                <? if ($arResult['DISPLAY_PROPERTIES']['ROUTE_CAR']) { ?>
                    <div id="route_car" class="popup-route" style="display: none">
                        <div class="popup-greencard " >
                            Как добраться <br>
                            на машине
                            <img src="/images/green-remoteness-bg.png" height="132" />
                        </div>

                        <div class="my-3">
                            <?=$arResult['DISPLAY_PROPERTIES']['ROUTE_CAR']['DISPLAY_VALUE']?>
                        </div>

                        <? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS'] || $arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']) { ?>
                            <div class="mt-4 mb-3 d-flex align-items-center justify-content-between font-22 weight-700">
                                <? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']) { ?>
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 3V5H19V3H13ZM24.7188 5.28125L23.2812 6.71875L24.0625 7.5L23.0312 8.5625C21.125 6.97266 18.668 6 16 6C9.9375 6 5 10.9375 5 17C5 23.0625 9.9375 28 16 28C22.0625 28 27 23.0625 27 17C27 14.332 26.0273 11.875 24.4375 9.96875L25.5 8.9375L26.2812 9.71875L27.7188 8.28125L24.7188 5.28125ZM16 8C20.9805 8 25 12.0195 25 17C25 21.9805 20.9805 26 16 26C11.0195 26 7 21.9805 7 17C7 12.0195 11.0195 8 16 8ZM11.7188 11.2812L10.2812 12.7188L14.0625 16.5C14.0195 16.6602 14 16.8281 14 17C14 18.1055 14.8945 19 16 19C17.1055 19 18 18.1055 18 17C18 15.8945 17.1055 15 16 15C15.8281 15 15.6602 15.0195 15.5 15.0625L11.7188 11.2812Z" fill="black"/>
                                    </svg>
                                    <span class="ms-2 me-auto"><?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']['DISPLAY_VALUE']?></span>
                                <? } ?>

                                <? if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS']) { ?>
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 4C5.25048 4 3 6.25048 3 9C3 9.85405 3.31002 10.6759 3.70898 11.584C4.10794 12.4921 4.62314 13.4481 5.13477 14.3301C6.15802 16.094 7.17773 17.5684 7.17773 17.5684L8 18.7598L8.82227 17.5684C8.82227 17.5684 9.84198 16.094 10.8652 14.3301C11.3769 13.4481 11.8921 12.4921 12.291 11.584C12.69 10.6759 13 9.85405 13 9C13 6.25048 10.7495 4 8 4ZM8 6C9.66848 6 11 7.33152 11 9C11 9.25045 10.81 9.98029 10.459 10.7793C10.1079 11.5783 9.62314 12.4843 9.13477 13.3262C8.56839 14.3025 8.37716 14.553 8 15.127C7.62284 14.553 7.43161 14.3025 6.86523 13.3262C6.37686 12.4843 5.89206 11.5783 5.54102 10.7793C5.18998 9.98029 5 9.25045 5 9C5 7.33152 6.33152 6 8 6ZM8 8C7.448 8 7 8.448 7 9C7 9.552 7.448 10 8 10C8.552 10 9 9.552 9 9C9 8.448 8.552 8 8 8ZM24 8C21.2505 8 19 10.2505 19 13C19 13.854 19.31 14.6759 19.709 15.584C20.1079 16.4921 20.6231 17.4481 21.1348 18.3301C22.158 20.094 23.1777 21.5684 23.1777 21.5684L24 22.7598L24.8223 21.5684C24.8223 21.5684 25.842 20.094 26.8652 18.3301C27.3769 17.4481 27.8921 16.4921 28.291 15.584C28.69 14.6759 29 13.854 29 13C29 10.2505 26.7495 8 24 8ZM24 10C25.6685 10 27 11.3315 27 13C27 13.2505 26.81 13.9803 26.459 14.7793C26.1079 15.5783 25.6231 16.4843 25.1348 17.3262C24.5684 18.3025 24.3772 18.553 24 19.127C23.6228 18.553 23.4316 18.3025 22.8652 17.3262C22.3769 16.4843 21.8921 15.5783 21.541 14.7793C21.19 13.9803 21 13.2505 21 13C21 11.3315 22.3315 10 24 10ZM24 12C23.448 12 23 12.448 23 13C23 13.552 23.448 14 24 14C24.552 14 25 13.552 25 13C25 12.448 24.552 12 24 12ZM8 21C7.448 21 7 21.448 7 22C7 22.552 7.448 23 8 23C8.552 23 9 22.552 9 22C9 21.448 8.552 21 8 21ZM12 22C11.448 22 11 22.448 11 23C11 23.552 11.448 24 12 24C12.552 24 13 23.552 13 23C13 22.448 12.552 22 12 22ZM16 23C15.448 23 15 23.448 15 24C15 24.552 15.448 25 16 25C16.552 25 17 24.552 17 24C17 23.448 16.552 23 16 23ZM20 24C19.448 24 19 24.448 19 25C19 25.552 19.448 26 20 26C20.552 26 21 25.552 21 25C21 24.448 20.552 24 20 24ZM24 25C23.448 25 23 25.448 23 26C23 26.552 23.448 27 24 27C24.552 27 25 26.552 25 26C25 25.448 24.552 25 24 25Z" fill="black"/>
                                    </svg>
                                    <span class="ms-2"><?=$arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE']?></span>
                                <? } ?>
                            </div>
                        <? } ?>

                        <? if ($arResult['DISPLAY_PROPERTIES']['GEOPOINT']) { ?>
                            <a class="btn btn-lg btn-primary btn-block" href="https://yandex.ru/maps/?rtext=~<?=$arResult['DISPLAY_PROPERTIES']['GEOPOINT']['VALUE']?>" target="_blank">Построить маршрут</a>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        </div>

        <div class="wide-gray-bg py-5">
            <div class="row align-items-stretch ">
                <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                    <? if ($arResult['DETAIL_TEXT']) echo '<div class="mb-3">'.$arResult['DETAIL_TEXT'].'</div>';?>

                    <? if ($arResult['DISPLAY_PROPERTIES']['ADVANTAGES']) { ?>
                        <div class="advantages-list">
                            <?=implode(' ', $arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'])?>
                        </div>
                    <? } ?>
                </div>

                <div class="col-12 col-lg-6">
                    <? if ($arResult['DISPLAY_PROPERTIES']['GEOPOINT']) { ?>
                        <div class="map-wrap">
                            <?=$arResult['DISPLAY_PROPERTIES']['GEOPOINT']['DISPLAY_VALUE']?>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php if ($arResult['DISPLAY_PROPERTIES']['DIAGRAMMA']['DISPLAY_VALUE']) { ?>
        <div class="readiness-communications py-5 text-center" >
            <div class="container">
                <div class="detail-top-info">
                    <div class="font-inter font-24 weight-500 text-center mb-4">Готовность коммуникаций</div>

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
                                    <a class="green " href="<?=$arDiagram['SUB_VALUES']['DIAG_LINK']['VALUE']?>" >Подробнее<i class="fal fa-external-link fa-xs ms-2"></i></a>
                                <? } ?>
                            </div>
                        <? } ?>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>

<div class="overflow-hidden">
    <div class="container">
        <? if (
            $arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN'] ||
            ( $arResult['DISPLAY_PROPERTIES']['SVG_MAP'] && $arResult['DISPLAY_PROPERTIES']['GDATA'] ) ||
            $arResult['DISPLAY_PROPERTIES']['IMAGE_KADASTR'] ||
            $arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN'] ||
            $arResult['DISPLAY_PROPERTIES']['TOUR']
        ) { ?>
            <div class=" py-5" >

                <div class=" pb-5">
                    <?
                    $isActive = true;
                    if ( $arResult['DISPLAY_PROPERTIES']['SVG_MAP'] && $arResult['DISPLAY_PROPERTIES']['GDATA'] ) {
                        $isActive = false;
                        $arData = json_decode($arResult['DISPLAY_PROPERTIES']['GDATA']['~VALUE']['TEXT'], true);
                        $arPriceColor = getPriceColor($arData);
                        ?>

                        <div class="t_ab-pane f_ade s_how a_ctive" id="plan">
                            <h2 class="mb-4 mt-2"><?=$arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN']['NAME']?></h2>


                            <div id="svg_wrap_wrap position-relative">
                                <ul class="nav nav-tabs pt-2 position-absolute ms-2" style="z-index: 1;">


                                    <? if ($arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN']) { ?>
                                        <li class="nav-item ">
                                            <a class="nav-link jsScrollTo <?=($isActive ? 'active':'')?> "
                                               d_ata-toggle="tab" href="#iframe_plan"><?=$arResult['DISPLAY_PROPERTIES']['IFRAME_PLAN']['NAME']?></a>
                                        </li>
                                        <?
                                        $isActive = false;
                                    } ?>


                                    <? if ($arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN'] || $arResult['DISPLAY_PROPERTIES']['SVG_MAP']) { ?>
                                        <li class="nav-item ms-lg-auto" id="share-popup-visible">
                                            <a class="nav-link jsScrollTo" href="#share-popup" data-fancybox>
                                                Поделиться<i class="fal fa-share-alt ms-2"></i>
                                            </a>
                                        </li>
                                    <? } ?>

                                    <? if ($arResult['DISPLAY_PROPERTIES']['IMAGE_PLAN'] || $arResult['DISPLAY_PROPERTIES']['SVG_MAP']) { ?>
                                        <li class="nav-item ms-lg-auto" id="share-popup-hidden" style="display: none;">
                                            <a class="nav-link jsScrollTo" href="#share-popup" data-fancybox>
                                                <i class="fal fa-share-alt"></i>
                                            </a>
                                        </li>
                                    <? } ?>
                                    <script>
                                        $(document).ready(function () {
                                            function toggleSharePopup() {
                                                if ($(window).width() >= 576) { // См. больше, чем sm
                                                    $('#share-popup-visible').show();
                                                    $('#share-popup-hidden').hide();
                                                } else {
                                                    $('#share-popup-visible').hide();
                                                    $('#share-popup-hidden').show();
                                                }
                                            }

                                            // Проверяем ширину окна при загрузке страницы
                                            toggleSharePopup();

                                            // Проверяем ширину окна при изменении размера
                                            $(window).resize(function () {
                                                toggleSharePopup();
                                            });
                                        });
                                    </script>
                                </ul>
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
                            <form class="form-ajax row gx-2 align-items-center" action="/local/include/ajax-share.php">
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

        <? if ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']) { ?>
                <div class="wide-darkblue-bg white py-5">
                    <div class="font-inter font-24 weight-500 mb-4 pb-2">Фотографии посёлка</div>

                    <div class="detail-slider ">
                        <? if ($arResult['DISPLAY_PROPERTIES']['VIDEO']) { ?>
                            <a class="detail-slider-item detail-slider-item-video jsScrollTo" href="#detail-video" >
                                <video autoplay muted loop >
                                    <source src="<?=$arResult['DISPLAY_PROPERTIES']['VIDEO']['FILE_VALUE']['SRC']?>" type='<?=$arResult['DISPLAY_PROPERTIES']['VIDEO']['FILE_VALUE']['CONTENT_TYPE']?>'>
                                </video>
                            </a>
                        <? } ?>

                        <? foreach ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] as $arPhotoItem) {
                            $img = CFile::ResizeImageGet($arPhotoItem['ID'], array('width'=>736, 'height'=>414), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
                            ?>
                            <a class="detail-slider-item" href="<?=$arPhotoItem['SRC']?>" data-fancybox="detail"><img class="<?=($isAllSold ? 'img-grayscale':'')?>" src="<?=$img['src']?>" /></a>
                        <? } ?>
                    </div>
                </div>
        <? } ?>

        <div class="row align-items-stretch py-5">
            <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                <div class="landing-bottom-form h-100">
                    <div class="detail-top-info">
                        <div class="font-22 mb-4 white">
                            Напишите нам, и мы ответим в&nbsp;ближайшее время
                        </div>

                        <form class="form-ajax ">
                            <input type="hidden" name="form_name" value="Подобрать участок">

                            <div class=" mb-3 ">
                                <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
                            </div>

                            <div class=" mb-3 ">
                                <input class="form-control form-control-lg  mask-phone" type="tel" name="phone" placeholder="Телефон" required>
                            </div>

                            <? /* <input class="captchaSid" type="hidden" name="captcha_sid" value=""/>
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend border">
                                    <img class="jsReloadCaptcha captchaImg" alt="CAPTCHA"/>
                                </div>

                                <input class="form-control form-control-lg" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите код с картинки" required />
                            </div> */ ?><input type="hidden" name="woc" value="1">

                            <div class="">
                                <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Отправить">
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="landing-bottom-ipoteka h-100">
                    <div class="font-32 mb-4">Ипотека 5,9%</div>
                </div>
            </div>
        </div>

        <div id="book" class="popup" style="display: none;">
            <img class="mb-2" src="/images/ico-question-green.svg" />
            <h2>
                Забронировать участок
            </h2>

            <div class="mb-3">
                <span class="gray"><?=$arResult['NAME']?></span>
            </div>

            <div class="darkgray-bg rounded-lg px-3 pt-3">
                <form class="form-ajax row gx-2 justify-content-center" action="/local/include/ajax-bron-create.php">
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
                <form class="form-ajax row gx-2 justify-content-center">
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

                    <? /* <div class="col-12 input-group mb-4">
                        <input class="captchaSid" type="hidden" name="captcha_sid" value=""/>
                        <div class="input-group-prepend border">
                            <img class="jsReloadCaptcha captchaImg" alt="CAPTCHA"/>
                        </div>

                        <input class="form-control form-control-lg" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите код с картинки" required />
                    </div> */ ?><input type="hidden" name="woc" value="1">

                    <div class="col-12">
                        <p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
                    </div>
                    <div class="col-12 col-md-8 text-center mb-3">
                        <input class="btn btn-primary btn-lg btn-block " type="submit" name="submit" placeholder="Забронировать">
                    </div>
                </form>
            </div>
        </div>

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

