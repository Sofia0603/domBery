<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global array $arParams */
use Bitrix\Main\Type\Collection;

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);


$arResult['ALL_FIELDS'] = array();
$existShow = !empty($arResult['SHOW_FIELDS']);
$existDelete = !empty($arResult['DELETED_FIELDS']);
if ($existShow || $existDelete)
{
	if ($existShow)
	{
		foreach ($arResult['SHOW_FIELDS'] as $propCode)
		{
			$arResult['SHOW_FIELDS'][$propCode] = array(
				'CODE' => $propCode,
				'IS_DELETED' => 'N',
				'ACTION_LINK' => str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode);
		$arResult['ALL_FIELDS'] = $arResult['SHOW_FIELDS'];
	}
	if ($existDelete)
	{
		foreach ($arResult['DELETED_FIELDS'] as $propCode)
		{
			$arResult['ALL_FIELDS'][$propCode] = array(
				'CODE' => $propCode,
				'IS_DELETED' => 'Y',
				'ACTION_LINK' => str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode, $arResult['DELETED_FIELDS']);
	}
	Collection::sortByColumn($arResult['ALL_FIELDS'], array('SORT' => SORT_ASC));
}


$arResult['ALL_PROPERTIES'] = array();
$existShow = !empty($arResult['SHOW_PROPERTIES']);
$existDelete = !empty($arResult['DELETED_PROPERTIES']);
if ($existShow || $existDelete)
{
	if ($existShow)
	{
		foreach ($arResult['SHOW_PROPERTIES'] as $propCode => $arProp)
		{
			$arResult['SHOW_PROPERTIES'][$propCode]['IS_DELETED'] = 'N';
			$arResult['SHOW_PROPERTIES'][$propCode]['ACTION_LINK'] = str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_PROPERTY_TEMPLATE']);
		}
		$arResult['ALL_PROPERTIES'] = $arResult['SHOW_PROPERTIES'];
	}
	unset($arProp, $propCode);
	if ($existDelete)
	{
		foreach ($arResult['DELETED_PROPERTIES'] as $propCode => $arProp)
		{
			$arResult['DELETED_PROPERTIES'][$propCode]['IS_DELETED'] = 'Y';
			$arResult['DELETED_PROPERTIES'][$propCode]['ACTION_LINK'] = str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_PROPERTY_TEMPLATE']);
			$arResult['ALL_PROPERTIES'][$propCode] = $arResult['DELETED_PROPERTIES'][$propCode];
		}
		unset($arProp, $propCode, $arResult['DELETED_PROPERTIES']);
	}
	Collection::sortByColumn($arResult["ALL_PROPERTIES"], array('SORT' => SORT_ASC, 'ID' => SORT_ASC));
}


$arParams['PROPERTY_CODE'] = $arParams['~PROPERTY_CODE'];
foreach ($arResult["SHOW_PROPERTIES"] as $code => $arShowProperty) {
    if (!in_array($code, $arParams['PROPERTY_CODE'])) unset($arResult["SHOW_PROPERTIES"][$code]);
}
foreach($arResult["ITEMS"] as &$arElement) {
    $arDisplayProperties = array();

    foreach ($arElement['DISPLAY_PROPERTIES'] as $code => $arValue) {
        if (in_array($code, $arParams['PROPERTY_CODE'])) {
            $arDisplayProperties[$code] = $arValue;

            if ($arDisplayProperties['PRICE_PER_SQUARE']) $arDisplayProperties['PRICE_PER_SQUARE']['DISPLAY_VALUE'] = CurrencyFormat( $arDisplayProperties['PRICE_PER_SQUARE']['VALUE'], "RUB");

            if ($arDisplayProperties['ADVANTAGES']) {
                $arDisplayProperties['ADVANTAGES']['DISPLAY_VALUE'] = '<table class="table table-borderless table-sm"><tr><td>&nbsp;</td></tr>';
                foreach ($arResult["SHOW_PROPERTIES"]['ADVANTAGES']['VALUE_XML_ID'] as $xmlAdvantages) {
                    if (in_array($xmlAdvantages, $arDisplayProperties['ADVANTAGES']['VALUE_XML_ID'])) {
                        $arDisplayProperties['ADVANTAGES']['DISPLAY_VALUE'] .= '<tr><td><i class="fal fa-check green"></i></td></tr>';
                    } else {
                        $arDisplayProperties['ADVANTAGES']['DISPLAY_VALUE'] .= '<tr><td>&nbsp;</td></tr>';
                    }
                }
                $arDisplayProperties['ADVANTAGES']['DISPLAY_VALUE'] .= '</table>';
            };
        }
    }
    $arElement['DISPLAY_PROPERTIES'] = $arDisplayProperties;
}

if ($arResult['SHOW_PROPERTIES']['ADVANTAGES']) {
    $arResult['SHOW_PROPERTIES']['ADVANTAGES']['NAME'] = '<table class="table table-borderless table-sm"><tr><td>'.$arResult['SHOW_PROPERTIES']['ADVANTAGES']['NAME'].':</td></tr>';
    foreach ($arResult["SHOW_PROPERTIES"]['ADVANTAGES']['VALUE'] as $nameAdvantages) {
        $arResult['SHOW_PROPERTIES']['ADVANTAGES']['NAME'] .= '<tr><td>'.$nameAdvantages.'</td></tr>';
    }
    $arResult['SHOW_PROPERTIES']['ADVANTAGES']['NAME'] .= '</table>';
};
