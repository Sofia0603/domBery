<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

global $USER, $arPriceColor;

?>

<div class="detail-2 mb-5">
	<div class="row mb-4 mb-lg-5">
		<div class="col-12 col-md-10 col-lg-8">
			<a href="/building/"> ← Назад </a>
		</div>
	</div>
    <div class="row mb-4 mb-lg-5">
        <div class="col-12 col-md-10 col-lg-8">
            <h2 class="mb-4">О проекте</h2>
              <? if ($arResult['PREVIEW_TEXT']) { ?>
                    <div class="font-18" >
                        <?=$arResult['PREVIEW_TEXT']?>
                    </div>
              <? } ?>
        </div>
    </div>

    <div class="row justify-content-between">
        <div class="col-12 col-md-6 mb-4">
            <? if ($arResult['MORE_PHOTO']) { ?>
                <div class="detail-dombery-slider mb-3">
                    <? foreach ($arResult['MORE_PHOTO'] as $arPhotoItem) {
                        $img = CFile::ResizeImageGet($arPhotoItem['ID'], array('width'=>584, 'height'=>414), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
                        ?>
                        <a class="" href="<?=$arPhotoItem['SRC']?>" data-fancybox="detail"><img src="<?=$img['src']?>" /></a>
                    <? } ?>
                </div>
                <div class="detail-dombery-slider-nav">
                    <? foreach ($arResult['MORE_PHOTO'] as $arPhotoItem) {
                        $img = CFile::ResizeImageGet($arPhotoItem['ID'], array('width'=>40, 'height'=>50), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
                        ?>
                        <img src="<?=$img['src']?>" />
                    <? } ?>
                </div>
            <? } else {
                $img = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE'] ? $arResult['DETAIL_PICTURE'] : $arResult['PREVIEW_PICTURE'],
                    array('width'=>736, 'height'=>414), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 90);
                ?>
                <div class="detail-dombery-img">
                    <img class="w-100" src="<?=$img['src']?>">
                </div>
            <?}	?>
        </div>

        <div class="col-12 col-md-6 col-xl-5 mb-4">

            <h2 class="mb-2"><?=$arResult['NAME']?></h2>

            <? if ($arResult['DISPLAY_PROPERTIES']['PLACE']) { ?>
                <div class="mb-1 gray">
                    <?=$arResult['DISPLAY_PROPERTIES']['PLACE']['DISPLAY_VALUE']?>
                </div>
            <? } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['PRICE']) { ?>
                <div class="mb-2 gray">
                    Стоимость: <?=number_format(str_replace(' ','',$arResult['DISPLAY_PROPERTIES']['PRICE']['VALUE']), 0, '', ' ');?> &#8381;
                </div>
            <? } ?>
            <? if ($arResult['DISPLAY_PROPERTIES']['SDAN']) { ?>
                <div class="mb-2 gray">
                    Сдан: <?=$arResult['DISPLAY_PROPERTIES']['SDAN']['VALUE'];?>
                </div>
            <? } ?>

            <div class="d-flex mb-3">
                <? if ($arResult['DISPLAY_PROPERTIES']['SOLD']['VALUE'] == "Y") { ?>
                    <div class="badge badge-lg badge-danger mr-2">
                        <?=$arResult['DISPLAY_PROPERTIES']['SOLD']['NAME']?>
                    </div>
                <? } ?>

                <? if ($arResult['DISPLAY_PROPERTIES']['READY']['VALUE'] == 1) { ?>
                    <div class="badge badge-lg badge-success">
                        <?=$arResult['DISPLAY_PROPERTIES']['READY']['NAME']?>
                    </div>
                <? } ?>
            </div>

            <div class="dombery-property mb-3">
                <?
                $arPropertyList = array('SQUARE', 'FLOOR', 'BEDROOM', 'TOILET', 'SIZE', 'ROOF', 'FASAD', 'AREA', 'PEREKR', 'FUNDAMENT', 'GAZ', 'CEPTIC', 'SKVAZHINA', 'ASPHALT');
                foreach ($arResult['DISPLAY_PROPERTIES'] as $arProperty) {
                    if (!in_array($arProperty['CODE'], $arPropertyList)) continue;
                    if ($arProperty['USER_TYPE'] == "SASDCheckboxNum" && !$arProperty['VALUE']) continue;
                    ?>
                    <div class="mb-3 ">
                        <? if ($arProperty['USER_TYPE'] == "SASDCheckboxNum") { ?>
                            <b><?=$arProperty['NAME']?></b>
                        <? } else { ?>
                            <span class="weight-700"><?=$arProperty['NAME']?></span>
                            <?=$arProperty['DISPLAY_VALUE']?>
                        <? } ?>
                    </div>
                    <?
                }
                ?>
            </div>

            <? if ($arResult['DISPLAY_PROPERTIES']['OTDELKA']) { ?>
                <div class="mb-1 dombery-otdelka">
                    <div class="weight-700 mb-2"><?=$arResult['DISPLAY_PROPERTIES']['OTDELKA']['NAME']?></div>
                    <div class="gray col-lg-9 p-0">
                        <?=$arResult['DISPLAY_PROPERTIES']['OTDELKA']['DISPLAY_VALUE']?>
                    </div>
                </div>
            <? } ?>

        </div>
    </div>
    <div class="row mb-4 mb-lg-5">
        <div class="col-12 col-md-10 col-lg-8">
              <? if ($arResult['DETAIL_TEXT']) { ?>
                    <div class="font-18" >
                        <?=$arResult['DETAIL_TEXT']?>
                    </div>
              <? } ?>
        </div>
    </div>
</div>


<div id="book" class="popup" style="display: none;">
    <img class="mb-2" src="/images/ico-question-green.svg" />
    <h2>
        Заказать проект
    </h2>

    <div class="mb-3">
        <span class="gray"><?=$arResult['NAME']?></span>
    </div>

    <div class="darkgray-bg rounded-lg px-3 pt-3">
        <form class="form-ajax form-row justify-content-center" action="/local/include/ajax-bron-create.php">
            <input type="hidden" name="form_name" value="Заказать проект <?=$arResult['NAME']?>">
            <input type="hidden" name="PRODUCT_ID" value="<?=$arResult['ID']?>">
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg" type="text" name="name" placeholder="ФИО" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg " type="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
            </div>
            <div class="col-12 col-md-8 text-center mb-3">
                <input class="btn btn-primary btn-lg btn-block " type="submit" name="submit" placeholder="Заказать">
            </div>
        </form>
    </div>
</div>

<div id="preview" class="popup" style="display: none;">
    <img class="mb-2" src="/images/ico-question2-green.svg" />
    <h2>
        Консультация
    </h2>

    <div class="mb-3">
        <span class="gray">Свяжитесь с нами, по телефону</span> +7(495)109-33-39 <span class="gray">или формой ниже, и мы с удовольствием обо всём расскажем.</span>
    </div>

    <div class="darkgray-bg rounded-lg px-3 pt-3">
        <form class="form-ajax form-row justify-content-center">
            <input type="hidden" name="form_name" value="Запрос на консультацию по проекту <?=$arResult['NAME']?>">
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
            </div>
            <div class="col-12 col-md-8 text-center mb-3">
                <input class="btn btn-primary btn-lg btn-block " type="submit" name="submit" placeholder="Запросить">
            </div>
        </form>
    </div>
</div>