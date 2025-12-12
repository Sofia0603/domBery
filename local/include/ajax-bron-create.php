<?
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($_GET['AJAX'] !== "Y") die();

use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem,
    Bitrix\Sale\PaySystem\Manager;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

global $APPLICATION;
$USER_ID = 2; // анонимный юзер на которого вешаем заказ
$result = array('errors' => '', 'success' => false);

$result['debug'][] = '1';

if ($arUser = CUser::GetByLogin($_REQUEST['email'])->Fetch() ) {
    $result['debug'][] = '2';

    if ($arUser['LOGIN'] !== $arUser['EMAIL']) {
        $result['errors'] = 'error admin';
        echo json_encode($result);
        die();
    }
    $USER_ID = $arUser['ID'];
} else {
    $result['debug'][] = '3';
    $arUserFields = Array(
        "NAME"              => $_REQUEST['name'],
        "EMAIL"             => $_REQUEST['email'],
        "LOGIN"             => $_REQUEST['email'],
        "ACTIVE"            => "Y",
        "PASSWORD"          => md5($_REQUEST['email']),
        "CONFIRM_PASSWORD"  => md5($_REQUEST['email']),
        "PERSONAL_PHONE" => $_REQUEST['phone'],
    );

    $user = new CUser;
    if (!$USER_ID = $user->Add($arUserFields)) {
        $result['errors'] = 'error adduser '.print_r($user->LAST_ERROR, true);
        echo json_encode($result);
        die();
    }
}

