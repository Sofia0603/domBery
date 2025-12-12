<?
use DigitalPlans\General;
use DigitalPlans\B24;
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

AddEventHandler("main", "OnBuildGlobalMenu", "ModifiAdminMenu");
function ModifiAdminMenu(&$adminMenu, &$moduleMenu){
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_store",
        "section" => "Рассылка подписантам",
        "sort"        => 100,
        "url"         => "/bitrix/admin/subscribe_sender.php?lang=".LANG,  // ссылка на пункте меню - тут как раз и пишите адрес вашего файла, созданного в /bitrix/admin/
        "text"        => 'Рассылка подписантам',
        "title"       => 'Рассылка подписантам',
        "icon"        => "form_menu_icon", // малая иконка
        "page_icon"   => "form_page_icon", // большая иконка
        "items_id"    => "menu_ваше название",  // идентификатор ветви
        "items"       => array()          // остальные уровни меню
    );
}

//-- Добавление обработчика события

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");

//-- Собственно обработчик события

function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
	$arOrder = CSaleOrder::GetByID($orderID);

	// 🔒 Список email-ов, которым нельзя отправлять письма
	$blockedEmails = array(
		'Alisheykhova94@mail.ru',
		'dfsdfw324244@yopmail.com'
	);

	// Если email совпадает — отменяем отправку
	if (in_array($arFields["EMAIL"], $blockedEmails)) {
		$eventName = ""; // блокируем отправку письма
		return;
	}

	//-- получаем телефоны и адрес
	$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
	$phone="";
	$index = "";
	$country_name = "";
	$city_name = "";
	$address = "";
	while ($arProps = $order_props->Fetch())
	{
		if ($arProps["CODE"] == "PHONE")
		{
			$phone = htmlspecialchars($arProps["VALUE"]);
		}
		if ($arProps["CODE"] == "LOCATION")
		{
			$arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
			$country_name =  $arLocs["COUNTRY_NAME_ORIG"];
			$city_name = $arLocs["CITY_NAME_ORIG"];
		}

		if ($arProps["CODE"] == "INDEX")
		{
			$index = $arProps["VALUE"];
		}

		if ($arProps["CODE"] == "ADDRESS")
		{
			$address = $arProps["VALUE"];
		}
	}

	$full_address = $index.", ".$country_name."-".$city_name.", ".$address;

	//-- получаем название службы доставки
	$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
	$delivery_name = "";
	if ($arDeliv)
	{
		$delivery_name = $arDeliv["NAME"];
	}

	//-- получаем название платежной системы
	$arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
	$pay_system_name = "";
	if ($arPaySystem)
	{
		$pay_system_name = $arPaySystem["NAME"];
	}

	//-- добавляем новые поля в массив результатов
	$arFields["ORDER_DESCRIPTION"] = $arOrder["USER_DESCRIPTION"];
	$arFields["PHONE"] =  $phone;
	$arFields["DELIVERY_NAME"] =  $delivery_name;
	$arFields["PAY_SYSTEM_NAME"] =  $pay_system_name;
	$arFields["FULL_ADDRESS"] = $full_address;
	$arFields["LINK_PROJECT"] = 'Ссылка на проект';
}

function getShowers() {
    $result = \Bitrix\Main\UserGroupTable::getList(array(
        'filter' => array('GROUP_ID'=>8,'USER.ACTIVE'=>'Y'),
        'select' => array('USER_ID','NAME'=>'USER.NAME','LAST_NAME'=>'USER.LAST_NAME'), // выбираем идентификатор п-ля, имя и фамилию
        'order' => array('USER.LAST_NAME'=>'ASC'), // сортируем по идентификатору пользователя
    ));

    $arShowers = array();
    while ($arRes = $result->fetch()) {
        $arShowers[ $arRes['USER_ID'] ] = $arRes;
    }

    return $arShowers;
}

function getBrokers() {
    $result = \Bitrix\Main\UserGroupTable::getList(array(
        'filter' => array('GROUP_ID'=>7,'USER.ACTIVE'=>'Y'),
        'select' => array('USER_ID','NAME'=>'USER.NAME','LAST_NAME'=>'USER.LAST_NAME'), // выбираем идентификатор п-ля, имя и фамилию
        'order' => array('USER.LAST_NAME'=>'ASC'), // сортируем по идентификатору пользователя
    ));

    $arBrokers = array();
    while ($arRes = $result->fetch()) {
        $arBrokers[ $arRes['USER_ID'] ] = $arRes;
    }

    return $arBrokers;
}

