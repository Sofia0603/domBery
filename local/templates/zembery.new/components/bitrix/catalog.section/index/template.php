<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        "",
        array(
            "IBLOCK_ID" => "1",
            "IBLOCK_TYPE" => "catalog",
            "SECTION_ID" => 16,
            "FILTER_NAME" => "",
            "PRICE_CODE" => array(
                0 => "BASE",
            ),
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "N",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "SAVE_IN_SESSION" => "N",
            "FILTER_VIEW_MODE" => "HORIZONTAL",
            "XML_EXPORT" => "Y",
            "SECTION_TITLE" => "NAME",
            "SECTION_DESCRIPTION" => "DESCRIPTION",
            'HIDE_NOT_AVAILABLE' => "N",
            "TEMPLATE_THEME" => "",
            "CONVERT_CURRENCY" => "N",
            'CURRENCY_ID' => '',
            "SEF_MODE" => "Y",
            "SEF_RULE" => "/#SECTION_CODE#/filter/#SMART_FILTER_PATH#/apply/",
            "SMART_FILTER_PATH" => "",
            "PAGER_PARAMS_NAME" => "",
        ),
        false,
        array('HIDE_ICONS' => 'Y')
    );?>

<div>
    <div class="sale__block" data-view="list">
        <section class="elements" data-navnum="<?=$arResult['NAV_RESULT']->NavNum;?>">
            <? foreach ($arResult['ITEMS'] as $key => $arItem) { ?>
                <?
                $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>494, 'height'=>370), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);
                $isAllSold = $arItem['DISPLAY_PROPERTIES']['ALL_SOLD']['VALUE'];
                ?>
                <div class="element" id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=$arItem['DETAIL_PAGE_URL'] ?>">
                    <a class="" href="<?=$arItem['DETAIL_PAGE_URL'] ?>">
                        <div>
                            <img class="element__image" src="<?=$img['src']?>" />
                            <? if ($arItem['DISPLAY_PROPERTIES']['LABEL']) { ?>
                                <img class="element__start" src="<?=SITE_TEMPLATE_PATH?>/image/Start.svg" alt="Старт продаж" />
                            <? } ?>
                            <!-- <a class="element__icon" href="#"><img src="<?=SITE_TEMPLATE_PATH?>/image/IconStart.svg" alt="Иконка" /></a> -->
                        </div>
                        <div>
                            <h4 class="element__title"><?=$arItem['NAME']?></h4>
                            <? if ($arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']) { ?>
                                <p class="element__subtitle"><?=$arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']['DISPLAY_VALUE']?></p>
                            <? } ?>
                        </div>
                        <div class="element__sale">
                            <p class="element__paragraph">Цена за сотку:</p>
                            <? if ($arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) { ?>
                                <p class="element__paragraph-price">от <?=$arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE']?></p>
                            <? } ?>
                        </div>
                        <a class="element__button" href="<?=$arItem['DETAIL_PAGE_URL'] ?>">Подробнее</a>
                    </a>
                </div>
            <? } ?>
        </section>
        <a href="/catalog/" class="btn btn-block sale__button">Показать все</a>
    </div>
    <div class="sale__block d-none" data-view="map">
        <?$APPLICATION->IncludeFile('/local/include/new/inc-index-map.php', array(), array('SHOW_BORDER'=>true, 'MODE' => "html"))?>
    </div>
</div>
    
