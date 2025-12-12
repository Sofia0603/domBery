<?
namespace DigitalPlans;
use \Bitrix\Main\Diag\Debug;
class B24 {
    private const CATALOG_IBLOCK = 1;

    private static $siteData = Array(
        'price14' => 35000,
        'price21' => 52500,
    );
    private static $b24Data = Array(
        'url' => 'https://zembery.bitrix24.ru',
        'token' => 'mdqu0fvl2glsoldfq82x6x54ptltwtpn',
        'rest' => Array(
            'products' => '673/5k95r8qvjr5vat06',
            'deal' => '673/awyldh29xxd17vp6',
            'dealUpdate' => '673/49gzkzssn3i80zlo',
            'dealSearch' => '673/zbc8e2riotvnjagi',
            'crm' => '673/jbuzd1nqdo6p09pw',
            'crmAdd' => '673/vh3v7dqorwgwe31c',
            'lead' => '6481/7rpchqhgm9wtw5ws',
            'leadUpdate' => '6481/zwsaimqh2gmmnr16',
        ),
        'status' => Array(
            'reserve' => 'UC_801MLS',
            'reserve_paid' => 'UC_BCZ71G'
        ),
        'categories' => Array(
            'lead' => 9,
            'default' => 0
        ),
        'sectionHouse' => 33,
        'propsPlot' => Array(
            'num' => 'PROPERTY_171',
            'status' => 'PROPERTY_115',
            'volume' => 'PROPERTY_117',
            'price_of' => 'PROPERTY_133',
            'price_of_sale' => 'PROPERTY_137',
            'fullprice' => 'PROPERTY_131',
            'num_kadastr' => 'PROPERTY_119',
            'village_name' => 'PROPERTY_205',
        ),
        'statusPlot' => Array(
            95 => 'продан',
            97 => 'свободен',
            99 => 'бронь',
            101 => 'резерв',
            103 => 'благоустройство'
        ),
    );

    private static function url($rest, $method){
        if (!isset(self::$b24Data['rest'][$rest])) return false;
        return self::$b24Data['url'].'/rest/'.self::$b24Data['rest'][$rest].'/'.$method;
    }

    private static function curl($url, $params){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);

