<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$result = array('errors' => '', 'success' => false);

if (!empty($_REQUEST)) {

    //if(!empty($_REQUEST["captcha_code"]) && !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_code"])) {
    if( !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_code"]) ) {
        // Неправильное значение капчи
        $result = array('errors' => 'Неправильный код с картинки. <small>Кликните на картинку что-бы поменять код</small>', 'success' => false);
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
                break;
            case 'product_name' :
                $text .= 'Название поселка: '.$value."\n";
                break;
            case 'name' :
                $text .= 'Имя: '.$value."\n";
                break;
            case 'page_url' :
                $text .= 'Страница: '.$value."\n";
                break;
            case 'phone' :
                $text .= 'Телефон: '.$value."\n";
                break;
            case 'message' :
                $text .= 'Сообщение: '.$value."\n";
                break;
            case 'email' :
                $text .= 'E-mail: '.$value."\n";
                break;
            case 'service' :
                $text .= 'Услуга: '.(is_array($value) ? implode('; ', $value) : $value).".\n";
                break;
        }
    }

    $name = $_REQUEST['form_name'] . ' ' . $_REQUEST['product_name'] . ' - ' . $_REQUEST['email'];

    $arLoadProductArray = Array(
        "IBLOCK_ID" => 9,
        "NAME" => $name,
        "PREVIEW_TEXT"    => $text,
        "ACTIVE" => "Y",
        //"PROPERTY_VALUES" => array('FILE' => $_REQUEST['FILE'])
    );


    $el_id = $el->Add($arLoadProductArray);
    if ($el_id === false) {
        $result = array('errors' => 'Ошибка записи. Сообщите администратору сайта. '.$el->LAST_ERROR, 'success' => false);
    } else {
        $result = array('errors' => '', 'success' => true, 'msg' => ($_REQUEST['success_msg'] ? $_REQUEST['success_msg'] : 'Данные успешно отправлены'));
    }

    echo json_encode($result);

    $arPostFields = array(
        'TEXT' => $text,
    );
    CEvent::Send("FEEDBACK_FORM", 's1', $arPostFields, 'Y', "", (empty($_REQUEST['FILE']) ? array() : $_REQUEST['FILE']) );

    $arPostFields = array(
        'EMAIL' => $_REQUEST['email'],
        'PRODUCT_NAME' => $_REQUEST['product_name'],
        'PAGE_URL' => $_REQUEST['page_url'],
        'MAP_IMAGE' => $_REQUEST['map_image'],
        'HTML_LEGEND' => $_REQUEST['html_legend'],
        'PHONE' => $_REQUEST['phone'],
    );
    CEvent::Send("SHARE", 's1', $arPostFields, 'Y', );
}

