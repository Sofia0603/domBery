<?php
/**
 * Created by PhpStorm.
 * User: yarmol
 * Date: 21.11.2018
 * Time: 17:39
 */

$img = $arResult['PREVIEW_PICTURE']['SRC'];
if (empty($img) && CModule::IncludeModule("iblock")) {
    $res = CIBlockElement::GetByID($arResult["ID"]);
    $ar_res = $res->GetNext();
    $img = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
}

//$APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult['NAME'].'"/>');
//$APPLICATION->AddHeadString('<meta property="og:type" content="article"/>');
//$APPLICATION->AddHeadString('<meta property="og:image" content="'.$_SERVER['HTTP_X_FORWARDED_PROTO']."://".$_SERVER['SERVER_NAME'].$img.'"/>');
//$APPLICATION->AddHeadString('<meta property="og:site_name" content="'.$arResult['NAME'].'"/>');
//$APPLICATION->AddHeadString('<meta property="og:description" content="'.ucfirst($arResult['PREVIEW_TEXT']).'"/>');

$APPLICATION->SetPageProperty("og:image", SITE_SERVER_PROTOCOL . SITE_SERVER_NAME . $img);
