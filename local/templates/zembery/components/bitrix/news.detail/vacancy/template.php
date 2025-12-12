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
<a class="gray" href="<?=$arResult['LIST_PAGE_URL']?>"><i class="fal fa-long-arrow-left me-3"></i>Назад</a>

<div class="vacancy-detail white-bg rounded-lg p-4 p-lg-5 mb-5 mt-4">
    <h1 class="mb-3"><?=$arResult['NAME']?></h1>

    <div class="mb-5"><?=$arResult['DISPLAY_PROPERTIES']['LOCATION']['DISPLAY_VALUE'] ?></div>

    <div class="row justify-content-between align-items-start flex-lg-nowrap">
        <? if ($arResult['DISPLAY_PROPERTIES']['TYPE']) {?>
            <div class="col-12 col-sm-6 col-lg-auto mb-4 mb-lg-0 flex-shrink-1">
                <div class="gray mb-2"><?=$arResult['DISPLAY_PROPERTIES']['TYPE']['NAME']?>:</div>
                <div class=""><?=$arResult['DISPLAY_PROPERTIES']['TYPE']['DISPLAY_VALUE']?></div>
            </div>
        <? } ?>

        <? if ($arResult['DISPLAY_PROPERTIES']['EXPERIENCE']) {?>
            <div class="col-12 col-sm-6 col-lg-auto mb-4 mb-lg-0 flex-shrink-1">
                <div class="gray mb-2"><?=$arResult['DISPLAY_PROPERTIES']['EXPERIENCE']['NAME']?>:</div>
                <div class=""><?=$arResult['DISPLAY_PROPERTIES']['EXPERIENCE']['DISPLAY_VALUE']?></div>
            </div>
        <? } ?>

        <? if ($arResult['DISPLAY_PROPERTIES']['TYPE']) {?>
            <div class="col-12 col-sm-6 col-lg-auto mb-4 mb-lg-0 flex-shrink-1">
                <div class="gray mb-2"><?=$arResult['DISPLAY_PROPERTIES']['PAY']['NAME']?>:</div>
                <div class=""><?=$arResult['DISPLAY_PROPERTIES']['PAY']['DISPLAY_VALUE']?></div>
            </div>
        <? } ?>

        <div class="col-12 col-sm-6 col-lg-auto mb-4 mb-lg-0 ">
            <a class="btn btn-primary btn-lg btn-block px-xl-5" href="#vacancy-reply" data-fancybox>Откликнуться</a>
        </div>
    </div>

    <hr class="my-5">

    <? if ($arResult['DETAIL_TEXT']) { ?>
        <div class="mb-5"><?=$arResult['DETAIL_TEXT']?></div>
    <? } ?>

    <? foreach ($arResult['DISPLAY_PROPERTIES']['DESCRIPTION']['DISPLAY_VALUE'] as $descrKey => $descrHtml) { ?>
        <div class="font-20 weight-600 mb-4"><?=$arResult['DISPLAY_PROPERTIES']['DESCRIPTION']['DESCRIPTION'][$descrKey]?></div>
        <div class="gray mb-5"><?=$descrHtml?></div>
    <? } ?>

    <div></div>

    <div class="smokywhite-bg rounded-lg py-4 px-5 mt-3 text-center">
        <div class="font-20 weight-600 mb-4 pb-3 mt-2">
            Если вакансия заинтересовала, смело откликайтесь, и мы свяжемся с Вами!<br>
            В сопроводительном письме расскажите, почему именно Вас мы должны принять в свою команду!
        </div>

        <a class="btn btn-primary btn-lg  px-5 mb-2" href="#vacancy-reply" data-fancybox>Откликнуться</a>
    </div>

    <div id="vacancy-reply" class="popup" style="display: none;">
        <img class="mb-2" src="/images/ico-edit_chat_history.svg" />
        <h2>
            Откликнуться на вакансию
        </h2>

        <div class="mb-3">
            <span class="gray">Отправьте ваши контактные данные, и мы свяжемся с вами.</span>
        </div>

        <div class="darkgray-bg rounded-lg px-3 pt-3">
            <form class="form-ajax row gx-2 justify-content-center" >
                <input type="hidden" name="form_name" value="Отклик на вакансию <?=$arResult['NAME']?>">
                <div class="col-12 col-sm-6 mb-3">
                    <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
                </div>

                <div class="col-12 mb-3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.file.input",
                        "drag_n_drop",
                        array(
                            "INPUT_NAME" => "FILE",
                            "MULTIPLE" => "Y",
                            "MODULE_ID" => "iblock",
                            "MAX_FILE_SIZE" => "",
                            "ALLOW_UPLOAD" => "A",
                            "ALLOW_UPLOAD_EXT" => "pdf",
                            "COMPONENT_TEMPLATE" => "drag_n_drop",
                            "TITLE_UPLOAD" => "Загрузите pdf с вашим резюме",
                            //"INPUT_VALUE" => $arTransaction['PROP']['FILES']['VALUE'],
                        ),
                        false
                    );?>
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
    </div>
</div>



