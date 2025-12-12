<?php
/**
 * Created by PhpStorm.
 * User: yarmol
 * Date: 08.10.2020
 * Time: 16:47
 */

CModule::IncludeModule("iblock");


$hShopz = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>1, 'ACTIVE'=>'Y'), false, false,
    array('ID', 'NAME', 'PROPERTY_GEOPOINT', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_SHOSSE', 'PROPERTY_PRICE_PER_SQUARE'));
while($row = $hShopz->GetNext()) {
    if (!empty($row['PROPERTY_GEOPOINT_VALUE'])) {
        $img = CFile::ResizeImageGet($row['PREVIEW_PICTURE'], array('width'=>200, 'height'=>180), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 80);
        $arTmp = explode(',', $row['PROPERTY_GEOPOINT_VALUE']);
        $text = '<div class="map-label">';
        $text .= '<img src="'.$img['src'].'" class="d-block mb-2" />';
        $text .= '<a class="blue d-block strong font-16  stretched-link" href="'.$row['DETAIL_PAGE_URL'].'" >' .$row['NAME'].'&nbsp;<i class="fal fa-external-link"></i></a>';
        if ($row['PROPERTY_SHOSSE_VALUE']) $text .= '<div class="mb-1 green">ш.&nbsp;'.$row['PROPERTY_SHOSSE_VALUE'].'</div>';
        if ($row['PROPERTY_PRICE_PER_SQUARE_VALUE']) $text .= '<div class="font-18 pink strong">от '.$row['PROPERTY_PRICE_PER_SQUARE_VALUE'].'₽ за сотку</div>';
        $text .= '</div>';
        $arResult['POSITION']['PLACEMARKS'][] = array(
            'LON' => $arTmp[1],
            'LAT' => $arTmp[0],
            'TEXT' => $text,
            'NAME' => $row['NAME'],
        );
    }
}

