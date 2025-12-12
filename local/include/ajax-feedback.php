<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$result = array('errors' => '', 'success' => false);
$roistatData = [
    'roistat' => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : 'nocookie',
    'key' => 'MjdhMTYyYzI5NDU5NWZlNjg4MmJlZTU0NjI0YjdmMDQ6MjY3NDg1', // Ключ для интеграции с CRM, указывается в настройках интеграции с CRM.
    'is_need_callback' => '0',
    'sync' => '0',
    'is_need_check_order_in_processing' => '1',
    'is_need_check_order_in_processing_append' => '1',
    'is_skip_sending' => '1',
    'fields' => []
];
$calltouchSiteId = '69841';
$calltouch_value = $_COOKIE['_ct_session_id']; /* ID сессии Calltouch, полученный из cookie */
$calltouchToken = '57dd2087a5401423d2f967a80e45a1a73de43c778204f';
$calltouchMod_id = 'a6ny51hd';
$calltouchData = [
    'sessionId' => $_COOKIE['_ct_session_id'], //$calltouchMod_id,
];



if (!empty($_REQUEST) && $_GET['AJAX'] == "Y") {

    //if(!empty($_REQUEST["captcha_sid"]) && !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"])) {
    if ( !isset($_REQUEST['woc']) && !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"]) ) {
        // Неправильное значение капчи
        $result = array('errors' => 'Неправильный код с картинки. <small>Что-бы обновить картинку кликните на нее.</small>', 'success' => false);
        echo json_encode($result);
        die();
    }


    CModule::IncludeModule("iblock");

    $el = new CIBlockElement;
    $text = '';

    foreach ($_REQUEST as $code=>$value) {
        switch ($code) {
            case 'form_name' :
                $text .= 'Заполнена форма: '.$value."\n";
                $roistatData['title'] = $value;
                $calltouchData['subject'] = $value;
                break;
            case 'product_name' :
                $text .= 'Название товара: '.$value."\n";
                break;
            case 'name' :
                $text .= 'Имя: '.$value."\n";
                $roistatData['name'] = $value;
                $calltouchData['fio'] = $value;
                break;
            case 'company' :
                $text .= 'Компания: '.$value."\n";
                break;
            case 'yourpost' :
                $text .= 'Должность: '.$value."\n";
                break;
            case 'page_url' :
                $text .= 'Страница: '.$value."\n";
                $calltouchData['requestUrl'] = $value;
                break;
            case 'phone' :
                $text .= 'Телефон: '.$value."\n";
                $roistatData['phone'] = $value;
                $calltouchData['phoneNumber'] = $value;
                break;
            case 'preferred-time' :
                $text .= 'Время звонка: '.$value."\n";
                break;
            case 'message' :
                $text .= 'Сообщение: '.$value."\n";
                $roistatData['comment'] = $value;
                $calltouchData['comment'] = $value;
                break;
            case 'email' :
                $text .= 'E-mail: '.$value."\n";
                $roistatData['email'] = $value;
                $calltouchData['email'] = $value;
                break;
            case 'doctor' :
                $text .= 'Специалист: '.$value."\n";
                break;
            case 'service' :
                $text .= 'Услуга: '.(is_array($value) ? implode('; ', $value) : $value).".\n";
                break;
            case 'object-price-output' :
                $text .= 'Стоимость недвижимости: '.$value."\n";
                break;
            case 'first-payment-output' :
                $text .= 'Первоначальный взнос: '.$value."\n";
                break;
            case 'years-output' :
                $text .= 'Срок кредита: '.$value."\n";
                break;
            case 'bank-select' :
                $text .= 'Ипотечная программа: '.$value."\n";
                break;
            case 'bank-percent' :
                $text .= 'Процентная ставка: '.$value."\n";
                break;
            case 'summ-credit' :
                $text .= 'Сумма кредита: '.$value."\n";
                break;
            case 'month-pay' :
                $text .= 'Ежемесячный платеж: '.$value."\n";
                break;

        }
    }

    // START отправляем дил в РОИСТАТ
    $ch = curl_init('https://cloud.roistat.com/api/proxy/1.0/leads/add?' . http_build_query($roistatData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $roiResult = curl_exec($ch);
    curl_close($ch);
    // END отправляем дил в РОИСТАТ


    // START отравляем лид в битрикс24
    $b4queryData = http_build_query(array(
        'fields' => array(
            'TITLE' => $_REQUEST['form_name'],
            'NAME' => $_REQUEST['name'],
            'PHONE' => [['VALUE' => $_REQUEST['phone']]],
            'COMMENTS' => $text,
            'UF_CRM_1729679503' => $_COOKIE['_ym_uid'], // client-id

            'UTM_SOURCE' => $_COOKIE['utm_source'],
            'UTM_MEDIUM' => $_COOKIE['utm_medium'],
            'UTM_CAMPAIGN' => $_COOKIE['utm_campaign'],
            'UTM_CONTENT' => $_COOKIE['utm_content'],
            'UTM_TERM' => $_COOKIE['utm_term'],
            'ASSIGNED_BY_ID' => 233
        ),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
    ));
    $b24queryUrl = 'https://zembery.bitrix24.ru/rest/219/qys098c4dqgskjij/crm.lead.add.json';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $b24queryUrl,
        CURLOPT_POSTFIELDS => $b4queryData,
    ));
    $b24result = curl_exec($curl);
    $b24result = json_decode($b24result,1);
    curl_close($curl);
    // END отравляем лид в битрикс24


    if ($USER->IsAuthorized()) {
        $text .= "\n\n";
        $text .= "Автор заявки: ".$USER->GetFullName()."\n";
        $text .= "http://".$_SERVER['SERVER_NAME'].'/bitrix/admin/user_edit.php?lang=ru&ID='.$USER->GetID();
    }

	  //foreach ($_REQUEST['FILE'] as &$arFile) $arFile['tmp_name'] = $_SERVER["DOCUMENT_ROOT"]. '/upload/tmp' .$arFile['tmp_name'];

    $name = $_REQUEST['form_name'].' - '.$_REQUEST['name'];

    $arLoadProductArray = Array(
        "IBLOCK_ID" => 9,
        "NAME" => $name,
        "PREVIEW_TEXT"    => $text,
        "DETAIL_TEXT" => "https://cloud.roistat.com/api/proxy/1.0/leads/add?" . http_build_query($roistatData) . "\n\n" . print_r($roiResult, true),
        "ACTIVE" => "Y",
        "PROPERTY_VALUES" => array('FILE' => $_REQUEST['FILE'])
    );


    $el_id = $el->Add($arLoadProductArray);
    if ($el_id === false) {
        $result = array('errors' => 'Ошибка записи. Сообщите администратору сайта. '.$el->LAST_ERROR, 'success' => false);
    } else {
        $result = array('errors' => '', 'success' => true, 'msg' => ($_REQUEST['success_msg'] ? $_REQUEST['success_msg'] : 'Данные успешно отправлены'), 'roiResult' => $roiResult);
    }

    // START отравляем лид в Calltouch
    $calltouchData['requestNumber'] = $el_id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded;charset=utf-8"));
    curl_setopt($ch, CURLOPT_URL,'https://api.calltouch.ru/calls-service/RestAPI/requests/'.$calltouchSiteId.'/register/');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($calltouchData) );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $calltouchResult = curl_exec($ch);
    curl_close($ch);
    $result['calltouch'] = $calltouchResult;
    //$result['calltouch-post'] = $calltouchData;
    // END отравляем лид в Calltouch

    //$result['b24'] = print_r($b24result, true);
    //$result['b24query'] = print_r($b4queryData, true);

    echo json_encode($result);

    $arPostFields = array(
        'TEXT' => $text,
    );
    CEvent::Send("FEEDBACK_FORM", 's1', $arPostFields, 'Y', "", (empty($_REQUEST['FILE']) ? array() : $_REQUEST['FILE']) );
}

