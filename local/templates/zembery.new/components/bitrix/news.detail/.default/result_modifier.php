<?php
/**
 * Created by PhpStorm.
 * User: yarmol
 * Date: 21.11.2018
 * Time: 17:38
 */

if ($arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']) {
    if (is_array($arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE'])) $arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE'] = implode('', $arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE']);

    $arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE'] = str_replace('<a ', '<a class="btn btn-outline-secondary font-14 mr-2" ', $arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE']);
}

$this->__component->SetResultCacheKeys(array(
    "NAME",
    "PREVIEW_TEXT",
    "PREVIEW_PICTURE",
));
