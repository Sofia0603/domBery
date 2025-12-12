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

$arData = array();
foreach ($arResult['ITEMS'] as $key => $arItem) {
    $arData[] = array('URL' => $arItem['DETAIL_PAGE_URL'], 'NAME' => $arItem['NAME']);
}
?>
<script>
    var arSearchData = <?=json_encode($arData) ?>
</script>
