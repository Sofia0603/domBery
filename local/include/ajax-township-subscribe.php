<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$result = array('errors' => '', 'success' => false);

if (!empty($_REQUEST) && $_GET['AJAX'] == "Y") {

    if (!empty($_REQUEST["captcha_code"]) && !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_code"])) {
        // Неправильное значение капчи
        $result = array('errors' => 'Неправильный код с картинки. <small>Что-бы обновить картинку кликните на нее.</small>', 'success' => false);
        echo json_encode($result);
        die();
    }

    CModule::IncludeModule("iblock");
    CModule::IncludeModule("subscribe");

    $productId = intval($_REQUEST['product']);
    if (empty($_REQUEST['email']) || !$productId) {
        $result = array('errors' => 'Неправильно заполнены поля', 'success' => false);
        echo json_encode($result);
        die();
    }


    $arRubric = CRubric::GetList(array(), array('CODE' => 'township'.$productId))->GetNext();
    $rubricId = intval( $arRubric['ID'] );

    if (!$rubricId) { // подписки на этот поселок еще нет, создаем
        $arProduct = CIBlockElement::GetByID($productId)->GetNext();

        $rubric = new CRubric;
        $arFields = Array(
            "ACTIVE" => "Y",
            "NAME" => 'Поселок ' . $arProduct['NAME'],
            "CODE" => 'township'.$productId,
            "DESCRIPTION" => 'Новости и сообщения по поселку ' . $arProduct['NAME'],
            "LID" => 's1'
        );
        $rubricId = $rubric->Add($arFields);
        if($rubricId == false) {
            $result = array('errors' => 'Ошибка создания рубрики. Сообщите администратору сайта. '.$rubric->LAST_ERROR, 'success' => false);
        }
    }

    if ($rubricId) {

        if ($arSub = CSubscription::GetByEmail($_REQUEST['email'])->Fetch()) {
            // емайл уже подписан, вносим рубрику в подписку

            $subscr = new CSubscription;
            if ($ID = $subscr->Update(
                $arSub['ID'],
                array( 'RUB_ID' => array_merge( CSubscription::GetRubricArray($arSub['ID']), array($rubricId)) )
                )) {
                $result = array('errors' => '', 'success' => true, 'msg' => ($_REQUEST['success_msg'] ? $_REQUEST['success_msg'] : 'Подписка прошла успешно!'));
            } else {
                $result = array('errors' => 'Ошибка подписки подписанного адреса. Сообщите администратору сайта. ' . $subscr->LAST_ERROR, 'success' => false);
            }

        } else {
            // емайл еще не подписан, создаем
            $subscribeFields = array(
                "USER_ID" => false,
                "FORMAT" => "html",
                "EMAIL" => $_REQUEST['email'],
                "ACTIVE" => "Y",
                "CONFIRMED" => "Y",
                "SEND_CONFIRM" => "N",
                "RUB_ID" => array($rubricId)
            );

            $subscr = new CSubscription;
            if ($ID = $subscr->Add($subscribeFields)) {
                $result = array('errors' => '', 'success' => true, 'msg' => ($_REQUEST['success_msg'] ? $_REQUEST['success_msg'] : 'Подписка прошла успешно!'));
            } else {
                $result = array('errors' => 'Ошибка создания подписки. Сообщите администратору сайта. ' . $subscr->LAST_ERROR, 'success' => false);
            }
        }
    }

}

echo json_encode($result);
