<?='</div><!-- force close container -->'?>
<div class="index-topblock" style="display: none">
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "mainslider",
                Array(
                    "IBLOCK_ID" => "8",
                    "IBLOCK_TYPE" => "content",
                    "NEWS_COUNT" => 99,
                    "SET_TITLE" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    //"FILTER_NAME" => "arFilterOtherArticles",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "FIELD_CODE" => array(),
                    "PROPERTY_CODE" => array(),
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_ORDER2" => "ASC",
                    "PARENT_SECTION_CODE" => "main"
                ),
                false
            );?>

</div>

<div class="index-topblock" >
    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "mainslider-v2",
        Array(
            "IBLOCK_ID" => "8",
            "IBLOCK_TYPE" => "content",
            "NEWS_COUNT" => 99,
            "SET_TITLE" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "N",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            //"FILTER_NAME" => "arFilterOtherArticles",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "FIELD_CODE" => array("PREVIEW_PICTURE", "DETAIL_PICTURE"),
            "PROPERTY_CODE" => array("URL"),
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_BY2" => "SORT",
            "SORT_ORDER1" => "DESC",
            "SORT_ORDER2" => "ASC",
            "PARENT_SECTION_CODE" => "main2"
        ),
        false
    );?>

</div>

<?='<div class="container"><!-- reopen container -->'?>

<div class="index-smartfilter">
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
</div>