<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$result = array('errors' => '', 'success' => false);

if (!empty($_REQUEST)) {

    CModule::IncludeModule("iblock");

    $el = new CIBlockElement;
    $text = '';

    foreach ($_REQUEST as $code=>$value) {
        switch ($code) {
            case 'form_name' :
                $text .= 'Заполнена форма: '.$value."\n";
                break;
            case 'product_name' :
                $text .= 'Название товара: '.$value."\n";
                break;
            case 'name' :
                $text .= 'Имя: '.$value."\n";
                break;
            case 'company' :
                $text .= 'Компания: '.$value."\n";
                break;
            case 'yourpost' :
                $text .= 'Должность: '.$value."\n";
                break;
            case 'page_url' :
                $text .= 'Страница: '.$value."\n";
                break;
            case 'phone' :
                $text .= 'Телефон: '.$value."\n";
                break;
            case 'preferred-time' :
                $text .= 'Время звонка: '.$value."\n";
                break;
            case 'message' :
                $text .= 'Сообщение: '.$value."\n";
                break;
            case 'email' :
                $text .= 'E-mail: '.$value."\n";
                break;
            case 'doctor' :
                $text .= 'Специалист: '.$value."\n";
                break;
            case 'service' :
                $text .= 'Услуга: '.(is_array($value) ? implode('; ', $value) : $value).".\n";
                break;
        }
    }

    if ($USER->IsAuthorized()) {
        $text .= "\n\n";
        $text .= "Автор заявки: ".$USER->GetFullName()."\n";
        $text .= "http://".$_SERVER['SERVER_NAME'].'/bitrix/admin/user_edit.php?lang=ru&ID='.$USER->GetID();
    }

	  //foreach ($_REQUEST['FILE'] as &$arFile) $arFile['tmp_name'] = $_SERVER["DOCUMENT_ROOT"]. '/upload/tmp' .$arFile['tmp_name'];

    $name = 'Dombery ' . $_REQUEST['form_name'].' - '.$_REQUEST['name'];

    $arLoadProductArray = Array(
        "IBLOCK_ID" => 9,
        "NAME" => $name,
        "PREVIEW_TEXT"    => $text,
        "ACTIVE" => "Y",
        "PROPERTY_VALUES" => array('FILE' => $_REQUEST['FILE'])
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
}