function getGeodesist() {
    $result = \Bitrix\Main\UserGroupTable::getList(array(
        'filter' => array('GROUP_ID'=>41,'USER.ACTIVE'=>'Y'),
        'select' => array('USER_ID','NAME'=>'USER.NAME','LAST_NAME'=>'USER.LAST_NAME'), // выбираем идентификатор п-ля, имя и фамилию
        'order' => array('USER.LAST_NAME'=>'ASC'), // сортируем по идентификатору пользователя
    ));

    $arBrokers = array();
    while ($arRes = $result->fetch()) {
        $arBrokers[ $arRes['USER_ID'] ] = $arRes;
    }

    return $arBrokers;
}

function isGroupInFields($arGroup_ID, $needle) {
    foreach ($arGroup_ID as $arGroupItem) if ($arGroupItem['GROUP_ID'] == $needle) return true;
    return  false;
}


AddEventHandler("main", "OnBeforeUserAdd", array("ZemberyClass", "OnBeforeUserAddHandler") );
AddEventHandler("main", "OnBeforeUserUpdate", array("ZemberyClass", "OnBeforeUserUpdateHandler") );
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("ZemberyClass", "OnBeforeIBlockElementAddHandler"));
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("ZemberyClass", "OnBeforeIBlockElementUpdateHandler"));
AddEventHandler("iblock", "OnStartIBlockElementUpdate", Array("ZemberyClass", "OnStartIBlockElementUpdateHandler"));
AddEventHandler("iblock", "OnIBlockElementSetPropertyValuesEx", Array("ZemberyClass", "OnIBlockElementSetPropertyValuesExHandler"));
AddEventHandler("sale", "OnSaleOrderPaid", Array("ZemberyClass", "OnSalePaymentEntitySavedHandler"));

/*\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderBeforeSaved',
    Array("ZemberyClass", "OnSaleOrderBeforeSaved")
);*/

class ZemberyClass
{
    // при создании нового юзера проводим проверки и доводки
    public static function OnBeforeUserAddHandler(&$arFields)
    {
        AddMessage2Log("OnBeforeUserAddHandler " . print_r($arFields, true), "debug");

    }

    // при изменении данных юзера проводим проверки и доводки
    public static function OnBeforeUserUpdateHandler(&$arFields)
    {
        global $APPLICATION;
        $isBroker = isGroupInFields($arFields['GROUP_ID'], 7);
        $isShower = isGroupInFields($arFields['GROUP_ID'], 8);
        $isGeodesist = isGroupInFields($arFields['GROUP_ID'], 41);
        $isNewest = isGroupInFields($arFields['GROUP_ID'], 9);
        $isArchive = isGroupInFields($arFields['GROUP_ID'], 10);

        if ($isNewest && ($isBroker || $isShower)) {
            $APPLICATION->throwException("Пользователь не может быть Новичком и Брокером/Показчиком одновременно");
            return false;
        }
        if ($isArchive && ($isBroker || $isShower)) {
            $APPLICATION->throwException("Пользователь не может быть в Архиве и Брокером/Показчиком одновременно");
            return false;
        }
        if ($isArchive && $isNewest) {
            $APPLICATION->throwException("Пользователь не может быть Новичком и в Архиве одновременно");
            return false;
        }

        // нормализация номера телефона
        if (!empty($arFields['PERSONAL_PHONE'])) {
            $parsedPhone = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse($arFields['PERSONAL_PHONE'], 'RU');
            if ($parsedPhone->isValid()) {
                $arFields['PERSONAL_PHONE'] = $parsedPhone->format(\Bitrix\Main\PhoneNumber\Format::INTERNATIONAL);
            } else {
                $APPLICATION->throwException("Проверьте указанный номер телефонаю");
                return false;
            }
        }
    }

    public static function OnBeforeIBlockElementAddHandler(&$arFields) {
        global $APPLICATION;

        if ($arFields['IBLOCK_ID'] == 12) { // новая СДЕЛКА

            if (empty($arFields['PROPERTY_VALUES']['FILES'])) {
                $APPLICATION->throwException("Необходимо добавить сканы документов");
                return false;
            }

        }
    }

