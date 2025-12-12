<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$cp = $this->__component; // объект компонента

if (is_object($cp))
{
    // добавим в arResult компонента поля
    $cp->arResult['NEARBY'] = $arResult['PROPERTIES']['NEARBY']['VALUE'];
    $cp->SetResultCacheKeys(array('NEARBY'));
}

$arOneLineProp = array();
if ($arResult['DISPLAY_PROPERTIES']['SHOSSE']) $arOneLineProp[] = $arResult['DISPLAY_PROPERTIES']['SHOSSE']['DISPLAY_VALUE'] . ' шоссе';
if ($arResult['DISPLAY_PROPERTIES']['REGION']) $arOneLineProp[] = $arResult['DISPLAY_PROPERTIES']['REGION']['DISPLAY_VALUE'] . ' городской округ';
if ($arOneLineProp) $arResult['DISPLAY_PROPERTIES']['ONE_LINE_PROP']['DISPLAY_VALUE'] = implode(', ', $arOneLineProp);

if ($arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) {
    $arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE'] = CCurrencyLang::CurrencyFormat( $arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['VALUE'], 'RUB' );
}

if ($arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE_SALE']) {
    $arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE_SALE']['DISPLAY_VALUE'] = CCurrencyLang::CurrencyFormat( $arResult['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE_SALE']['VALUE'], 'RUB' );
}

if ($arResult['DISPLAY_PROPERTIES']['GEOPOINT']) {
    $arCoord = explode(',', $arResult['DISPLAY_PROPERTIES']['GEOPOINT']['VALUE']);
    $arResult['DISPLAY_PROPERTIES']['GEOPOINT_SHOT'] = array(
        'NAME' => 'Координаты GPS',
        'DISPLAY_VALUE' => round($arCoord[0],6) . ', ' . round($arCoord[1],6) . '<i class="fal fa-crosshairs ml-2 green"></i>'
    );
}

if ($arResult['DISPLAY_PROPERTIES']['ADVANTAGES']) {
    foreach ($arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['VALUE_XML_ID'] as $keyAdv => $arAdvItem) {
        $text = $arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['VALUE'][ $keyAdv ];
        preg_match('#^([^(]*)\(([^()]*)\)$#', $text, $match);
        if (empty($match)) {
            $title = $text;
        } else {
            $text = $match[1];
            $title = $match[2];
        }

        $arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'][ $keyAdv ] = '<span class="advantages-item " >';
        $arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'][ $keyAdv ] .= '<img src="/images/ico-'.$arAdvItem.'.svg" title="'.$title.'" alt="'.$title.'" />';
        $arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'][ $keyAdv ] .= $text;
        $arResult['DISPLAY_PROPERTIES']['ADVANTAGES']['DISPLAY_VALUE'][ $keyAdv ] .= '</span>';
    }
}

if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE']) $arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE'] = $arResult['DISPLAY_PROPERTIES']['REMOTENESS']['DISPLAY_VALUE'].'  км';
if ($arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']['DISPLAY_VALUE']) $arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']['DISPLAY_VALUE'] = $arResult['DISPLAY_PROPERTIES']['REMOTENESS_TIME']['DISPLAY_VALUE'].'  минут';

$arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] = array_reverse($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE']);
