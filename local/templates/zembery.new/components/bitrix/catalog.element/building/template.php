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

<div class="detail-1">
    <div class="form-row align-items-stretch mb-lg-4">
        <div class="col-12 col-lg mb-4 mb-lg-0">
            <? if ($arResult['DISPLAY_PROPERTIES']['SERIES']) { ?>
               <div>
                    <a class="weight-700 border-bottom border-dashed" href="<?=$arResult['LIST_PAGE_URL']?>filter/series-is-<?=$arResult['DISPLAY_PROPERTIES']['SERIES']['VALUE_XML_ID']?>/apply/">Серия проектов <?=$arResult['DISPLAY_PROPERTIES']['SERIES']['DISPLAY_VALUE']?></a>
               </div>
            <? } ?>

            <h1 class="mb-2"><?=trim($arResult['DISPLAY_PROPERTIES']['DETAIL_TITLE'] ? $arResult['DISPLAY_PROPERTIES']['DETAIL_TITLE']['DISPLAY_VALUE'] : $arResult['NAME'])?><a
                        class="ml-3 jsFavorites" href="#" data-id="<?=$arResult['ID']?>"
                        title="Добавить в избранное"><i class="fal fa-star font-26"></i></a></h1>
            <? if ($arResult['DISPLAY_PROPERTIES']['SIZE']) { ?>
                <div class="gray"><?=$arResult['DISPLAY_PROPERTIES']['SIZE']['NAME'].': '.$arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']?></div>
            <? } ?>
        </div>

        <? if ($arResult['DISPLAY_PROPERTIES']['PRICE_FOR_FINISH'] || $arResult['DISPLAY_PROPERTIES']['PRICE_FINISH']) { ?>
            <? if ($arResult['DISPLAY_PROPERTIES']['PRICE_FOR_FINISH']) { ?>
                <div class="col-12 col-sm col-lg-auto mb-4 mb-lg-0 text-sm-right">
                    <div class="gray font-14 position-relative " style="z-index: 5">Под отделку</div>

                    <div class="detail-price font-28 pt-0 mt-n2">
                        <?=$arResult['DISPLAY_PROPERTIES']['PRICE_FOR_FINISH']['DISPLAY_VALUE']?>
                    </div>

                    <!-- div class="mt-n2"><a class="green" href="#description_for_finish" data-fancybox>Что входит в стоимость?</a></div -->

                    <div class="detail-price-wrap">
                        <hr>
                        <div class="weight-500 mb-2">Узнайте как получить скидку!</div>
                        <a class="d-block weight-500 green font-14" href="/sale/">Подробнее</a>
                        <hr>
                        <div class="weight-500 mb-2">Хотите дешевле?</div>
                        <div class="mb-2 font-14">Оставьте свой e-mail и мы оповестим вас об изменении цены! Но напоминаем, цена может и вырасти. 🙂</div>
                        <a class="d-block weight-500 green font-14" href="#price_subscribe" data-fancybox>Подписаться на цену</a>
                    </div>
                </div>
                <div id="description_for_finish" class="popup" style="display:none;"><?$APPLICATION->IncludeFile('/local/include/inc-description_for_finish.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"))?></div>
            <? } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['PRICE_FOR_FINISH'] && $arResult['DISPLAY_PROPERTIES']['PRICE_FINISH']) { ?>
                <div class="d-none d-sm-block col-auto px-3"><div class="h-100 border-left border-dashed"></div></div>
            <? } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['PRICE_FINISH']) { ?>
                <div class="col-12 col-sm col-lg-auto text-sm-right">
                    <div class="gray font-14 position-relative " style="z-index: 5">Цена дома "под ключ"</div>

                    <div class="detail-price font-28 pt-0 mt-n2">
                        <?=$arResult['DISPLAY_PROPERTIES']['PRICE_FINISH']['DISPLAY_VALUE']?>
                    </div>

                    <!-- div class="mt-n2"><a class="green" href="#description_finish" data-fancybox>Что входит в стоимость?</a></div -->

                    <div class="detail-price-wrap">
                        <hr>
                        <div class="weight-500 mb-2">Узнайте как получить скидку!</div>
                        <a class="d-block weight-500 green font-14" href="/sale/">Подробнее</a>
                        <hr>
                        <div class="weight-500 mb-2">Хотите дешевле?</div>
                        <div class="mb-2 font-14">Оставьте свой e-mail и мы оповестим вас об изменении цены! Но напоминаем, цена может и вырасти. 🙂</div>
                        <a class="d-block weight-500 green font-14" href="#price_subscribe" data-fancybox>Подписаться на цену</a>
                    </div>
                </div>
                <div id="description_finish" class="popup" style="display:none;"><?$APPLICATION->IncludeFile('/local/include/inc-description_finish.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"))?></div>
            <? } ?>


            <div id="price_subscribe" class="popup" style="display:none;">
                <img class="mb-2" src="/images/ico-send_mail.svg">
                <h2>
                    Подписаться на цену
                </h2>

                <div class="mb-3">
                    Оставьте свой e-mail и мы оповестим вас об изменении цены! Но напоминаем, цена может и вырасти. 🙂
                </div>

                <div class="darkgray-bg rounded-lg px-3 pt-3">
                        <form class="form-ajax form-row" action="/local/include/ajax-price-subscribe.php">
                            <input type="hidden" name="product" value="<?=$arResult['ID']?>">
                            <div class="col-12 col-sm mb-3">
                                <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required="">
                            </div>
                            <div class="col-12 col-sm mb-3">
                                <input class="form-control form-control-lg " type="text" name="email" placeholder="E-mail" required="" maxlength="18">
                            </div>

<div class="col-12">
								<p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
							</div>
                            <div class="col-12 col-md mb-3">
                                <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Подписаться">
                            </div>
                        </form>
                    </div>
            </div>
        <? } ?>
    </div>

	<div class="form-row align-items-start border-bottom border-dashed pb-4 my-4 justify-content-between justify-content-md-start">

        <div class="col-12 col-sm-6 col-lg-auto mb-3 mb-lg-0">
            <a class="btn btn-lg btn-primary btn-block" href="#book" data-fancybox >Заказать проект</a>
        </div>

        <div class="col-12 col-sm-6 col-lg-auto mb-3 mb-lg-0">
            <a class="btn btn-lg btn-light btn-block" href="#preview" data-fancybox >Консультация</a>
        </div>


        <div class="col-12 col-sm-6 col-lg-auto mb-3 mb-lg-0 ml-0 ml-lg-auto">
            <a class="btn btn-lg btn-light btn-block jsCompare" href="#" data-id="<?=$arResult['ID']?>" title="Добавить к сравнению">
                <span class="fa-stack fa-4x font-12 mr-3">
                    <i class="fal fa-list-alt fa-stack-2x"></i>
                    <i class="fas fa-inverse fa-plus-circle fa-stack-1x " style="position: relative;bottom: -8px;left: 10px;text-shadow: 1px 1px 0px black, -1px -1px 0px black, -1px 1px 0px black, 1px -1px 0px black;"></i>
                </span>
                Сравнить <span class="count"></span>
            </a>
        </div>

        <? if ($arResult['DISPLAY_PROPERTIES']['GEOPOINT']) { ?>
            <div class="col-12 col-sm-6 col-lg-auto">
                <a class="btn btn-lg btn-light btn-block" href="https://yandex.ru/maps/?rtext=~<?=$arResult['DISPLAY_PROPERTIES']['GEOPOINT']['VALUE']?>" target="_blank"><i class="far fa-route mr-3"></i>Построить маршрут</a>
            </div>
        <? } ?>
	</div>

    <? if ($arResult['ONE_LINE_PROP']) { ?>
        <div class="form-row align-items-stretch border-bottom border-dashed pb-4 my-4 text-nowrap">
            <?
            $colClass = 'col col-sm py-2';
            switch (count($arResult['ONE_LINE_PROP'])) {
                case 4:
                    $colClass = 'col col-sm-6 col-lg py-2';
                    break;
                case 3:
                    $colClass = 'col col-lg-auto py-2';
                    break;
                case 2:
                    $colClass = 'col col-sm-6 col-lg-auto py-2';
                    break;
                case 1:
                    $colClass = 'col col-sm-auto py-2';
                    break;
            }

            foreach ($arResult['ONE_LINE_PROP'] as $code => $arProp) { ?>
                <div class="<?=$colClass?>">
                    <div class="h-100 border rounded d-flex align-items-center p-3 white-bg lineheight13">
                        <img src="<?=$arProp['IMG']?>" />
                        <div class="pl-3">
                            <div class="weight-500"><?=$arProp['DISPLAY_VALUE'] . $arProp['SUFFIX']?></div>
                            <div class="gray font-13 "><?=$arProp['NAME']?></div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    <? } ?>

	<? if ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']) { ?>
		<div class="detail-slider">
			<? foreach ($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] as $arPhotoItem) {
				$img = CFile::ResizeImageGet($arPhotoItem['ID'], array('width'=>736, 'height'=>414), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
				?>
				<a class="detail-slider-item" href="<?=$arPhotoItem['SRC']?>" data-fancybox="detail"><img class="<?=($isAllSold ? 'img-grayscale':'')?>" src="<?=$img['src']?>" /></a>
			<? } ?>
		</div>
	<? } ?>
