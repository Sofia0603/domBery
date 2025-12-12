<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$APPLICATION->IncludeComponent(
    "bitrix:search.page",
    "suggest",
    array(
        "RESTART" => "Y",
        "CHECK_DATES" => "Y",
        "arrWHERE" => array(
            0 => "forum",
            1 => "blog",
        ),
        "arrFILTER" => array(
            0 => "iblock_catalog",
        ),
        "SHOW_WHERE" => "N",
        "PAGE_RESULT_COUNT" => "10",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "TAGS_SORT" => "NAME",
        "TAGS_PAGE_ELEMENTS" => "20",
        "TAGS_PERIOD" => "",
        "TAGS_URL_SEARCH" => "",
        "TAGS_INHERIT" => "Y",
        "SHOW_RATING" => "N",
        "FONT_MAX" => "50",
        "FONT_MIN" => "10",
        "COLOR_NEW" => "000000",
        "COLOR_OLD" => "C8C8C8",
        "PERIOD_NEW_TAGS" => "",
        "SHOW_CHAIN" => "Y",
        "COLOR_TYPE" => "Y",
        "WIDTH" => "100%",
        "PATH_TO_USER_PROFILE" => "#SITE_DIR#people/user/#USER_ID#/",
        "COMPONENT_TEMPLATE" => ".default",
        "NO_WORD_LOGIC" => "N",
        "USE_TITLE_RANK" => "Y",
        "DEFAULT_SORT" => "rank",
        "FILTER_NAME" => "",
        "SHOW_WHEN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "USE_LANGUAGE_GUESS" => "N",
        "USE_SUGGEST" => "N",
        "SHOW_ITEM_TAGS" => "N",
        "SHOW_ITEM_DATE_CHANGE" => "N",
        "SHOW_ORDER_BY" => "N",
        "SHOW_TAGS_CLOUD" => "N",
        "RATING_TYPE" => "",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Результаты поиска",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "arrFILTER_iblock_catalog" => array(
            0 => "1",
        )
    ),
    false
);
