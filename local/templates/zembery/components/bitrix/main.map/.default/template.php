<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule("iblock");

$iblockIds = [1, 5, 11, 16]; // ID нужных инфоблоков

$arSections = [];
$iblocksWithSections = []; // Запоминаем инфоблоки, у которых есть разделы

// Получаем список инфоблоков
$res = \Bitrix\Iblock\IblockTable::getList([
    'filter' => ["ID" => $iblockIds, "ACTIVE" => "Y"],
    'select' => ["ID", "NAME"]
]);

while ($iblock = $res->fetch()) {
    $arSections["IBLOCK_" . $iblock["ID"]] = [
        "NAME" => $iblock["NAME"],
        "URL" => "#", // Можно добавить реальный URL
        "ELEMENTS" => []
    ];
}

// Получаем разделы инфоблоков
$arFilter = ["IBLOCK_ID" => $iblockIds, "ACTIVE" => "Y"];
$arSelect = ["ID", "NAME", "SECTION_PAGE_URL", "IBLOCK_ID"];
$res = CIBlockSection::GetList([], $arFilter, false, $arSelect);

while ($arSection = $res->GetNext()) {
    $iblocksWithSections[$arSection["IBLOCK_ID"]] = true; // Запоминаем, что инфоблок содержит разделы
    $arSections[$arSection["ID"]] = [
        "NAME" => $arSection["NAME"],
        "URL" => $arSection["SECTION_PAGE_URL"],
        "ELEMENTS" => [],
        "IBLOCK_ID" => $arSection["IBLOCK_ID"]
    ];
}

// Получаем элементы и распределяем по разделам или инфоблокам
$arFilter = ["IBLOCK_ID" => $iblockIds, "ACTIVE" => "Y"];
$arSelect = ["ID", "NAME", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID", "IBLOCK_ID"];
$res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

while ($arItem = $res->GetNext()) {
    if ($arItem["IBLOCK_SECTION_ID"] && isset($arSections[$arItem["IBLOCK_SECTION_ID"]])) {
        // Если элемент в разделе, добавляем в раздел
        $arSections[$arItem["IBLOCK_SECTION_ID"]]["ELEMENTS"][] = [
            "NAME" => $arItem["NAME"],
            "URL" => $arItem["DETAIL_PAGE_URL"]
        ];
    } else {
        // Если инфоблок уже имеет разделы – не добавляем его в список без разделов
        if (!isset($iblocksWithSections[$arItem["IBLOCK_ID"]])) {
            $arSections["IBLOCK_" . $arItem["IBLOCK_ID"]]["ELEMENTS"][] = [
                "NAME" => $arItem["NAME"],
                "URL" => $arItem["DETAIL_PAGE_URL"]
            ];
        }
    }
}

// Удаляем пустые разделы (без элементов)
foreach ($arSections as $key => $section) {
    if (!isset($section["ELEMENTS"]) || empty($section["ELEMENTS"])) {
        unset($arSections[$key]);
    }
}
?>

<table class="map-columns">
    <tr>
        <td>
            <ul class="map-level-0">
                <? foreach ($arSections as $key => $section): ?>
                    <?php
                    // Пропускаем дублирующиеся инфоблоки, если у них есть разделы
                    if (strpos($key, "IBLOCK_") !== false && isset($iblocksWithSections[str_replace("IBLOCK_", "", $key)])) {
                        continue;
                    }
                    ?>
                    <li>
                        <h2><a href="<?=$section["URL"]?>"><?=$section["NAME"]?></a></h2>
                        <? if (!empty($section["ELEMENTS"])): ?>
                            <ul class="map-level-1">
                                <? foreach ($section["ELEMENTS"] as $element): ?>
                                    <li><a href="<?=$element["URL"]?>"><?=$element["NAME"]?></a></li>
                                <? endforeach; ?>
                            </ul>
                        <? endif; ?>
                    </li>
                <? endforeach; ?>
            </ul>
        </td>
        <td>
            <ul class="map-level-0">
                <?php
                $excludedIblocks = ['Посёлки', 'Дома', 'Реализованные проекты', 'Вакансии']; // Имена инфоблоков, которые НЕ должны выводиться

                foreach ($arResult["arMap"] as $arItem):
                    if (empty(trim(strip_tags($arItem["NAME"])))) continue;

                    // Пропускаем инфоблоки из списка исключенных
                    if (isset($arItem["NAME"]) && in_array($arItem["NAME"], $excludedIblocks)) continue;

                    // Очищаем данные от HTML тегов и делаем безопасными для вывода
                    $arItem["FULL_PATH"] = htmlspecialcharsbx($arItem["FULL_PATH"], ENT_COMPAT, false);
                    $arItem["NAME"] = htmlspecialcharsbx($arItem["NAME"], ENT_COMPAT, false);
                    $arItem["DESCRIPTION"] = htmlspecialcharsbx($arItem["DESCRIPTION"], ENT_COMPAT, false);
                    ?>

                    <li>
                        <a href="<?=$arItem["FULL_PATH"]?>"><?=$arItem["NAME"]?></a>
                        <?php if ($arParams["SHOW_DESCRIPTION"] == "Y" && $arItem["DESCRIPTION"] <> ''): ?>
                            <div><?=$arItem["DESCRIPTION"]?></div>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>
            </ul>



        </td>
    </tr>
</table>