</div>

<? if ($arResult['DETAIL_TEXT']) { ?>
	<div class="my-5 pb-3">
		<h2 class="mb-4">Описание</h2>

		<div class="text-limitation font-18" data-height="600">
			<?=$arResult['DETAIL_TEXT']?>
		</div>
	</div>
<? } ?>

<? if ( $arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS'] || $arResult['DISPLAY_PROPERTIES']['FACADE_PLANS'] ) { ?>
    <div class="wide-gray-bg py-5" >
        <ul class="nav nav-tabs pb-2">

            <? if ($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']) { ?>
                <li class="nav-item">
                    <a class="nav-link active " data-toggle="tab" href="#house_plans"><?=$arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']['NAME']?></a>
                </li>
            <? } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']) { ?>
                <li class="nav-item">
                    <a class="nav-link <?=($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS'] ? '':'active')?> " data-toggle="tab" href="#facade_plans"><?=$arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']['NAME']?></a>
                </li>
            <? } ?>

        </ul>

        <div class="tab-content pb-3">

            <? if ($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']) { ?>
                <div class="tab-pane fade show active" id="house_plans">
                    <div class="image-line ">
                        <? foreach ($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']['VALUE'] as $key => $fileId) {
                            $img = CFile::ResizeImageGet($fileId, array('width'=>1500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 80);
                            ?>
                                <a href="<?=CFile::GetPath($fileId)?>" data-fancybox="house_plans">
                                    <img class="border rounded" src="<?=$img['src']?>" />
                                    <? if ($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']['DESCRIPTION'][$key]) echo '<div class="pt-2 weight-500">'.$arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS']['DESCRIPTION'][$key].'</div>'; ?>
                                </a>
                        <? } ?>
                    </div>
                </div>
            <? } ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']) { ?>
                <div class="tab-pane fade <?=($arResult['DISPLAY_PROPERTIES']['HOUSE_PLANS'] ? '':'show active')?>" id="facade_plans">
                    <div class="image-line ">
                        <? foreach ($arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']['VALUE'] as $key => $fileId) {
                            $img = CFile::ResizeImageGet($fileId, array('width'=>1500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 80);
                            ?>
                            <a href="<?=CFile::GetPath($fileId)?>" data-fancybox="facade_plans">
                                <img class="border rounded" src="<?=$img['src']?>" />
                                <? if ($arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']['DESCRIPTION'][$key]) echo '<div class="pt-2 weight-500">'.$arResult['DISPLAY_PROPERTIES']['FACADE_PLANS']['DESCRIPTION'][$key].'</div>'; ?>
                            </a>
                        <? } ?>
                    </div>
                </div>
            <? } ?>

        </div>

    </div>
<? } ?>

<? if ($arResult['DISPLAY_PROPERTIES']['ONLINE_VIDEO']) { ?>
	<div class="row">
            <div class="col-12 mt-5 mb-5">
                <h2 class="mb-4">Онлайн-трансляция строительства</h2>
                <div class="map-wrap">
                    <?=$arResult['DISPLAY_PROPERTIES']['ONLINE_VIDEO']['DISPLAY_VALUE']?>
                </div>
            </div>
	</div>
<? } ?>


<? if ($arResult['DISPLAY_PROPERTIES']['CONSTRUCTION_PHOTO']) { ?>
    <div class="my-5">
        <h2 class="mb-4">Строительство дома по проекту</h2>
        <div class="detail-slider">
            <? foreach ($arResult['DISPLAY_PROPERTIES']['CONSTRUCTION_PHOTO']['FILE_VALUE'] as $arPhotoItem) {
                $img = CFile::ResizeImageGet($arPhotoItem['ID'], array('width'=>736, 'height'=>414), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
                ?>
                <a class="detail-slider-item" href="<?=$arPhotoItem['SRC']?>" data-fancybox="construction_photo"><img class="" src="<?=$img['src']?>" /></a>
            <? } ?>
        </div>
    </div>
<? } ?>


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
			<div class="col-12">
				<p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
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
        <span class="gray">Свяжитесь с нами, по телефону</span> +7(495) 001-00-03 <span class="gray">или формой ниже, и мы с удовольствием обо всём расскажем.</span>
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
			<div class="col-12">
				<p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
		   </div>
        </form>
    </div>
</div>