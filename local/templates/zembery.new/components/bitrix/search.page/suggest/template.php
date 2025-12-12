<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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

?>
<?if(count($arResult["SEARCH"])>0):?>
    <div class="ajax-search-page">
        <? foreach ( $arResult['SECTIONS'] as $sectionName => $arSection) { ?>
            <h3><?=$sectionName?></h3>

            <? foreach($arSection as $arItem): ?>
                <a class="ajax-search-item" href="<?echo $arItem["URL"]?>"><?echo $arItem["TITLE_FORMATED"]?></a>
            <? endforeach; ?>
        <? } ?>
    </div>
<?endif;?>