    public static function OnBeforeIBlockElementUpdateHandler(&$arFields) {
        global $APPLICATION;

        if ($arFields['IBLOCK_ID'] == 12 && count($arFields['PROPERTY_VALUES']) > 1) { // изменения в СДЕЛКЕ
            $arOldFields = CIBlockElement::GetList([], ["IBLOCK_ID" => $arFields["IBLOCK_ID"], "ID" => $arFields["ID"]], false, false, array("*", "PROPERTY_*") )->Fetch();

            $isNewStatusCancel = ($arFields['PROPERTY_VALUES'][64][0]['VALUE'] == 51);
            $isOldStatusCancel = ($arOldFields['PROPERTY_64'] == 51);
            $township = reset($arFields['PROPERTY_VALUES'][62]); $township = $township['VALUE'];
            $allotment = reset($arFields['PROPERTY_VALUES'][63]); $allotment = $allotment['VALUE'];

            if ($arFields['PROPERTY_VALUES']) {
                if ($isNewStatusCancel && !$isOldStatusCancel) {
                    // СТАТУС -> ОТМЕНЕНА
                    $arFields['CODE'] = $arFields['CODE'] . '_' . time();
                }

                if ($arFields['PROPERTY_VALUES'][64][0]['VALUE'] !== $arOldFields['PROPERTY_64']) {
                    // изменен статус сделки
                    $arInfo = [
                        'NAME_BUYER' => $arOldFields['PROPERTY_67'],
                        'PHONE_BUYER' => $arOldFields['PROPERTY_68'],
                        'EMAIL_BUYER' => $arOldFields['PROPERTY_69'],
                    ];

                    //AddMessage2Log("arFields " . print_r($arFields, true) . "\narOldFields " . print_r($arOldFields, true), "debug");
                    // дергаем почтовое событие с айдишником новой сделки в имени
                    CEvent::Send("CHANGE_STATUS_".$arFields['PROPERTY_VALUES'][64][0]['VALUE'], 's1', $arInfo, 'Y', "" );
                }
            }

            //$APPLICATION->throwException( '<pre>'.print_r($arFields, true)."<br>".print_r($arOldFields, true).'</pre>');
            //return false;
        }

        if ($arFields['IBLOCK_ID'] == 13) { // изменения в Заявках на вынос границ
            $arOldFields = CIBlockElement::GetList([], ["IBLOCK_ID" => $arFields["IBLOCK_ID"], "ID" => $arFields["ID"]], false, false, array("*", "PROPERTY_*") )->Fetch();

            if ($arFields['PROPERTY_VALUES']) {
                if ($arFields['PROPERTY_VALUES'][93][0]['VALUE'] !== $arOldFields['PROPERTY_93']) {
                    // изменен статус заявки на вынос границ

                    $arOrderFields = CIBlockElement::GetList([], ["IBLOCK_ID" => 12, "ID" => $arOldFields['PROPERTY_80']], false, false, array("*", "PROPERTY_*") )->Fetch();
                    $arTownship = CIBlockElement::GetByID( $arOrderFields['PROPERTY_62'] )->GetNext();
                    $arBroker = CUser::GetByID( $arOrderFields['PROPERTY_65'] )->Fetch();

                    $arInfo = [
                        'NAME_BUYER' => $arOrderFields['PROPERTY_67'],
                        'PHONE_BUYER' => $arOrderFields['PROPERTY_68'],
                        'EMAIL_BUYER' => $arOrderFields['PROPERTY_69'],
                        'EMAIL_BROKER' => $arBroker['EMAIL'],
                        'TOWNSHIP_NAME' => $arTownship['NAME'],
                        'ALLOTMENT' => intval($arOrderFields['PROPERTY_63']),
                    ];

                    //AddMessage2Log("arFields " . print_r($arFields, true), "debug13");
                    //AddMessage2Log("arOldFields " . print_r($arOldFields, true), "debug13");
                    AddMessage2Log("arInfo " . print_r($arInfo, true), "debug13");
                    // дергаем почтовое событие с айдишником новой заявки в имени
                    CEvent::Send("CHANGE_STATUS_".$arFields['PROPERTY_VALUES'][93][0]['VALUE'], 's1', $arInfo, 'Y', "" );
                }
            }

            //$APPLICATION->throwException( '<pre>'.print_r($arFields, true)."<br>".print_r($arOldFields, true).'</pre>');
            //return false;
        }
    }

