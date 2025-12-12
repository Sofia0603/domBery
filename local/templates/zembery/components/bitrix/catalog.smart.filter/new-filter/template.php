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
$templateData = array(
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}

?>
<?php
//echo '<pre>';
//var_dump($arParams);
//echo '</pre>';
GLOBAL $USER;
$uri2 = $_SERVER['REQUEST_URI'];
$target2 = '/building/';

$isMainPage = $_SERVER['REQUEST_URI'] === '/'
  ?>
<?php
$uri = $_SERVER['REQUEST_URI'];
$target = '/catalog/';
?>
    <div class="smart-filter-new">
        <?php
        if(strncmp($uri, $target, strlen($target)) === 0 || strncmp($uri2, $target, strlen($target2)) === 0):
        ?>
            <ul class="smart-filter-new__top">
                <li class="smart-filter-new__top-item  <?=strncmp($uri, $target, strlen($target)) === 0 ? 'active-catalog' : ''?>">
                    <a href="/catalog/" class="smart-filter-new__top-item-link">Посёлки</a>
                </li>
                <li class="smart-filter-new__top-item <?=strncmp($uri, $target2, strlen($target2)) === 0 ? 'active-catalog' : ''?>">
                    <a href="/building/" class="smart-filter-new__top-item-link">Дома</a>
                </li>
            </ul>
        <?endif;?>
        <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smart-filter-new__body">
            <?foreach($arResult["HIDDEN"] as $arIte∂m):?>
                <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
            <?endforeach;?>
            <?php
            if(strncmp($uri, $target, strlen($target)) === 0 || $_SERVER['REQUEST_URI'] === '/'):
            ?>
            <div class="smart-filter-new__body-items  region">
            <span class="region-text">Районы</span>

                <ul class="smart-filter-new__body-items-list region-list">
                    <?php
                    foreach($arResult["ITEMS"] as $key=>$arItem)
                    {


                        if($arItem["NAME"] == 'Городской округ'){
                            ?>

                            <li onclick="smartFilter.click(this)" class="region-list-item active-item ">Все</li>
                            <?foreach($arItem["VALUES"] as $val => $ar):?>
                                <li onclick="smartFilter.click(this)"  class="region-list-item region-list-item-pref_<? echo $ar["CONTROL_ID"] ?>  <? echo $ar["DISABLED"] ? 'disabled': '' ?>  <? echo $ar["CHECKED"]? 'active-item': '' ?>"> <?=$ar["VALUE"];?>

                                    <input
                                            type="checkbox"
                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                            id="<? echo $ar["CONTROL_ID"]?>"
                                           hidden="hidden"
                                            class="region-list-item-checkbox"
                                        <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                        <? echo $ar["DISABLED"] ? 'disabled': '' ?>

                                    />
                                </li>
                            <?endforeach;?>
                        <?}?>
                    <?}?>
                </ul>
                <div class="region-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="6" viewBox="0 0 9 6" fill="none">
                        <path d="M1 0.5L4.5 4.5L8 0.5" stroke="#434343" stroke-linecap="round"></path>
                    </svg>
                </div>
            </div>
            <?endif;?>
            <div class="smart-filter-new__body-box box-content">
                <?php
                $limit = 4;
                $count = 0;

                foreach($arResult["ITEMS"] as $key=>$arItem)
                {
                    if ($count < $limit) {
                        if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
                        continue;

                    if ($arItem["DISPLAY_TYPE"] == "A" && ( $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
                        continue;

                                $arCur = current($arItem["VALUES"]);
                                switch ($arItem["DISPLAY_TYPE"])
                                {
                                    //region NUMBERS_WITH_SLIDER +
                                case "A": ?>
                    <div class="box-content__item">
                        <?php
                        $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                        $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
                        $minV = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
                        $maxV = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");

                        ?>
                            <label for="shosse" class="box-content__item-text"><?=$arItem["NAME"]?></label>
                            <div class="box-content__item-inner">
                                <div class="box-content__item-inner-setting">
                                    <label for="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"><?=GetMessage("CT_BCSF_FILTER_FROM")?></label>
                                    <input
                                            class="box-content__item-inner-setting-input <?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                            type="number"
                                            name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                            id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                            value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]  ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $minV?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)">
                                </div>
                                <div class="box-content__item-inner-setting">
                                    <label for="arrFilter_11_MAX"><?=GetMessage("CT_BCSF_FILTER_TO")?></label>
                                    <input
                                            class="box-content__item-inner-setting-input <?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                            type="number"
                                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                            id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                            value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]  ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $maxV?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)">
                                </div>
                            </div>

                            <div class="box-content__item-track" id="drag_track_<?=$key?>">
                                <div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
                                <div class="smart-filter-slider-price-bar-vn" style="left: 0%; right: 0%;" id="colorAvailableInactive_<?=$key?>"></div>
                                <div class="smart-filter-slider-price-bar-v" style="left: 0%; right: 0%;" id="colorAvailableActive_<?=$key?>"></div>
                                <div class="smart-filter-slider-range" id="drag_tracker_<?=$key?>" style="left: 0;right: 0;">
                                    <a class="box-content__item-track-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
                                    <a class="box-content__item-track-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
                                </div>
                            </div>
                    </div>
                                <?
                                $arJsParams = array(
                                    "leftSlider" => 'left_slider_'.$key,
                                    "rightSlider" => 'right_slider_'.$key,
                                    "tracker" => "drag_tracker_".$key,
                                    "trackerWrap" => "drag_track_".$key,
                                    "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                                    "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                                    "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                                    "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                                    "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                    "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                    "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                                    "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                                    "precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
                                    "colorUnavailableActive" => 'colorUnavailableActive_'.$key,
                                    "colorAvailableActive" => 'colorAvailableActive_'.$key,
                                    "colorAvailableInactive" => 'colorAvailableInactive_'.$key,
                                );
                                ?>
                                    <script type="text/javascript">
                                        BX.ready(function(){
                                            window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                        });
                                    </script>
                                 <?

                                break;
                                 case "P": ?>
                                 <? $checkedItemExist = false; ?>
                                <?php

                                 ?>


                                    <div class="box-content__item">


                                        <label for="shosse" class="box-content__item-text"><?=$arItem["NAME"]?></label>
                                        <input type="text"class="box-content__item-input <?=$arItem['CODE']?>"
                                               value="Все"
                                        >
                                        <div class="box-content__item-arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="6" viewBox="0 0 9 6" fill="none">
                                                <path d="M1 0.5L4.5 4.5L8 0.5" stroke="#434343" stroke-linecap="round"/>
                                            </svg>
                                        </div>

                                        <ul class="box-content__item-dropdown">
                                    <?foreach($arItem["VALUES"] as $val => $ar):?>
                                            <li  onclick="smartFilter.click(this)" class="box-content__item-dropdown-item region-list-item-pref_<? echo $ar["CONTROL_ID"] ?>  <? echo $ar["DISABLED"] ? 'disabled': '' ?>  <? echo $ar["CHECKED"] ? 'active-filter-item': '' ?>"> <?=$ar["VALUE"];?>
                                                <input
                                                        type="checkbox"
                                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                                        hidden
                                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                                        class="box-content__item-dropdown-item-checkbox"
                                                        <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                        <? echo $ar["DISABLED"] ? 'disabled': '' ?>

                                                />
                                            </li>

                                    <?endforeach;?>
                                        </ul>
                                    </div>
                            <?break;?>

                                <?}?>

                    <?
}
                    $count++;

                }
                ?>

            </div>
            <a  class="smart-filter-new__body-clear" href="<?=$arResult['SEF_DEL_FILTER_URL']?>">Сбросить фильтры</a>
            <div class="smart-filter-new__body-bottom">
                <button type="submit" class="smart-filter-new__body-bottom-all">
                    <img loading="lazy" src="/images/filter-icon.png" alt="filter-icon">
                    Все фильтры
                </button>
                <?php
                if(strncmp($uri, $target, strlen($target)) === 0 || $_SERVER['REQUEST_URI'] === '/'):
                ?>
                <a href="/catalog-map/" onclick="#" class="smart-filter-new__body-bottom-watch">
                    <img loading="lazy" src="/images/map-icon.png" alt="map-icon">
                    Смотреть на карте
                </a>
            <?endif;?>
                <input id="set_filter"
                        name="set_filter"
                        value="Найти"
                        type="submit" class="smart-filter-new__body-bottom-search">
                <div class="smart-filter-popup-result <?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
                    <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                    <a href="<?echo $arResult["FILTER_URL"]?>" target=""></a>
                </div>
            </div>
            <div class="smart-filter-dark-background"></div>
            <div class="smart-filter-right">
                <div>
                    <div class="smart-filter-right__top">
                        <h3 class="smart-filter-right__top-title">Все параметры фильтров</h3>
                        <button type="submit" class="smart-filter-right__top-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="37" height="38" viewBox="0 0 37 38" fill="none">
                                <circle cx="18.7229" cy="19" r="18.2771" fill="#D9D9D9"/>
                                <path d="M12 12L25.967 25.967" stroke="#666667" stroke-width="1.87457" stroke-linecap="round"/>
                                <path d="M26 12L12.033 25.967" stroke="#666667" stroke-width="1.87457" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                    <?php
                    if(strncmp($uri, $target, strlen($target)) === 0 || $_SERVER['REQUEST_URI'] === '/'):
                    ?>
                    <div class="smart-filter-right__items region">
                        <span class="region-text">Районы</span>

                        <ul class="smart-filter-right__items-list  region-list">



                            <li onclick="smartFilter.click(this)" class="region-list-item active-item">Все</li>
                            <?php
                            foreach($arResult["ITEMS"] as $key=>$arItem) :
                                foreach($arItem["VALUES"] as $val => $ar):
                                    if($arItem["NAME"] === 'Городской округ'){
                                        ?>
                                        <li  onclick="smartFilter.click(this)"  class="region-list-item region-list-item-pref_<? echo $ar["CONTROL_ID"] ?>  <? echo $ar["DISABLED"] ? 'disabled': '' ?>  <? echo $ar["CHECKED"]? 'active-item': '' ?>">
                                            <? echo $ar["VALUE"];?>
                                            <input
                                                    type="checkbox"
                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                    hidden="hidden"
                                                    class="region-list-item-checkbox"
                                                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                <? echo $ar["DISABLED"] ? 'disabled': '' ?>
                                            />

                                        </li>
                                    <? }?>
                                <?endforeach;?>
                            <?endforeach;?>
                        </ul>

                    </div>
                    <?endif;?>
                    <div  class="smart-filter-right__content">
                        <?foreach($arResult["HIDDEN"] as $arItem):?>
                            <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
                        <?endforeach;?>
                        <div class="smart-filter-right__content-blocks box-content">
                            <?php
                            foreach($arResult["ITEMS"] as $key=>$arItem)
                            {
                                if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
                                    continue;

                                if ($arItem["DISPLAY_TYPE"] == "A" && ( $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
                                    continue;

                                $arCur = current($arItem["VALUES"]);
                                switch ($arItem["DISPLAY_TYPE"])
                                {
                                    //region NUMBERS_WITH_SLIDER +
                                    case "A": ?>
                                        <div class="box-content__item">
                                            <?php
                                            $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                                            $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
                                            $minV = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
                                            $maxV = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");

                                            ?>
                                            <label for="shosse" class="box-content__item-text"><?=$arItem["NAME"]?></label>
                                            <div class="box-content__item-inner">
                                                <div class="box-content__item-inner-setting">
                                                    <label for="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"><?=GetMessage("CT_BCSF_FILTER_FROM")?></label>
                                                    <input
                                                            class="box-content__item-inner-setting-input <?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                            type="number"
                                                            name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                            id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>_2"
                                                            value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]  ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $minV?>"
                                                            size="5"
                                                            onkeyup="smartFilter.keyup(this)">
                                                </div>
                                                <div class="box-content__item-inner-setting">
                                                    <label for="arrFilter_11_MAX"><?=GetMessage("CT_BCSF_FILTER_TO")?></label>
                                                    <input
                                                            class="box-content__item-inner-setting-input <?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                            type="number"
                                                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                            id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>_2"
                                                            value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]  ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $maxV?>"
                                                            size="5"
                                                            onkeyup="smartFilter.keyup(this)">
                                                </div>
                                            </div>

                                            <div class="box-content__item-track" id="drag_track_<?=$key?>_2">
                                                <div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>_2"></div>
                                                <div class="smart-filter-slider-price-bar-vn" style="left: 0%; right: 0%;" id="colorAvailableInactive_<?=$key?>_2"></div>
                                                <div class="smart-filter-slider-price-bar-v" style="left: 0%; right: 0%;" id="colorAvailableActive_<?=$key?>_2"></div>
                                                <div class="smart-filter-slider-range" id="drag_tracker_<?=$key?>_2" style="left: 0;right: 0;">
                                                    <a class="box-content__item-track-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>_2"></a>
                                                    <a class="box-content__item-track-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>_2"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                        $arJsParams = array(
                                            "leftSlider" => 'left_slider_'.$key.'_2',
                                            "rightSlider" => 'right_slider_'.$key.'_2',
                                            "tracker" => "drag_tracker_".$key.'_2',
                                            "trackerWrap" => "drag_track_".$key.'_2',
                                            "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"]."_2",
                                            "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"]."_2",
                                            "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                                            "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                                            "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                            "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                            "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                                            "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                                            "precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
                                            "colorUnavailableActive" => 'colorUnavailableActive_'.$key.'_2',
                                            "colorAvailableActive" => 'colorAvailableActive_'.$key.'_2',
                                            "colorAvailableInactive" => 'colorAvailableInactive_'.$key.'_2',
                                        );
                                        ?>
                                    <script type="text/javascript">
                                        BX.ready(function(){
                                            window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                        });
                                    </script>
                                        <?break;?>
                                    <?case "P":?>
                                    <? $checkedItemExist = false; ?>

                                    <div class="box-content__item">


                                        <label for="shosse" class="box-content__item-text"><?=$arItem["NAME"]?></label>
                                        <input type="text" class="box-content__item-input  <?=$arItem['CODE']?>"
                                               value="Все"

                                        >
                                        <div class="box-content__item-arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="6" viewBox="0 0 9 6" fill="none">
                                                <path d="M1 0.5L4.5 4.5L8 0.5" stroke="#434343" stroke-linecap="round"/>
                                            </svg>
                                        </div>

                                        <ul class="box-content__item-dropdown">
                                            <?foreach($arItem["VALUES"] as $val => $ar):?>
                                                <li  onclick="smartFilter.click(this)" class="box-content__item-dropdown-item region-list-item-pref_<? echo $ar["CONTROL_ID"] ?>  <? echo $ar["DISABLED"] ? 'disabled': '' ?>  <? echo $ar["DISABLED"] ? 'disabled': '' ?>  <? echo $ar["CHECKED"] ? 'active-filter-item': '' ?>"> <?=$ar["VALUE"];?>
                                                    <input
                                                            type="checkbox"
                                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            hidden
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                            class="box-content__item-dropdown-item-checkbox"
                                                        <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                        <? echo $ar["DISABLED"] ? 'disabled': '' ?>

                                                    />
                                                </li>

                                            <?endforeach;?>
                                        </ul>
                                    </div>

                                    <?
                                    break;
                                    ?>
                                <?php
