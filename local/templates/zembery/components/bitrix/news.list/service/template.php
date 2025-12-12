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
<div class="row align-items-stretch mb-5" data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>" >
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="vacancy-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="row mb-3">
                <div class="col font-18 weight-500"><?=$arItem['NAME']?></div>
                <div class="col-auto font-14 gray"><?=sprintf("%02d", ($key+1))?></div>
            </div>

            <div class="row flex-grow-1 mb-sm-4">
                <? if ($arItem['DISPLAY_PROPERTIES']['TIMEWORK']) {?>
                    <div class="col-12 col-sm mb-2">
                        <div class="font-14 gray mb-2"><?=$arItem['DISPLAY_PROPERTIES']['TIMEWORK']['NAME']?>:</div>
                        <div class="font-14 "><?=$arItem['DISPLAY_PROPERTIES']['TIMEWORK']['DISPLAY_VALUE']?></div>
                    </div>
                <? } ?>


                <? if ($arItem['DISPLAY_PROPERTIES']['PRICE']) {?>
                    <div class="col-12 col-sm-auto mb-2">
                        <div class="font-14 gray mb-2"><?=$arItem['DISPLAY_PROPERTIES']['PRICE']['NAME']?>:</div>
                        <div class="font-14 "><?=$arItem['DISPLAY_PROPERTIES']['PRICE']['DISPLAY_VALUE']?></div>
                    </div>
                <? } ?>

                <? if ($arItem['PREVIEW_TEXT']) {?>
                    <div class="col-12 mb-2">
                        <div class="font-12 gray"><?=$arItem['PREVIEW_TEXT']?></div>
                    </div>
                <? } ?>
            </div>

            <div class="">
                <a class="btn btn-primary btn-lg btn-block" href="#service-reply" data-fancybox >Заказать</a>
            </div>
        </div>
    </div>
	<?endforeach;?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>

<div id="service-reply" class="popup" style="display: none;">
    <h2>
        Заказать услугу
    </h2>

    <div class="mb-3">
        Отправьте заявку и наш эксперт по услугам свяжется
        с вами в ближайшее время
    </div>

    <form class="form-ajax row gx-2 justify-content-center" >
        <input type="hidden" name="form_name" value="Заказ дополнительной услуги">
        <div class="col-12 mb-3">
            <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
        </div>
        <div class="col-12 mb-3">
            <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
        </div>
        <div class="col-12  mb-3">
            <input class="form-control form-control-lg " type="email" name="email" placeholder="E-mail" required="">
        </div>
        <div class="col-12 mb-3">
            <textarea class="form-control form-control-lg " name="message" placeholder="Расскажите подробнее какая услуга вас интересует" required rows="5"></textarea>
        </div>

        <? /* <input class="captchaSid" type="hidden" name="captcha_sid" value=""/>
        <div class="col-12 input-group mb-3">
            <div class="input-group-prepend border">
                <img class="jsReloadCaptcha captchaImg" alt="CAPTCHA"/>
            </div>

            <input class="form-control form-control-lg" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите код с картинки" required />
        </div> */ ?><input type="hidden" name="woc" value="1">

        <div class="col-12 col-md-6 mb-3">
            <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Обратный звонок">
        </div>
    </form>

</div>
