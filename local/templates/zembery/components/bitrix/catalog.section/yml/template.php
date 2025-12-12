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

// источники
// https://snipp.ru/php/yandex-market-php
// https://yandex.ru/support/direct/feeds/requirements-other-categories.html


$out = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
$out .= '<realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06">' . "\r\n";
$out .= '' . "\r\n";
$out .= '<generation-date>' . date('Y-m-d H:i') . '</generation-date>' . "\r\n";
//$out .= '<shop>' . "\r\n";


//$out .= '<offers>' . "\r\n";
foreach ($arResult['ITEMS'] as $arItem) {
    if ( empty($arItem['PROPERTIES']['GDATA']['DATA']) || $arItem['PROPERTIES']['ALL_SOLD']['VALUE'] ) continue;

    $picture = '';
    foreach ($arItem['PROPERTIES']['MORE_PHOTO']['VALUE'] as $picId) $picture .= '<image>https://zembery.ru' . CFile::GetPath($picId) . '</image>' . "\r\n";

    foreach ($arItem['PROPERTIES']['GDATA']['DATA'] as $arOffer) {
        if ($arOffer['status'] !== "свободен") continue;
        if (!$arOffer['fullprice']) continue;

        $out .= '<offer internal-id="' . $arItem['ID'] . '-' . $arOffer['num'] . '">' . "\r\n";
        $out .= '<type>продажа</type>' . "\r\n";
        $out .= '<category>участок</category>' . "\r\n";
        // Название товара
        $out .= '<name>'.$arItem['NAME']. ', участок ' . $arOffer['num'] . '</name>' . "\r\n";

        $out .= '<location>' . "\r\n";
        $out .= '<locality-name>поселок '.$arItem['NAME'].'</locality-name>' . "\r\n";
        if ($arItem['PROPERTIES']['PROPERTIES']['VALUE']) {
            $out .= '<sub-locality-name>округ '.$arItem['PROPERTIES']['PROPERTIES']['VALUE'].'</sub-locality-name>' . "\r\n";
        }
        $out .= '</location>' . "\r\n";
        //$out .= '' . "\r\n";

        $out .= '<sales-agent>' . "\r\n";
        $out .= '<organization>ООО "Зембери"</organization>' . "\r\n";
        $out .= '</sales-agent>' . "\r\n";

        $out .= '<area>' . "\r\n";
        $out .= '<value>'.$arOffer['volume'].'</value>' . "\r\n";
        $out .= '<unit>кв. м</unit>' . "\r\n";
        $out .= '</area>' . "\r\n";

        // URL страницы товара
        $out .= '<url>https://zembery.ru' . $arItem['DETAIL_PAGE_URL'] . '</url>' . "\r\n";

        $out .= '<price>' . "\r\n";
        $out .= '<value>' . $arOffer['fullprice'] . '</value>' . "\r\n";
        $out .= '<currency>RUR</currency>' . "\r\n";
        $out .= '</price>' . "\r\n";

        // ID категории
        //$out .= '<categoryId>' . $arItem['category'] . '</categoryId>' . "\r\n";

        // Изображения товара, до 10 ссылок
        $out .= $picture;

        // Описание товара, максимум 3000 символов
        $out .= '<description><![CDATA[' . strip_tags(stripslashes($arItem['DETAIL_TEXT'])) . ']]></description>' . "\r\n";
        $out .= '</offer>' . "\r\n";
    }
}

//$out .= '</offers>' . "\r\n";
$out .= '</realty-feed>' . "\r\n";


//<pre><?=print_r($arResult['ITEMS'], true) ? ></pre>

echo $out;