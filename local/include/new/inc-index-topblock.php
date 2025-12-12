<div class="container pb-4 pt-2">
    <section class="project">
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
                "PROPERTY_CODE" => array("URL", "VIDEO"),
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC",
                "PARENT_SECTION_CODE" => "main-new"
            ),
            true
        );?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "mainbanner",
            Array(
                "IBLOCK_ID" => "25",
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
                "PROPERTY_CODE" => array("BANNER_IMAGE", "BANNER_LINK"),
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC",
//                "PARENT_SECTION_CODE" => "main"
            ),
            true
        );?>

    </section>
</div>