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
header('Content-Type: text/html; charset=utf-8');
$img = CFile::ResizeImageGet( $arResult['FIELDS']['DETAIL_PICTURE']['ID'] ? $arResult['FIELDS']['DETAIL_PICTURE']['ID'] : $arResult['FIELDS']['PREVIEW_PICTURE']['ID'], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 90);
?>
<div class="news-detail">

    <div class="row mb-4">
        <div class="col-12 col-lg-8">
            <? if ($arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']) { ?>
                <div class="mb-3">
                    <?=$arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE']?>
                </div>
            <? } ?>

            <h1 class="mb-4"><?=$arResult['NAME']?></h1>

            <? if ($arResult['FIELDS']['DATE_ACTIVE_FROM']) { ?>
                <div class="gray "><?=reset(explode(' ', $arResult['FIELDS']['DATE_ACTIVE_FROM']))?></div>
            <? } ?>
        </div>


    </div>

    <div class="row mb-4">
        <div class="col-12 col-lg-8 article">
            <? if ($img) { ?>
                <a  href="<?=$img['src']?>" data-fancybox="detail">
                    <img class="d-block mx-auto mw-100 mb-4 rounded" src="<?=$img['src']?>" />
                </a>

            <? } ?>

            <?php
            if(!empty( $arResult['FIELDS']['DETAIL_TEXT'])) {
                echo $arResult['FIELDS']['DETAIL_TEXT'];
            } else {?>
                <?= htmlspecialchars_decode($arResult['PROPERTIES']['TEXT_INFO']['VALUE'][0]['TEXT']); ?>
                <?=     getSlider('SLIDER_INFO_1', $arResult); ?>
                <?= htmlspecialchars_decode($arResult['PROPERTIES']['TEXT_INFO']['VALUE'][1]['TEXT']); ?>
                <?=     getSlider('SLIDER_INFO_2', $arResult); ?>
                <?= htmlspecialchars_decode($arResult['PROPERTIES']['TEXT_INFO']['VALUE'][2]['TEXT']); ?>
                <?=     getSlider('SLIDER_INFO_3', $arResult); ?>
                <?= htmlspecialchars_decode($arResult['PROPERTIES']['TEXT_INFO']['VALUE'][3]['TEXT']); ?>
            <?}


            ?>

            <? if ($arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']) { ?>
                <div class="font-16 mt-3" >
                    Подробнее о поселке: <?=$arResult['DISPLAY_PROPERTIES']['LNK_TOWNSHIP']['DISPLAY_VALUE_UNDERLINE']?>.
                </div>
            <? } ?>
        </div>













        <div class="col-12 col-lg-4">
            <?$APPLICATION->IncludeFile('/local/include/inc-subscribe-right.php', array(), array('SHOW_BORDER'=>false, 'MODE' => "html"))?>
        </div>
    </div>
    <style>
        .news-slider-n {
            margin: 0 !important;
        }
        .slider-controll .slick-slide {
            width: 150px !important;
            height: 150px !important;
            cursor:pointer !important;
            border:2px solid transparent !important;
        }

        .slider-controll .slick-slide img {
            width: 100%;
            height: 100%;
            object-fit:cover;
            display: block;

        }

        .slider-controll .slick-slide.slick-current {
            border-color: skyblue;
        }
        .news-slider-n .slick-prev.slick-arrow {
            left: -16px;
        }
    </style>
    <?php

    function getSlider($slider, $arResult)
    {
        $itemStyle = '';
        $wrapStyle = 'detail-slider';
        ?>
        <div  class=" <?=$wrapStyle?>">
            <?php foreach ($arResult["PROPERTIES"][$slider]["VALUE"] as $key => $arItem):
                $img = CFile::ResizeImageGet($arItem, ['width' => 836, 'height' => 495], BX_RESIZE_IMAGE_EXACT, false, false, false, 80);
                ?>

                        <?php if ($img) { ?>
                            <a  href="<?=$img['src']?>" data-fancybox="detail" class="detail-slider-item">
                                <img style="border-radius: 16px" class="mw-100" src="<?=$img['src']?>" alt="Image <?=$key?>" />
                            </a>
                        <?php } ?>

            <?php endforeach; ?>


        </div>
        <?php
    }
    ?>


</div>