//
                                }?>
                                <?

                            } ?>
                        </div>
                        <div class="smart-filter-right__content-info">
                            <?php
                            //
                            foreach($arResult["ITEMS"] as $key=>$arItem)
                            {
                                if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
                                    continue;

                                if ($arItem["DISPLAY_TYPE"] == "A" && ( $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
                                    continue;

                                $arCur = current($arItem["VALUES"]);

                                switch ($arItem["DISPLAY_TYPE"])
                                {
                                    //region NUMBERS_WITH_SLIDER +
                                    case 'F':

                                        if($arItem["NAME"] !== 'Городской округ'){
                                            ?>

                                            <div class="smart-filter-right__content-item">
                                                <span class="smart-filter-right__content-item-text"><?=$arItem["NAME"]?></span>
                                                <div class="smart-filter-right__content-item-checkboxes">



                                                    <?foreach($arItem["VALUES"] as $val => $ar):?>
                                                        <div class="smart-filter-right__content-checkboxes-body">
                                                            <input onclick="smartFilter.click(this)" type="checkbox"  <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> class="smart-filter-right__content-checkboxes-body-inner region-list-item-pref_<? echo $ar["CONTROL_ID"] ?>  <? echo $ar["DISABLED"] ? 'disabled': '' ?>" id="<? echo $ar["CONTROL_ID"] ?>" name="<? echo $ar["CONTROL_NAME"] ?>" value="<? echo $ar["HTML_VALUE"] ?>">
                                                            <label for="<? echo $ar["CONTROL_ID"] ?>">
                                                                <?= preg_replace('/\s*\(.*?\)/', '', $ar["VALUE"]); ?>
                                                            </label>
                                                        </div>
                                                    <?endforeach;?>


                                                </div>

                                            </div>
                                        <? }?>
                                        <? break; }}?>

                            <button class="smart-filter-right__content-info-show-all">
                                Показать все
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="6" viewBox="0 0 9 6" fill="none">
                                    <path d="M1 1L4.5 5L8 1" stroke="#434343" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="smart-filter-right__bottom">
                    <a class="smart-filter-right__bottom-reset" href="<?=$arResult['SEF_DEL_FILTER_URL']?>">Сбросить все</a>
                    <input id="set_filter2"
                           name="set_filter"
                           value="Найти"
                           type="submit" class="smart-filter-right__bottom-search">
                </div>
            </div>
        </form>
    </div>




<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>

<div class="row gx-2 mb-4">
    <? foreach ($arResult['ITEMS'] as $arItem) {
        switch ($arItem['PROPERTY_TYPE']) {
            case 'L' :
                $arCheckedList = [];
                foreach ($arItem['VALUES'] as $arListValue) {
                    if ($arListValue['CHECKED']) {
                        // Убираем текст в скобках
                        $arCheckedList[] = preg_replace('/\s*\(.*?\)\s*/', '', $arListValue['VALUE']);
                    }
                }
                if ($arCheckedList) {
                    ?>
                    <div class="col-auto">
                        <button class="btn btn-lightgray btn-clear-filter" data-group-id="<?=$arItem['ID']?>" >
                            <?=$arItem['NAME']?>: <?=implode(', ', $arCheckedList)?>
                        </button>
                    </div>
                    <?
                }
                break;
            case 'N' :
                if ($arItem['VALUES']['MIN']['HTML_VALUE'] || $arItem['VALUES']['MAX']['HTML_VALUE']) {
                    ?>
                    <div class="col-auto">
                        <button class="btn btn-lightgray btn-clear-filter" data-group-id="<?=$arItem['ID']?>" >
                            <?=$arItem['NAME']?>:
                            <?=
                            preg_replace('/\s*\(.*?\)\s*/', '',
                                $arItem['VALUES']['MIN']['HTML_VALUE'] ?: '<span class="gray">'.$arItem['VALUES']['MIN']['VALUE'].'</span>'
                            )
                            ?>
                            &nbsp;-&nbsp;
                            <?=
                            preg_replace('/\s*\(.*?\)\s*/', '',
                                $arItem['VALUES']['MAX']['HTML_VALUE'] ?: '<span class="gray">'.$arItem['VALUES']['MAX']['VALUE'].'</span>'
                            )
                            ?>
                        </button>
                    </div>
                    <?
                }
                break;
        }
    } ?>

</div>

<div style="display: none;">
    <a href="<?=$arResult['SEF_DEL_FILTER_URL']?>">Очистить фильтр</a><br>
    <?
    // дебилизм для дебилов сеошников
    $sef_prefix = str_replace( 'clear/apply/', '', $arResult['SEF_DEL_FILTER_URL']);
    foreach ($arResult['ITEMS'] as $arItem) {
        switch ($arItem['PROPERTY_TYPE']) {
            case 'L' :
                foreach ($arItem['VALUES'] as $arListValue) {
                    echo '<a href="'.$sef_prefix.mb_strtolower($arItem['CODE']).'-is-'.$arListValue['URL_ID'].'/apply/" >'.$arListValue['VALUE'].'</a><br>';
                }
                break;
        }
    } ?>
</div>