$result['debug'][] = '4';
if (intval($USER_ID) > 0) {
    $result['debug'][] = '5';

    $siteId = Context::getCurrent()->getSite();
    $currencyCode = CurrencyManager::getBaseCurrency();

// Создаёт новый заказ
    $order = Order::create($siteId, $USER_ID);
    $order->setPersonTypeId(1);
    $order->setField('CURRENCY', $currencyCode);
    $result['debug'][] = '6';
    // Создаём корзину с одним товаром
    $basket = Basket::create($siteId);
    $basket->setFUserId( Bitrix\Sale\Fuser::getIdByUserId($USER_ID) );
    $item = $basket->createItem('catalog', intval($_REQUEST['PRODUCT_ID']));
//    if($_REQUEST['form_action'] !== 'buy_project') {
    $priceBasket = $_REQUEST['days'] == '21' ? 52500 :  0;
//    } else {
//        $priceBasket = 59000;
//    }
    if($priceBasket > 0) {
        $item->setFields(array(
            'QUANTITY' => 1,
            'CURRENCY' => $currencyCode,
            'LID' => $siteId,
            'PRICE' => $priceBasket,
            'BASE_PRICE' => $priceBasket,
            'CUSTOM_PRICE' => 'Y',
            'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
        ));
    } else {
        $item->setFields(array(
            'QUANTITY' => 1,
            'CURRENCY' => $currencyCode,
            'LID' => $siteId,
            'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
        ));
    }
    $basketPropertyCollection = @$item->getPropertyCollection();
    @$basketPropertyCollection->setProperty(array(
        array(
            'NAME' => 'Номер участка',
            'CODE' => 'PLOT_NUMBER',
            'VALUE' => $_REQUEST['plot_number'],
            'SORT' => 100,
        ),
    ));

    @$basketPropertyCollection->save();
    @$basket->refresh();
    @$basket->save();
    @$order->setBasket($basket);

    // Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
    $service = Delivery\Services\Manager::getById(2);
    $shipment->setFields(array(
        'DELIVERY_ID' => $service['ID'],
        'DELIVERY_NAME' => $service['NAME'],
    ));
    $shipmentItemCollection = $shipment->getShipmentItemCollection();
    $shipmentItem = $shipmentItemCollection->createItem($item);
    $shipmentItem->setQuantity($item->getQuantity());

    // Создаём оплату со способом #2
    //global $USER;
    //if ($USER->IsAdmin()) {
//    if($_REQUEST['form_action'] !== 'buy_project') {
    $price = $_REQUEST['days'] == '21' ? 52500 :  $order->getPrice();
//    }
    $paymentCollection = $order->getPaymentCollection();
    $payment = $paymentCollection->createItem();
    $paySystemService = PaySystem\Manager::getObjectById(3);
    $payment->setFields(array(
        'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
        'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
        'SUM'=> $price
    ));


    // Устанавливаем свойства
    $propertyCollection = $order->getPropertyCollection();
    $prop = $propertyCollection->getItemByOrderPropertyId(1);
    $prop->setField('VALUE', $_REQUEST['name']);
    $prop = $propertyCollection->getItemByOrderPropertyId(2);
    $prop->setValue($_REQUEST['email']);
    $prop = $propertyCollection->getItemByOrderPropertyId(3);
    $prop->setValue($_REQUEST['phone']);
    $prop = $propertyCollection->getItemByOrderPropertyId(4);
    $prop->setValue($_REQUEST['plot_number']);
    $prop = $propertyCollection->getItemByOrderPropertyId(5);
    $prop->setValue( $_SERVER['HTTP_HOST'] );

    // Сохраняем
    $order->doFinalAction(true);
    $resultOrder = $order->save();
    $orderId = $order->getId();

    $arDebug = $result['debug'];
    if ($siteId == "s2") {
        $result = array('errors' => '', 'success' => true, 'msg' => 'Данные успешно отправлены', 'debug' => $arDebug);
    } else {
        $result = array('errors' => '', 'success' => true, 'load_from' => '/local/include/ajax-bron-pay.php?ORDER_ID=' . $orderId, 'debug' => $arDebug);
    }
    if($item) {
        $productId = $item->getProductId();

        $arProduct = \CIBlockElement::GetByID($productId)->GetNext();
        $link = \CIBlock::ReplaceDetailUrl($arProduct["DETAIL_PAGE_URL"], $arProduct, false, "E");
        $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $fullLink = $host . $link;

    }
    /**************** Отправляем в roistat *************/
    $roistatData = [
        'roistat' => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : 'nocookie',
        'key' => 'MjdhMTYyYzI5NDU5NWZlNjg4MmJlZTU0NjI0YjdmMDQ6MjY3NDg1', // Ключ для интеграции с CRM, указывается в настройках интеграции с CRM.
        'is_need_callback' => '0',
        'sync' => '0',
        'is_need_check_order_in_processing' => '1',
        'is_need_check_order_in_processing_append' => '1',
        'is_skip_sending' => '1',
        'fields' => [],
        "title" => $_REQUEST['form_name'],
        "name" => $_REQUEST['name'],
        "email" => $_REQUEST['email'],
        "phone" => $_REQUEST['phone'],
        'comment' => $_REQUEST['plot_number'] ? 'Номер участка ' . $_REQUEST['plot_number'] : $fullLink,
    ];
//    AddMessage2Log("roistatData b24result " . print_r($roistatData, true), "debug");
    $ch = curl_init('https://cloud.roistat.com/api/proxy/1.0/leads/add?' . http_build_query($roistatData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $roiResult = curl_exec($ch);
    curl_close($ch);


    /**************** Отправляем в битрикс 24 *************/
    $b4queryData = http_build_query(array(
        'fields' => array(
            'TITLE' => $_REQUEST['form_name'] . ' (не оплачено)',
            'NAME' => $_REQUEST['name'],
            'PHONE' => [['VALUE' => $_REQUEST['phone']]],
            'UF_CRM_1744375476' =>  $_REQUEST['plot_number'] ? 'Номер участка ' . $_REQUEST['plot_number'] : $fullLink,

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
//    AddMessage2Log("b4queryData b24result " . print_r($b24result, true), "debug");

    curl_close($curl);
    $b24Id = $b24result['result'];
    if ($b24Id) {
        $order->setField('XML_ID', 'b24-'.$b24Id);
        $order->save();
    }


}

echo json_encode($result);