    public static function OnIBlockElementSetPropertyValuesExHandler($ELEMENT_ID, $IBLOCK_ID, $arPROPERTY_VALUES, $arPropertyList, $arDBProps ) {
        /* AddMessage2Log(
            "ELEMENT_ID " . print_r($ELEMENT_ID, true) .
            "\nIBLOCK_ID " . print_r($IBLOCK_ID, true) .
            "\narPROPERTY_VALUES " . print_r($arPROPERTY_VALUES, true) .
            "\narPropertyList " . print_r($arPropertyList, true) .
            "\narDBProps " . print_r($arDBProps, true),
            "OnIBlockElementSetPropertyValuesExHandler"); */

        if ($IBLOCK_ID == 12) { // изменения в СДЕЛКЕ
            //$arOldFields = CIBlockElement::GetList([], ["IBLOCK_ID" => $arFields["IBLOCK_ID"], "ID" => $arFields["ID"]], false, false, array("*", "PROPERTY_*") )->Fetch();

            if ($arPROPERTY_VALUES['STATUS']) {
                //$isNewStatusCancel = ($arPROPERTY_VALUES['STATUS'] == 51);
                //$isOldStatusCancel = ($arDBProps['64'][ ''.$ELEMENT_ID.':64' ]['VALUE'] == 51);
                $arFields = CIBlockElement::GetList([], ["IBLOCK_ID" => $IBLOCK_ID, "ID" => $ELEMENT_ID], false, false, array("*", "PROPERTY_*") )->Fetch();

                $arInfo = [
                    'NAME_BUYER' => $arFields['PROPERTY_67'],
                    'PHONE_BUYER' => $arFields['PROPERTY_68'],
                    'EMAIL_BUYER' => $arFields['PROPERTY_69'],
                ];

                // дергаем почтовое событие с айдишником новой сделки в имени
                CEvent::Send("CHANGE_STATUS_".$arPROPERTY_VALUES['STATUS'], 's1', $arInfo, 'Y', "" );

                /*AddMessage2Log(
                    "CHANGE_STATUS_".$arPROPERTY_VALUES['STATUS'] .
                    "\narInfo " . print_r($arInfo, true),
                    "CEventSend");*/
            }

            //$APPLICATION->throwException( '<pre>'.print_r($arFields, true)."<br>".print_r($arOldFields, true).'</pre>');
            //return false;
        }

        if ($IBLOCK_ID == 13) { // изменения в Выносе границ

            if ($arPROPERTY_VALUES['STATUS']) {
                $arFields = CIBlockElement::GetList([], ["IBLOCK_ID" => $IBLOCK_ID, "ID" => $ELEMENT_ID], false, false, array("*", "PROPERTY_*") )->Fetch();

                $arOrderFields = CIBlockElement::GetList([], ["IBLOCK_ID" => 12, "ID" => $arFields['PROPERTY_80']], false, false, array("*", "PROPERTY_*") )->Fetch();
                $arTownship = CIBlockElement::GetByID( $arOrderFields['PROPERTY_62'] )->GetNext();
                $arBroker = CUser::GetByID( $arOrderFields['PROPERTY_65'] )->Fetch();

                $arInfo = [
                    'NAME_BUYER' => $arOrderFields['PROPERTY_67'],
                    'PHONE_BUYER' => $arOrderFields['PROPERTY_68'],
                    'EMAIL_BUYER' => $arOrderFields['PROPERTY_69'],
                    'EMAIL_BROKER' => $arBroker['EMAIL'],
                    'TOWNSHIP_NAME' => $arTownship['NAME'],
                    'ALLOTMENT' => intval($arOrderFields['PROPERTY_63']),
                ];

                // дергаем почтовое событие с айдишником новой сделки в имени
                CEvent::Send("CHANGE_STATUS_".$arPROPERTY_VALUES['STATUS'], 's1', $arInfo, 'Y', "" );

                /*AddMessage2Log(
                    "CHANGE_STATUS_".$arPROPERTY_VALUES['STATUS'] .
                    "\narInfo " . print_r($arInfo, true),
                    "CEventSend");*/
            }
        }

    }

