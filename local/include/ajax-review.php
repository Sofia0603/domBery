<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$result = array('errors' => '', 'success' => false);

if (!empty($_REQUEST) && $_GET['AJAX'] == "Y") {

    if( !isset($_REQUEST['woc']) && !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"]) ) {
    //if(!empty($_REQUEST["captcha_sid"]) && !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"])) {
        // Неправильное значение капчи
        $result = array('errors' => 'Неправильный код с картинки. <small>Что-бы обновить картинку кликните на нее.</small>', 'success' => false);
        echo json_encode($result);
        die();
    }

    CModule::IncludeModule("iblock");
    $el = new CIBlockElement;

	foreach ($_REQUEST['FILE'] as &$arFile) $arFile['tmp_name'] = $_SERVER["DOCUMENT_ROOT"]. '/upload/tmp' .$arFile['tmp_name'];

    $name = $_REQUEST['name'];

    $arLoadProductArray = Array(
        "IBLOCK_ID" => 7,
        "NAME" => $name,
        "PREVIEW_TEXT"    => $_REQUEST['message'],
        "ACTIVE" => "N",
        "PROPERTY_VALUES" => array('EMAIL' => $_REQUEST['email'], 'TOWNSHIP' => $_REQUEST['township'], 'FILE' => $_REQUEST['FILE'])
    );

    if ($_REQUEST['IMAGE']) $arLoadProductArray["PREVIEW_PICTURE"] = CFile::MakeFileArray($_REQUEST['IMAGE']);

    $el_id = $el->Add($arLoadProductArray);
    if ($el_id === false) {
        $result = array('errors' => 'Ошибка записи. Сообщите администратору сайта. '.$el->LAST_ERROR /*. '<pre>'.print_r($arLoadProductArray, true).'</pre>'*/, 'success' => false);
    } else {
        $result = array('errors' => '', 'success' => true, 'msg' => ($_REQUEST['success_msg'] ? $_REQUEST['success_msg'] : 'Данные успешно отправлены'));
    }

    echo json_encode($result);

    $text = 'Поступил отзыв от ' . $_REQUEST['name'] . "<br>";
    $text .= $_REQUEST['message'] . "<br><br>";

    $arTownship = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), array("IBLOCK_ID" => 1, "ID" => $_REQUEST['township']), false, false, array("ID", "NAME"))->GetNext();
    $text .= 'Поселок: ' . $arTownship['NAME'] . '<br>';
    $text .= 'Емайл: ' . $_REQUEST['email'] . '<br>';

    $arPostFields = array(
        'TEXT' => $text,
    );
    CEvent::Send("FEEDBACK_FORM", 's1', $arPostFields, 'Y', "", (empty($_REQUEST['FILE']) ? array() : $_REQUEST['FILE']) );
}

