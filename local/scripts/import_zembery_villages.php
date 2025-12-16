<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule("iblock");

$IBLOCK_ID = 1;
$SECTION_ID = 16; // Раздел "Поселки"
$XML_URL = "https://zembery.ru/bitrix/catalog_export/export_ER2.xml";

// Загружаем XML
$xml = simplexml_load_file($XML_URL);
if (!$xml) die("Ошибка загрузки XML");

$offers = $xml->shop->offers->offer;
$el = new CIBlockElement;

foreach ($offers as $offer) {
    $name = trim((string)$offer->name);
    $offer_id = (string)$offer['id']; // уникальный ID предложения

    if (!$name || !$offer_id) {
        echo "Пропущено предложение без названия или ID<br>";
        continue;
    }

    // Используем ID предложения как уникальный XML_ID, чтобы каждый участок был отдельным элементом
    $XML_ID = (string)$offer_id;

    echo "<strong>Обрабатываем:</strong> $name (Offer ID: $offer_id, XML_ID: $XML_ID)<br>";

    // Главная картинка
    $preview = false;
    $imgUrl = (string)$offer->picture[0];
    if ($imgUrl) {
        $tmp = @CFile::MakeFileArray($imgUrl);
        if ($tmp && isset($tmp["tmp_name"]) && file_exists($tmp["tmp_name"])) {
            $preview = $tmp;
        } else {
            echo "Не удалось скачать главную картинку для {$name}: {$imgUrl}<br>";
        }
    }

    // Галерея
    $photos = [];
    foreach ($offer->picture as $pic) {
        $tmp = @CFile::MakeFileArray((string)$pic);
        if ($tmp && isset($tmp["tmp_name"]) && file_exists($tmp["tmp_name"])) {
            $photos[] = $tmp;
        } else {
            echo "Не удалось скачать фото для {$name}: {$pic}<br>";
        }
    }

    // Проверяем существование элемента по XML_ID
    $res = CIBlockElement::GetList([], [
        "IBLOCK_ID" => $IBLOCK_ID,
        "XML_ID" => $XML_ID
    ], false, false, ["ID"]);

    $fields = [
        "IBLOCK_ID" => $IBLOCK_ID,
        "IBLOCK_SECTION_ID" => $SECTION_ID,
        "NAME" => $name,
        "XML_ID" => $XML_ID,
        "ACTIVE" => "Y",
        "PREVIEW_PICTURE" => $preview,
        "PROPERTY_VALUES" => [
            "PHOTOS" => $photos
        ]
    ];

    if ($exist = $res->Fetch()) {
        if ($el->Update($exist["ID"], $fields)) {
            echo "Обновлён участок: {$name} (ID: {$offer_id})<br>";
        } else {
            echo "Ошибка обновления {$name}: " . $el->LAST_ERROR . "<br>";
        }
    } else {
        $ID = $el->Add($fields);
        echo $ID
            ? "Добавлен участок: {$name} (ID: {$offer_id})<br>"
            : "Ошибка добавления {$name}: " . $el->LAST_ERROR . "<br>";
    }
}
?>


// <?php
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//
// use Bitrix\Main\Loader;
//
// Loader::includeModule("iblock");
//
// $XML_URL = "https://zembery.ru/bitrix/catalog_export/export_ER2.xml";
//
// $xml = simplexml_load_file($XML_URL);
// if (!$xml) die("Ошибка загрузки XML");
//
// $offers = $xml->shop->offers->offer;
//
// echo "<h2>Список всех поселков и участков из XML</h2>";
// echo "<table border='1' cellpadding='5' cellspacing='0'>";
// echo "<tr><th>Offer ID</th><th>Название</th><th>Адрес</th><th>Преимущества</th><th>Номер участка</th><th>Ссылка</th><th>Картинка</th></tr>";
//
// foreach ($offers as $offer) {
//     $name = trim((string)$offer->name);
//     $offer_id = (string)$offer['id'];
//     $url = (string)$offer->url;
//
//     if (!$name || !$offer_id) continue;
//
//     $address = '';
//     $advantages = [];
//     $plot_number = '';
//
//     foreach ($offer->param as $param) {
//         $param_name = (string)$param['name'];
//         $param_value = (string)$param;
//
//         if ($param_name === 'Адрес') $address = $param_value;
//         elseif ($param_name === 'Преимущества') $advantages[] = $param_value;
//         elseif ($param_name === 'Номер участка') $plot_number = $param_value;
//     }
//
//     $picture = isset($offer->picture[0]) ? (string)$offer->picture[0] : '';
//
//     echo "<tr>";
//     echo "<td>{$offer_id}</td>";
//     echo "<td>{$name}</td>";
//     echo "<td>{$address}</td>";
//     echo "<td>" . implode(', ', $advantages) . "</td>";
//     echo "<td>{$plot_number}</td>";
//     echo "<td><a href='{$url}' target='_blank'>Ссылка</a></td>";
//     echo "<td>" . ($picture ? "<img src='{$picture}' width='100'>" : '') . "</td>";
//     echo "</tr>";
// }
//
// echo "</table>";
// ?>
