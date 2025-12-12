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

if (!empty($arResult['SECTIONS'])) {
?>
    <div class="form-row align-items-center">
        <div class="col-auto mb-3">
            <a class="btn <?=(empty($arParams['CURRENT_SECTION_CODE']) ? 'btn-primary' : 'btn-outline-secondary')?> " href="<?=$arResult['SECTIONS'][0]['LIST_PAGE_URL'] ?>">Все</a>
        </div>

        <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
            <div class="col-auto mb-3">
                <a class="btn btn-pills <?=($arSection['CODE'] == $arParams['CURRENT_SECTION_CODE'] ? 'btn-primary' : 'btn-outline-secondary')?>" href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
            </div>
        <? } ?>
    </div>
<?
}