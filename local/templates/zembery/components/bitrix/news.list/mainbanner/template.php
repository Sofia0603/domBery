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

<div class="mainslider -v2 d-flex">
    <?php
    GLOBAL $USER;
    if($USER->IsAdmin()):
//    echo '<pre>';
//    var_dump($arResult["ITEMS"]);
//    echo '</pre>';
    endif;
    ?>
    <?foreach($arResult["ITEMS"] as $arItem):?>
<?php
        $arFile = CFile::ResizeImageGet($arItem['DISPLAY_PROPERTIES']['BANNER_IMAGE']['VALUE'], true);
        ?>
        <a href="<?=$arItem['DISPLAY_PROPERTIES']['BANNER_LINK']['VALUE']?>" class="project__section  d-md-block">
            <img  src="<?=$arFile['src']?>" alt="banner" />
        </a>
    <?endforeach;?>
</div>
