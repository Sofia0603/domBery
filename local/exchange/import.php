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
    $APPLICATION->SetTitle("импорт данных об участках");
}

CModule::IncludeModule("iblock");
$IBLOCK_ID = 1;

$res = CIBlockElement::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), array("IBLOCK_ID" => $IBLOCK_ID, "!PROPERTY_GTABLE_ID" => false), false, false, Array("ID", "NAME", "IBLOCK_ID", "PROPERTY_GTABLE_ID", "PROPERTY_GID_ID",) );
while($ar_fields = $res->GetNext()) {
    //echo '<pre>$ar_fields '.print_r( $ar_fields, true ).'</pre>';

    $cntFree = 0;

    $headers = array(
        'cache-control: max-age=0',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
        'sec-fetch-user: ?1',
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        'x-compress: null',
        'sec-fetch-site: none',
        'sec-fetch-mode: navigate',
        'accept-encoding: deflate, br',
        'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
    );
    $ch = curl_init('https://docs.google.com/spreadsheets/d/' . $ar_fields['PROPERTY_GTABLE_ID_VALUE'] . '/export?format=csv&gid=' . $ar_fields['PROPERTY_GID_ID_VALUE']);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $csv = curl_exec($ch);
    curl_close($ch);


    //echo '<pre>url '.'https://docs.google.com/spreadsheets/d/' . $ar_fields['PROPERTY_GTABLE_ID_VALUE'] . '/export?format=csv&gid=' . $ar_fields['PROPERTY_GID_ID_VALUE'].'</pre>';
    //echo '<pre>$csv '.print_r( $csv, true ).'</pre>';
    $csv = explode("\r\n", $csv);
    $arCsv = array_map('str_getcsv', $csv);
    $arResult = array();
    foreach ($arCsv as $key => $arLine) {
        if ($key > 0 && $arLine[0]) {
            $arResult[] = array(
                'num' => $arLine[0],
                'status' => $arLine[1],
                'volume' => $arLine[2],
                'price_of' => $arLine[25],
                'fullprice' => $arLine[26],
                'num_kadastr' => $arLine[3],
            );

            if ($arLine[1] == 'свободен') $cntFree=$cntFree+1;
        }
    }
        echo '<pre>';
    var_dump($arCsv);
    echo '</pre>';
    CIBlockElement::SetPropertyValuesEx($ar_fields['ID'], $IBLOCK_ID, array('GDATA' => json_encode( $arResult, JSON_UNESCAPED_UNICODE ), 'REMAINDER' => $cntFree.' из '.sizeof( $arResult )) );
    //echo '<pre>$arResult '.print_r( $arResult, true ).'</pre>';
}


if ($isWeb) {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
}