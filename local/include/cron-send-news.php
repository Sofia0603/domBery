<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//define("LANG", "ru");
//ini_set('memory_limit', '2048M');

if (empty($_SERVER["DOCUMENT_ROOT"])) {
    $isWeb = false;
    $_SERVER["DOCUMENT_ROOT"] = '/home/z/zembery/zembery.beget.tech/public_html';
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
} else {
    $isWeb = true;
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
}

CModule::IncludeModule("iblock");
$IBLOCK_ID_NEWS = 2;

CModule::IncludeModule("subscribe");

// получаем список новостей для рассылки
$res = CIBlockElement::GetList(Array(), array('IBLOCK_ID' => $IBLOCK_ID_NEWS, 'ACTIVE' => 'Y', '!PROPERTY_SEND_MAIL' => 'Y'), false, false, array('ID', 'NAME', 'DATE_ACTIVE_FROM', 'DETAIL_PICTURE', 'PREVIEW_PICTURE', 'DETAIL_TEXT', 'PROPERTY_LNK_TOWNSHIP', 'DETAIL_PAGE_URL'));

while($arNews = $res->GetNext()) {

    // создаем массив id рассылок, по поселкам, привязанным к новости
    $arRubricIds = array();
    foreach ($arNews['PROPERTY_LNK_TOWNSHIP_VALUE'] as $townshipId) {
        $arRubric = CRubric::GetList(array(), array('CODE' => 'township'.$townshipId))->GetNext();
        if ($arRubric['ID']) $arRubricIds[] = intval( $arRubric['ID'] );
    }

    // если подписок нет (или нет поселков в новости) пропускаем
    if (empty($arRubricIds)) continue;

    //echo '<pre>$arRubricIds '. print_r($arRubricIds, true).'</pre>';

    // создаем массив емайлов получателей новости
    $arEmail = array();
    $subscr = CSubscription::GetList( array("ID"=>"ASC"), array("RUBRIC"=>$arRubricIds, "CONFIRMED"=>"Y", "ACTIVE"=>"Y") );
    while (($arSubscr = $subscr->Fetch())) {
        $arEmail[] = $arSubscr["EMAIL"];
    }
    $arEmail = array_unique( $arEmail );

    // если емайлов нет пропускаем
    if (empty($arEmail)) continue;

    //echo '<pre>$arNews '. print_r($arNews, true).'</pre>';
    echo '<pre>$arEmail '. print_r($arEmail, true).'</pre>';

    // формируем тело письма
    $message = '<h2>' . $arNews['~NAME'] . '</h2>';

    if (!$arNews['DETAIL_PICTURE']) $arNews['DETAIL_PICTURE'] = $arNews['PREVIEW_PICTURE'];
    if($arNews['DETAIL_PICTURE']) {
        $arFileTmp = CFile::ResizeImageGet($arNews['DETAIL_PICTURE'], array('width' => 400, 'height' => 730), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        if($arFileTmp['src']) $arFileTmp['src'] = 'https://zembery.ru'.$arFileTmp['src'];
        $arPicture = array_change_key_case($arFileTmp, CASE_UPPER);
        $message .= '<img alt="' . $arNews['NAME'] . '" width="' . $arPicture['WIDTH'] . '" height="' . $arPicture['HEIGHT'] . '" src="' . $arPicture['SRC'] . '" />';
    }

    $message .= '<div>'.$arNews['~DETAIL_TEXT'].'</div>';
    $message .= '<br><p><a style="text-align: center;white-space: nowrap;padding: 6px 15px;font-size: 16px; font-weight: 700;line-height: 24px;border-radius: 0.25rem;cursor: pointer;color: #fff;background-color: #4ADE80 ;border-color: #4ADE80 ;text-decoration: none;" href="' . 'https://zembery.ru'.$arNews['DETAIL_PAGE_URL'] . '">Читать на сайте &rarr;</a></p>';
    $message .= '<div style="clear:both;"></div>';

    echo print_r($message, true) . '<hr>';

    $arPostFields = array(
        'NEWS_NAME' => $arNews['NAME'],
        'TEXT' => $message,
        'EMAIL_TO' => implode(',', $arEmail)
    );
    CEvent::Send("NEWS_SENDER", 's1', $arPostFields);

    CIBlockElement::SetPropertyValues($arNews['ID'], $IBLOCK_ID_NEWS, 'Y', 'SEND_MAIL');
}