    public static function OnStartIBlockElementUpdateHandler(&$arFields) {
        return;

        global $APPLICATION;

        AddMessage2Log(
            "arFields " . print_r($arFields, true),
            "OnStartIBlockElementUpdateHandler");

        if ($arFields['IBLOCK_ID'] == 12 && count($arFields['PROPERTY_VALUES']) > 1) { // изменения в СДЕЛКЕ
            $isStatusCancel = ($arFields['PROPERTY_VALUES'][64][0]['VALUE'] == 51);
            $township = reset($arFields['PROPERTY_VALUES'][62]);
            $township = $township['VALUE'];
            $allotment = reset($arFields['PROPERTY_VALUES'][63]);
            $allotment = $allotment['VALUE'];

            if ( !$isStatusCancel ) {
                // для неотмененных сделок приводим символьный код к виду поселок_участок для уникалльности сделки по участку
                // если сделка по этому участку уже есть, то изменение не пройдет проверку битрикса на уникальность символьного кода

                $arFields['CODE'] = $township . '_' . $allotment;
            } elseif ($isStatusCancel && $arFields['CODE'] == $township.'_'.$allotment) {
                // для отмененных сделок надо добавить в символьный код соли, если это еще не было сделано
                $arFields['CODE'] = $township . '_' . $allotment . '_' . rand(111111, 999999);
            }

            AddMessage2Log(
                "arFields " . print_r($arFields, true),
                "OnStartIBlockElementUpdateHandler");
        }
    }

    public static function teset_OnStartIBlockElementUpdateHandler(&$arFields) {
        global $APPLICATION;

        if ($arFields['IBLOCK_ID'] == 12) { // изменения в СДЕЛКЕ

            if ($arFields['PROPERTY_VALUES']) {
                $isStatusCancel = ($arFields['PROPERTY_VALUES'][64][0]['VALUE'] == 51);
                $township = reset($arFields['PROPERTY_VALUES'][62]);
                $township = $township['VALUE'];
                $allotment = reset($arFields['PROPERTY_VALUES'][63]);
                $allotment = $allotment['VALUE'];
            } else {
                $isStatusCancel = CIBlockElement::GetProperty(12, $arFields['ID'], array(), Array("ID"=>64))->Fetch()['VALUE'] == 51;
                $township = CIBlockElement::GetProperty(12, $arFields['ID'], array(), Array("ID"=>62))->Fetch()['VALUE'];
                $allotment = CIBlockElement::GetProperty(12, $arFields['ID'], array(), Array("ID"=>63))->Fetch()['VALUE'];
                AddMessage2Log(
                    "isStatusCancel " . print_r($isStatusCancel, true) .
                    "\ntownship " . print_r($township, true) .
                    "\nallotment " . print_r($allotment, true),
                    "OnStartIBlockElementUpdateHandler");
            }

            //
            if ( !$isStatusCancel ) {
                // для неотмененных сделок приводим символьный код к виду поселок_участок для уникалльности сделки по участку
                // если сделка по этому участку уже есть, то изменение не пройдет проверку битрикса на уникальность символьного кода
                $arFields['CODE'] = $township . '_' . $allotment;
            } elseif ($isStatusCancel && $arFields['CODE'] == $township.'_'.$allotment) {
                // для отмененных сделок надо добавить в символьный код соли, если это еще не было сделано
                $arFields['CODE'] = $township . '_' . $allotment . '_' . rand(111111, 999999);
            }

            AddMessage2Log(
                "arFields " . print_r($arFields, true) .
                "\ntmp " . print_r($tmp, true),
                "OnStartIBlockElementUpdateHandler");
        }
    }

