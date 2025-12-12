<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$result = array('errors' => '', 'success' => false);

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

    $name = $_REQUEST['name'].' - '.$_REQUEST['email'];

    $arLoadProductArray = Array(
        "IBLOCK_ID" => 10,
        "NAME" => $name,
        //"PREVIEW_TEXT"    => $text,
        "ACTIVE" => "Y",
        "PROPERTY_VALUES" => array(
            'NAME' => $_REQUEST['name'],
            'PRODUCT' => $_REQUEST['product'],
            'EMAIL' => $_REQUEST['email'],
        )
    );

    $text .= 'Форма подписки на цену<br>';
    $text .= 'Имя '.$_REQUEST['name'].'<br>';
    $text .= 'Поселок '.$_REQUEST['product'].'<br>';
    $text .= 'Емайл '.$_REQUEST['email'].'<br>';

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
}

