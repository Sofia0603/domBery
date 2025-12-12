<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arSectionsResult = array();
foreach($arResult["SEARCH"] as $arItem) {
    if ($arItem["CHAIN_PATH"] || $arItem['PARAM2'] == 1) {
        if ($arItem['PARAM2'] == 1) {
            $arSectionsResult['Поселки'][] = $arItem;
        } else {
            $arSectionsResult[ strip_tags($arItem["CHAIN_PATH"]) ][] = $arItem;
        }
    } else {
        $arSectionsResult[""][] = $arItem;
    }
}

$arResult["SECTIONS"] = $arSectionsResult;