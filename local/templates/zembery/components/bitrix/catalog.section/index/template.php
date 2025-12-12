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

//$this->addExternalJS("https://zembery.ru/local/templates/zembery/components/bitrix/catalog.smart.filter/index-page/script.js");
?>


<div>
    <div class="sale__block" data-view="list">
        <section class="elements" data-navnum="<?=$arResult['NAV_RESULT']->NavNum;?>">
            <? foreach ($arResult['ITEMS'] as $key => $arItem) { ?>
                <?
                $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>494, 'height'=>370), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);
                $isAllSold = $arItem['DISPLAY_PROPERTIES']['ALL_SOLD']['VALUE'];
                ?>
                <div class="element" id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=$arItem['DETAIL_PAGE_URL'] ?>">
                    <a class="" href="<?=$arItem['DETAIL_PAGE_URL'] ?>">
                        <div>
                            <img class="element__image" src="<?=$img['src']?>" />
                            <? if ($arItem['DISPLAY_PROPERTIES']['LABEL']) {
                                echo '<div class="element__start catalog-allsold-label" style="background: #'.$arItem['DISPLAY_PROPERTIES']['LABEL_COLOR']['VALUE_XML_ID'].'">'.$arItem['DISPLAY_PROPERTIES']['LABEL']['DISPLAY_VALUE'].'</div>';
                                /*<img class="" src="<?=SITE_TEMPLATE_PATH?>/image/Start.svg" alt="Старт продаж" />
                                <button class="element__purpose" disabled><?=$arItem['DISPLAY_PROPERTIES']['LABEL']['VALUE'] ?></button>*/
                            } ?>
							<? if ($arItem['DISPLAY_PROPERTIES']['PURPOSE']) { ?>
								<button class="element__purpose" disabled><?=$arItem['DISPLAY_PROPERTIES']['PURPOSE']['VALUE'] ?></button>
                            <? } ?>
                            <!-- <a class="element__icon" href="#"><img src="<?=SITE_TEMPLATE_PATH?>/image/IconStart.svg" alt="Иконка" /></a> -->
                        </div>
                        <div>
                            <h4 class="element__title"><?=$arItem['NAME']?></h4>
                            <? if ($arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']) { ?>
                                <p class="element__subtitle"><?=$arItem['DISPLAY_PROPERTIES']['ONE_LINE_PROP']['DISPLAY_VALUE']?></p>
                            <? } ?>
                        </div>
                        <div class="element__sale">
                            <p class="element__paragraph">Цена за сотку:</p>
                            <? if ($arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) { ?>
                                <p class="element__paragraph-price">от <?=$arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE']?></p>
                            <? } ?>
                        </div>

							<? if ($arItem['DISPLAY_PROPERTIES']['PURPOSE']) { ?>
								<div class="element__sale">
									<p class="element__paragraph">Назначение:</p>
									<button class="element__purpose-bottom" disabled>Промышленная</button>
								</div>
							<? } else { ?>
        						<div class="element__sale" style="height: 40px;"></div>
                            <? } ?>

                        <a class="element__button" href="<?=$arItem['DETAIL_PAGE_URL'] ?>">Подробнее</a>
                    </a>
                </div>
            <? } ?>
        </section>
        <a href="/catalog/" class="btn btn-block sale__button">Показать все</a>
    </div>
    <div class="sale__block" data-view="map">
        <h2 class="sale__title mt-2">Посёлки на карте</h2>
        <?$APPLICATION->IncludeFile('/local/include/new/inc-index-map.php', array(), array('SHOW_BORDER'=>true, 'MODE' => "html"))?>
    </div>
</div>

