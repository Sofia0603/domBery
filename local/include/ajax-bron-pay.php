<?
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem,
    Bitrix\Sale\PaySystem\Manager;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

$order = Order::load($_REQUEST['ORDER_ID']);
$paymentCollection = $order->getPaymentCollection();
$onePayment = $paymentCollection[0];

$service = Bitrix\Sale\PaySystem\Manager::getObjectById($onePayment->getPaymentSystemId());
$context = \Bitrix\Main\Application::getInstance()->getContext();
$service->initiatePay($onePayment, $context->getRequest());

//$initResult = $service->initiatePay($onePayment, $context->getRequest(), \Bitrix\Sale\PaySystem\BaseServiceHandler::STRING);
//$buffered_output = $initResult->getTemplate();
//echo print_r($buffered_output);
