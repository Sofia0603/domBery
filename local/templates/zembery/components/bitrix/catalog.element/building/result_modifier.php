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

$arResult['NAME'] = str_replace('м2', 'м<sup>2</sup>', $arResult['NAME']);




$arOneLineProp = array();
foreach ($arResult['DISPLAY_PROPERTIES'] as $code => $arValue) {
    if (strncmp($code, 'ONELINE_', 8) == 0) {
        switch ($code) {
            case 'ONELINE_AREA':
                $arValue['IMG'] = '/images/ico-floor_plan.svg';
                $arValue['SUFFIX'] = ' м<sup>2</sup>';
                $arValue['NAME'] = 'Строительная площадь';
                break;
            case 'ONELINE_BEDROOM':
                $arValue['IMG'] = '/images/ico-bedroom.svg';
                $arValue['NAME'] = 'Спальни';
                break;
            case 'ONELINE_BATHROOM':
                $arValue['IMG'] = '/images/ico-bathtub.svg';
                $arValue['NAME'] = 'Санузла';
                break;
            case 'ONELINE_LIVINGROOM_AREA':
                $arValue['IMG'] = '/images/ico-living_room.svg';
                $arValue['SUFFIX'] = ' м<sup>2</sup>';
                $arValue['NAME'] = 'Площадь гостиной';
                break;
            case 'ONELINE_BALCONS':
                $arValue['IMG'] = '/images/ico-balcony.svg';
                $arValue['NAME'] = 'Террасы и балконы';
                break;
            case 'ONELINE_FLOOR':
                $arValue['IMG'] = '/images/ico-staircase.svg';
                $arValue['NAME'] = 'Этажей';
                break;
        }

        $arOneLineProp[$code] = $arValue;
    }
}
$arResult['ONE_LINE_PROP'] = $arOneLineProp;

if ($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']['FILE_VALUE']['ID']) $arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']['FILE_VALUE'] = array($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']['FILE_VALUE']);

if ($arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']['FILE_VALUE']['ID']) $arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']['FILE_VALUE'] = array($arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']['FILE_VALUE']);

if ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE']['ID']) $arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] = array($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE']);

if ($arResult['DISPLAY_PROPERTIES']['ONLINE_VIDEO']['FILE_VALUE']['ID']) $arResult['DISPLAY_PROPERTIES']['ONLINE_VIDEO']['FILE_VALUE'] = array($arResult['DISPLAY_PROPERTIES']['ONLINE_VIDEO']['FILE_VALUE']);