<?php
namespace DigitalPlans;
require( $_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/modules/main/include/prolog_before.php" );
class Yandex {
    private const IB_CATALOG = 1;
    private function getVillages(){
        \Bitrix\Main\Loader::includeModule('iblock');
        $arItemsDB = \CIBlockElement::GetList(
            array('SORT' => 'ASC'),
            array(
                'IBLOCK_ID' => self::IB_CATALOG,
                'ACTIVE' => 'Y',
            ),
            false,
            false,
            Array('ID', 'NAME', 'DETAIL_PAGE_URL', 'DATE_CREATE')
        );
        return $arItemsDB;
    }

    private function validatePlot($plot){
        if ($plot['status'] != 'свободен') return false;
        if (!is_numeric($plot['fullprice'])) return false;
        return true;
    }

    private function setProps(&$arItem){
        $res = \CIBlockElement::GetProperty(self::IB_CATALOG, $arItem['ID']);
        while ($ob = $res->GetNext()) {
            if ($ob['MULTIPLE'] == "Y"){
                if ($arItem['PROPERTIES'][$ob['CODE']]) $arItem['PROPERTIES'][$ob['CODE']]['VALUE'][] = $ob['VALUE'];
                else{
                    $arItem['PROPERTIES'][$ob['CODE']] = $ob;
                    $arItem['PROPERTIES'][$ob['CODE']]['VALUE'] = [];
                    $arItem['PROPERTIES'][$ob['CODE']]['VALUE'][] = $ob['VALUE'];
                }
            } else $arItem['PROPERTIES'][$ob['CODE']] = $ob;
        }
    }

    private function getAddress($village){
        if ($village['PROPERTIES']['SHOSSE']) $arOneLineProp[] = $village['PROPERTIES']['SHOSSE']['VALUE_ENUM'] . ' шоссе';
        if ($village['PROPERTIES']['REGION']) $arOneLineProp[] = $village['PROPERTIES']['REGION']['VALUE_ENUM'] . ' г. о.';
        if ($village['PROPERTIES']['REMOTENESS']) $arOneLineProp[] = $village['PROPERTIES']['REMOTENESS']['VALUE'] . " км от МКАД";
        if ($arOneLineProp) $address = implode(', ', $arOneLineProp);
        return $address;
    }

    private function getLocation($village, $dom){
        $address = $this->getAddress($village);
        $coordinates = explode(',', $village['PROPERTIES']['GEOPOINT']['VALUE']);
        $location = $dom->createElement('location');
        $locationElements = [];
        $locationElements[] = $dom->createElement('address', $address);
        $locationElements[] = $dom->createElement('latitude', $coordinates[0]);
        $locationElements[] = $dom->createElement('longitude', $coordinates[1]);
        foreach ($locationElements as $element) $location->appendChild($element);
        return $location;
    }

    private function getSalesAgent($village, $dom){
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $elements = [];
        $salesAgent = $dom->createElement('sales-agent');
        $elements[] = $dom->createElement('phone', '+79311118572');
        $elements[] = $dom->createElement('whatsapp-phone', '+79993525550');
        $elements[] = $dom->createElement('category', 'developer');
        $elements[] = $dom->createElement('organization', 'Зембери');
        $elements[] = $dom->createElement('url', $url);
        $elements[] = $dom->createElement('email', 'info@zembery.ru');
        $elements[] = $dom->createElement('photo', $url.'/upload/feed/logo.jpg');
        foreach ($elements as $element) $salesAgent->appendChild($element);
        return $salesAgent;
    }

    private function getPrice($plot, $dom){
        $elements = [];
        $price = $dom->createElement('price');
        $elements[] = $dom->createElement('value', $plot['fullprice']);
        $elements[] = $dom->createElement('currency', 'RUB');
        foreach ($elements as $element) $price->appendChild($element);
        return $price;
    }

    private function getLotArea($dom, $plot){
        $elements = [];
        $lotArea = $dom->createElement('lot-area');
        $elements[] = $dom->createElement('value', $plot['PROPERTIES']['SQUARE']['VALUE']);
        $elements[] = $dom->createElement('unit', 'м2');
        foreach ($elements as $element) $lotArea->appendChild($element);
        return $lotArea;
    }

    public function main(){
        $villages = $this->getVillages();
        if (!$villages) return;
        $dom = new \domDocument("1.0", "utf-8");
        $root = $dom->createElement("realty-feed");
        $root->setAttribute("xmlns", "http://webmaster.yandex.ru/schemas/feed/realty/2010-06");
        $dom->appendChild($root);
        $genDate = $dom->createElement("generation-date", date(DATE_ATOM));
        $root->appendChild($genDate);
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        while ($village = $villages->GetNext()) {
            $this->setProps($village);
            if (isset($village['PROPERTIES']['GDATA']['~VALUE']['TEXT'])) $plots = json_decode($village['PROPERTIES']['GDATA']['~VALUE']['TEXT'], true);
            foreach ($plots as $plot){
                if (!$this->validatePlot($plot)) continue;
                $elements = [];
                $offer = $dom->createElement("offer");
                $offer->setAttribute("internal-id", $village['ID'].'-'.$plot['num']);
                $elements[] = $dom->createElement("type", 'продажа');
                $elements[] = $dom->createElement("property-type", 'living');
                $elements[] = $dom->createElement("category", 'lot');
                $elements[] = $dom->createElement("lot-number", $plot['num']);
                $elements[] = $dom->createElement("cadastral-number", $plot['num_kadastr']);
                $elements[] = $dom->createElement("url", $url.$village['DETAIL_PAGE_URL']);
                $elements[] = $dom->createElement('creation-date', date(DATE_ATOM, strtotime($village['DATE_CREATE'])));
                $elements[] = $this->getLocation($village, $dom);
                $elements[] = $dom->createElement('village-name', $village['NAME']);
                $elements[] = $this->getSalesAgent($plot, $dom);
                $elements[] = $this->getPrice($plot, $dom);
                $elements[] = $this->getLotArea($dom, $plot);
                $elements[] = $dom->createElement('deal-status', 'первичная продажа');
                $elements[] = $dom->createElement('haggle', 'false');
                foreach ($elements as $element) $offer->appendChild($element);
                $root->appendChild($offer);
            }
        }
        $dom->save(__DIR__.'/villages.yml');
    }
}

$Yandex = new Yandex;
$Yandex->main();
?>