        $out = curl_exec($curl);
        $response = $out ? $out : curl_error($curl);
        curl_close($curl);
        $result = json_decode($response, true);
        if ($result) return $result;
        else return $response;

    }

    public static function getPlots($filter = [], $offset = 0){
        if (!$filter || !is_array($filter)) $filter = [];
        $filter['!SECTION_ID'] = self::$b24Data['sectionHouse'];
        $url = self::url('products', 'crm.product.list.json');
        $getAll = false;
        /*if ($offset == 'all'){
            $getAll = true;
            $offset = 0;
        }*/
        $params = Array(
            'filter' => $filter,
            'select' => Array('ID', 'NAME', 'PRICE', 'PROPERTY_*'),
            'order' => ['ID' => 'ASC'],
            'start' => $offset
        );
        $result = self::curl($url, $params);
        $items = $result['result'];
        /*if ($getAll){
            while ($result['next']) {
                $result = self::getPlots($filter, $result['next']);
                if ($result['result']) $items = array_merge($items, $result['result']);
            }
        }*/
        if (!$items) return false;
        return Array(
            'items' => $items,
            'next' => $result['next'] ?: ''
        );
    }

    private static function getPlotByID($id){
        $url = self::url('products', 'crm.product.get.json');
        $params = Array(
            'id' => $id
        );
        $result = self::curl($url, $params);
        if (!isset($result['result'])) return false;
        else return $result['result'];
    }

    private static function beautifyPlotData($plot){
        $statusID = $plot[self::$b24Data['propsPlot']['status']]['value'];
        if (!isset(self::$b24Data['statusPlot'][$statusID])) $status = '';
        else $status = self::$b24Data['statusPlot'][$statusID];

        if (isset($plot[self::$b24Data['propsPlot']['price_of_sale']]['value'])) $priceOf = $plot[self::$b24Data['propsPlot']['price_of_sale']]['value'];
        else $priceOf = $plot[self::$b24Data['propsPlot']['price_of']]['value'] ?: '';
        if ($priceOf) $priceOf = str_replace('|RUB', '', $priceOf);

        $fullPrice = $plot[self::$b24Data['propsPlot']['fullprice']]['value'] ?: '';
        if ($fullPrice) $fullPrice = str_replace('|RUB', '', $fullPrice);

        $kadastr = $plot[self::$b24Data['propsPlot']['num_kadastr']]['value'] ?: '';
        if ($kadastr) $kadastr = explode(';', $kadastr)[1] ?: $kadastr;

        $plotResult = Array(
            'num' => $plot[self::$b24Data['propsPlot']['num']]['value'] ?: '',
            'status' => $status,
            'volume' => $plot[self::$b24Data['propsPlot']['volume']]['value'] ?: '',
            'price_of' => $priceOf,
            'fullprice' => $fullPrice,
            'num_kadastr' => $kadastr,
        );
        return $plotResult;
    }

    private static function getVillage($plot){
        if (!isset($_SESSION['villagesByName'])) $_SESSION['villagesByName'] = [];
        $name = $plot[self::$b24Data['propsPlot']['village_name']]['value'];
        if (!$name) return false;
        if (isset($_SESSION['villagesByName'][$name])) return $_SESSION['villagesByName'][$name];
        \Bitrix\Main\Loader::includeModule('iblock');
        $arItemsDB = \CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            array(
                'IBLOCK_ID' => self::CATALOG_IBLOCK,
                'ACTIVE' => 'Y',
                'NAME' => $name
            ),
            false,
            false,
            Array('ID', 'PROPERTY_GDATA')
        );
        $arItem = $arItemsDB->Fetch();
        if (!$arItem) return false;
        $_SESSION['villagesByName'][$arItem['ID']] = $arItem;
        return $arItem;
    }

    private static function updateVillagePlot($plot){
        global $updatedCounter;
        $arItem = self::getVillage($plot);
        $plotsJson = json_decode($arItem['PROPERTY_GDATA_VALUE']['TEXT'], true);
        $plotsByNum = [];
        foreach ($plotsJson as $plotArr) $plotsByNum[$plotArr['num']] = $plotArr;
        unset($plotsJson);
        $plotResult = self::beautifyPlotData($plot);
        $plotsByNum[$plotResult['num']] = $plotResult;
        $plotsNew = array_values($plotsByNum);
        unset($plotsByNum);
        \CIBlockElement::SetPropertyValuesEx($arItem['ID'], self::CATALOG_IBLOCK, Array('GDATA' => json_encode($plotsNew)));
        $updatedCounter++;
    }

    public static function updatePlots(){
        global $updatedCounter;
        if (!$updatedCounter) $updatedCounter = 0;
        $skipCounter = 0;
        do {
            if (!isset($plots['next'])) $plots['next'] = 0;
            $plots = self::getPlots([], $plots['next']);
            foreach ($plots['items'] as $plot) {
                if (!isset($plot[self::$b24Data['propsPlot']['num']]['value'])) {
                    $skipCounter++;
                    continue;
                }
                self::updateVillagePlot($plot);
            }
            Debug::writeToFile($plots['next']);
            Debug::writeToFile($updatedCounter, 'updated');
            Debug::writeToFile($skipCounter, 'skipCounter');
        } while ($plots['next']);
    }

    private static function searchClient($phone){
        $phone = General::phoneFormat($phone);
        $url = self::url('crm', 'crm.contact.list.json');
        $params = Array(
            'filter' => Array('PHONE' => $phone),
            'select' => Array('ID')
        );
        $result = self::curl($url, $params);
        if (!isset($result['result'][0]['ID'])) return false;
        else return $result['result'];
    }

    private static function createClient($phone, $email, $fio){
        $url = self::url('crmAdd', 'crm.contact.add.json');
        $fioArr = explode(' ', $fio);
        $lastName = '';
        $secondName = '';
        if (count($fioArr) != 3) $name = $fio;
        else {
            $lastName = $fioArr[0];
            $name = $fioArr[1];
            $secondName = $fioArr[2];
        }
        $params = Array(
            'fields' => [
                'PHONE' => [
                    [
                        'VALUE' => General::phoneFormat($phone),
                        'VALUE_TYPE' => 'WORK',
                    ],
                ],
                'LAST_NAME' => $lastName,
                'NAME' => $name,
                'SECOND_NAME' => $secondName,
                'EMAIL' => [
                    [
                        'VALUE_TYPE' => 'WORK',
                        'VALUE' => $email,
                    ],
                ],
                'TYPE_ID' => 'CLIENT',
                'SOURCE_ID' => '20',
            ],
        );
        $result = self::curl($url, $params);
        if (!isset($result['result'])) return false;
        else return $result['result'];
    }

    public static function getDealClient($phone, $email, $fio){
        $clientIDs = [];
        $clients = self::searchClient($phone);
        if (!$clients) {
            $client = self::createClient($phone, $email, $fio);
            $clientIDs[] = $client;
        } else{
            foreach ($clients as $client) $clientIDs[] = $client['ID'];
        }
        if (!$clientIDs) return false;
        return $clientIDs;
    }

    private static function getOrderProps($order){
        global $dealProp;
        $propsByCode = [];
        $propertyCollection = $order->getPropertyCollection();
        foreach($propertyCollection as $propertyValue) {
            $code = $propertyValue->getField('CODE');
            $propsByCode[$code] = $propertyValue->getValue();
            if ($code == 'DEAL') $dealProp = $propertyValue;
        }
        return $propsByCode;
    }

    private static function updateDealStatus($dealID, $status, $price){
        $statusID = self::$b24Data['status'][$status];
        if (!$statusID) return false;
        $url = self::url('dealUpdate', 'crm.deal.update.json');
        if ($price == self::$siteData['price14']) $dateEnd = date('Y-m-d', strtotime('+14 days'));
        elseif($price == self::$siteData['price21']) $dateEnd = date('Y-m-d', strtotime('+21 days'));
        else $dateEnd = '';
        $params = Array(
            'id' => $dealID,
            'fields' => Array(
                'STAGE_ID' => $statusID,
                'CATEGORY_ID' => self::$b24Data['categories']['default'],
                'UF_CRM_1745485483324' => $price,
                'UF_CRM_1743145924961' => date('Y-m-d'),
                'UF_CRM_1743145949402' => $dateEnd
            )
        );
        self::curl($url, $params);
    }

    public static function markDealPaid($order){
        Debug::writeToFile('Paid 2');
        self::setDeal($order);
        $propsByCode = self::getOrderProps($order);
        $dealID = $propsByCode['DEAL'];
        Debug::writeToFile($dealID, '$dealID');
        $price = $order->getPrice();
        if ($dealID) {
            self::setDealBasket($order, $dealID, $propsByCode);
            self::updateDealStatus($dealID, 'reserve_paid', $price);
        }
    }

    public static function searchDeal($contactID){
        if (!$contactID) return false;
        $url = self::url('dealSearch', 'crm.deal.list.json');
        $params = Array(
            'filter' => Array(
                'CONTACT_ID' => $contactID,
                'STAGE_SEMANTIC_ID' => 'p',
            ),
            //'select' => Array('ID')
        );
        $result = self::curl($url, $params);
        if (!isset($result['result'][0]['ID'])) return false;
        return $result['result'][0]['ID'];
    }

    public static function createDeal($contactID, $price){
        $url = self::url('deal', 'crm.deal.add.json');
        if ($price == self::$siteData['price14']) $dateEnd = date('Y-m-d', strtotime('+14 days'));
        elseif($price == self::$siteData['price21']) $dateEnd = date('Y-m-d', strtotime('+21 days'));
        else $dateEnd = '';

        $params = Array(
            'fields' => Array(
                'CONTACT_ID' => $contactID,
                'CATEGORY_ID' => self::$b24Data['categories']['default'],
                'SOURCE_ID' => 20,
                'ASSIGNED_BY_ID' => 615//233
                //'UF_CRM_1745485483324' => $price,
                //'UF_CRM_1743145924961' => date('Y-m-d'),
                //'UF_CRM_1743145949402' => $dateEnd
                //'UF_CRM_1705578315' => $villages,
            )
        );
        $result = self::curl($url, $params);
        if (isset($result['result'])) return $result['result'];
    }

    public static function addPlotToDeal($village, $plot, $dealID, $price){
        if (!$village || !$plot) return false;
        $filter = Array(
            self::$b24Data['propsPlot']['num'] => $plot,
            self::$b24Data['propsPlot']['village_name'] => $village,
        );
        $b24Plots = self::getPlots($filter);
        if (!$b24Plots) return false;
        $b24Plots = $b24Plots['items'];
        if (!isset($b24Plots[0]['ID'])) return false;
        $product = $b24Plots[0]['ID'];

        $url = self::url('deal', 'crm.item.productrow.add.json');
        $params = Array(
            'fields' => Array(
                'ownerId' => $dealID,
                'ownerType' => 'D',
                'productId' => $product,
                'price' => $price,
            )
        );
        self::curl($url, $params);
    }

    private static function setDealBasket($order, $dealID, $propsByCode){
        $price = $order->getPrice();
        $basket = $order->getBasket();
        $basketItems = $basket->getBasketItems();
        foreach ($basketItems as $item) $village = $item->getField('NAME');
        $plot = $propsByCode['PLOT_NUMBER'];
        self::addPlotToDeal($village, $plot, $dealID, $price);
    }

    private static function getLead($contactID){
        $url = self::url('lead', 'crm.lead.list.json');
        $params = Array(
            'fields' => Array(
                'CONTACT_ID' => $contactID
            ),
            'select' => ['ID']
        );
        $lead = self::curl($url, $params);
        if (!isset($lead['result'][0]['ID'])) return false;
        else return $lead['result'][0]['ID'];
    }

    private static function leadToDeal($leadID){
        $url = self::url('leadUpdate', 'crm.lead.update.json');
        $params = Array(
            'id' => $leadID,
            'fields' => Array(
                'STATUS_ID' => 'CONVERTED'
            ),
        );
        $success = self::curl($url, $params);
        if ($success['result']) return true;
        else return false;
    }
    public static function setDeal($order, $save = false){
        global $dealProp;
        $propsByCode = self::getOrderProps($order);
        $contactIDs = self::getDealClient($propsByCode['PHONE'], $propsByCode['EMAIL'], $propsByCode['FIO']);
        if (!$contactIDs) return false;
        foreach ($contactIDs as $contactID) {
            $dealID = self::searchDeal($contactID);
            if (!$dealID){
                $leadID = self::getLead($contactID);
                if ($leadID && self::leadToDeal($leadID)) $dealID = self::searchDeal($contactID);
            }
            $price = $order->getPrice();
            //self::setDealBasket($order, $dealID, $propsByCode);

        }
        if (!$dealID) $dealID = self::createDeal($contactID, $price);
        $dealProp->setValue((int)$dealID);
        if ($save) $order->save();
    }

    private function getDeal(){

    }

    public static function eventHandler(){
        file_put_contents(dirname(__DIR__) . '/b24/log.log', 'hook start' . PHP_EOL, FILE_APPEND);
        $data = file_get_contents('php://input');
        $log = Array(
            'post' => $_POST,
            'data' => $data
        );
        $log = date('Y-m-d H:i:s') . ' ' . print_r($log, true);
        file_put_contents(dirname(__DIR__) . '/b24/log.log', $log . PHP_EOL, FILE_APPEND);
        $dataJson = json_decode($data, true);
        if (!$_POST && $dataJson) $_POST = $dataJson;
        if (!$_POST['event']/* || $_POST['auth']['application_token'] != self::$b24Data['token']*/) return false;
        $eventFunc = 'event_'.$_POST['event'];
        if (!method_exists(self::class, $eventFunc)) return false;
        self::$eventFunc();
    }

    private static function event_ONCRMPRODUCTUPDATE(){
        $id = $_POST['product_id'] ?: $_POST['data']['FIELDS']['ID'];
        if (!$id) return false;
        Debug::writeToFile($_POST, 'event data');
        $plot = self::getPlotByID($id);
        Debug::writeToFile($plot, 'plot data');
        self::updateVillagePlot($plot);
    }
    public static function createLead($name, $phone, $email = '') {
        $params = [
            'fields' => [
                'TITLE' => 'Новая смета от '.$name,
                'NAME' => $name,
                'PHONE' => [
                    ['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']
                ],
                'EMAIL' => $email ? [['VALUE' => $email, 'VALUE_TYPE' => 'WORK']] : [],
                'SOURCE_ID' => 'WEB',
            ]
        ];

        $url = self::url('lead', 'crm.lead.add.json');
        $result = self::curl($url, $params);

        if (isset($result['result'])) {
            return $result['result']; // возвращает ID созданного лида
        }

        return false;
    }


}
?>