    public static function OnSalePaymentEntitySavedHandler(Bitrix\Sale\Order $order) {

        $fields = $order->getFields();
        $originalValues = $fields->getOriginalValues();
        $changedValues = $fields->getChangedValues();

        AddMessage2Log("OnSalePaymentEntitySavedHandler getOriginalValues " . print_r($originalValues, true), "debug");
        AddMessage2Log("OnSalePaymentEntitySavedHandler changedValues " . print_r($changedValues, true), "debug");
        AddMessage2Log("OnSalePaymentEntitySavedHandler PAYED " . $order->getField('PAYED') , "debug");

        // Если это перевод заказа в статус ОПЛАЧЕНО
        if( $order->getField('PAYED')=='Y' && $changedValues['PAYED'] == 'Y' && $originalValues['PAYED'] == 'N' ) {
            $propertyCollection = $order->getPropertyCollection();
            require_once $_SERVER['DOCUMENT_ROOT'].'/local/classes/General.php';
            General::autoload();
            B24::markDealPaid($order);
            General::autoload(1);
            $emailProp = $propertyCollection->getUserEmail();
            $email = $emailProp ? $emailProp->getValue() : '';
            $linkProject = '';
            $basket = $order->getBasket();
            foreach ($basket as $basketItem) {
                $productId = $basketItem->getProductId();

                $res = CIBlockElement::GetList([], ["ID" => $productId], false, false, ["PROPERTY_LINK_PROJECT_PROP"]);
                if ($item = $res->Fetch()) {
                    $linkProject = $item["PROPERTY_LINK_PROJECT_PROP_VALUE"];
                    break;
                }
            }
            $arFields = [
                "EMAIL" =>  $email,
                "LINK_PROJECT" => $linkProject,
            ];
            if($linkProject) {
                CEvent::Send("LINK_TO_PROJECT", 's1', $arFields, 'Y');
            }
                $xml_id = $order->getField("XML_ID");


//            AddMessage2Log("OnSalePayOrderHandler " . ', ' . print_r($linkProject, true), "debug");

            if (strncmp($xml_id, 'b24-', 4) === 0) {
                $b24id = intval(substr_replace($xml_id, '', 0, 4));
                if ($b24id) {
                    // получаем лид
                    $b4queryData = http_build_query(array(
                        'id' => $b24id
                    ));
                    $b24queryUrl = 'https://zembery.bitrix24.ru/rest/219/qys098c4dqgskjij/crm.lead.get.json';
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
                    $b24lead = json_decode($b24result, 1);
                    curl_close($curl);

                    //AddMessage2Log("OnSalePayOrderHandler b24lead " . print_r($b24lead, true), "debug");

                    // изменяем лид заменив (не оплачено)' на '(оплачено)'
                    if (!empty($b24lead['result'])) {
                        $b4queryData = http_build_query(array(
                            'id' => $b24id,
                            'fields' => array(
                                'TITLE' => str_replace('(не оплачено)', '(оплачено)', $b24lead['result']['TITLE']),
                            ),
                            'params' => array("REGISTER_SONET_EVENT" => "Y")
                        ));
                        $b24queryUrl = 'https://zembery.bitrix24.ru/rest/219/qys098c4dqgskjij/crm.lead.update.json';
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
                        $b24result = json_decode($b24result, 1);
                        curl_close($curl);

//                        AddMessage2Log("OnSalePayOrderHandler b24result " . print_r($b24result, true), "debug");
                    }
                }
            }
        }
    }

    public static function OnSaleOrderBeforeSaved($event){
        $order = $event->getParameter("ENTITY");
        if($order->getId()) return;
        require_once $_SERVER['DOCUMENT_ROOT'].'/local/classes/General.php';
        General::autoload();
        B24::setDeal($order);
        General::autoload(1);
    }

}


//добавление дополнительного файла с сылками в карту сайта при генерации
\Bitrix\Main\EventManager::getInstance()->addEventHandler("bxmaker.autositemap", "onSitemapStep", "BXmakerAutoSitemapOnSitemapStep");

function BXmakerAutoSitemapOnSitemapStep(\Bitrix\Main\Event $event)
{
    $NS = $event->getParameter('NS');

    if (isset($NS['XML_FILES']) && is_array($NS['XML_FILES']) && !in_array('sitemap-custom.xml', $NS['XML_FILES'])) {
        $NS['XML_FILES'][] = 'sitemap-custom.xml';
    }

    //завершаем
    $arReturn = [
        'NS' => $NS,
    ];

    $result = new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, $arReturn);
    return $result;
}

function dump($v){

        echo '<pre>'; var_dump($v); echo '</pre>';

}


//CAgent::AddAgent("birthDayAgent();", "", "N", 60, "", "Y", "", 30); //86400

function birthDayAgent(){

    //$rsUsers = CUser::GetList($by="c_sort", $order="asc", Array('PERSONAL_BIRTHDAY_1' => date('d.m.Y'),'PERSONAL_BIRTHDAY_2' => date('d.m.Y'),'ACTIVE' => 'Y'));
    $rsUsers = CUser::GetList($by="c_sort", $order="asc", Array('PERSONAL_BIRTHDAY_DATE' => date("m-d"), 'ACTIVE' => 'Y'));
    //file_put_contents($_SERVER["DOCUMENT_ROOT"]."/log.txt",print_r(date('d.m.Y'),true));
    while($user = $rsUsers->Fetch()){
        //AddMessage2Log($user[]);

        $arInfo = array();
        $arInfo['FIO'] = $user['NAME'];
        $arInfo['EMAIL'] = $user['EMAIL'];
        $arInfo['PERSONAL_BIRTHDAY'] = $user['PERSONAL_BIRTHDAY'];
        CEvent::Send("BIRTHDAY", 's1', $arInfo, 'Y', "");

        AddMessage2Log(
            "user " . print_r($arInfo, true),
            "birthDayAgent");
    }
    
    return "birthDayAgent();";
}
