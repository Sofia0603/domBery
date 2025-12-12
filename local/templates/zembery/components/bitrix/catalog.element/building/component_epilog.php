<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

global $APPLICATION;

$arFavorites = json_decode($_COOKIE['favorites'], true);
if (in_array($arResult['ID'], $arFavorites)) {
    ?>
    <script>
        $(document).ready(function(){
            $('.jsFavorites').addClass('green');
        })
    </script>
    <?
}

// check compared state
if ($arParams['DISPLAY_COMPARE'])
{
    $compared = false;
    $comparedIds = array();

    if (!empty($_SESSION[$arParams['COMPARE_NAME']][$arResult['IBLOCK_ID']]))
    {
        if (array_key_exists($arResult['ID'], $_SESSION[$arParams['COMPARE_NAME']][$arResult['IBLOCK_ID']]['ITEMS']))
        {
            $compared = true;
        }
    }

    if ($compared) {
        ?>
        <script>
            $(document).ready(function(){
                $('.jsCompare').addClass('green');
                $('.jsCompare > .count').html('(' + <?=(count($_SESSION[$arParams['COMPARE_NAME']][$arResult['IBLOCK_ID']]['ITEMS']))?> + ')');
            })
        </script>
        <?
    }


}

$GLOBALS['arFilterNearby'] = array('ID' => $arResult['NEARBY']);

