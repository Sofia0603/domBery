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

<div id="map" style="width: 100%; height: 600px;"></div>

<script type="text/javascript">
    let isMapNotView = true;

    $(document).ready(function (){
        $(window).on('scroll', function(){
            if(isMapNotView && $(this).scrollTop() >= 100) {
                isMapNotView = false;

                ymaps.ready(init);
                function init() {
                    var myMap = new ymaps.Map("map", {
                        center: [55.759999999988, 37.64],
                        zoom: 8
                    }, {
                        //searchControlProvider: 'yandex#search'
                    });

                    <? foreach ($arResult['ITEMS'] as $key => $arItem) {
                        if (empty($arItem['PROPERTIES']['GEOPOINT']['VALUE'])) continue;
                        $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>200, 'height'=>180), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 80);
                        $arTmp = explode(',', $arItem['PROPERTIES']['GEOPOINT']['VALUE']);
                        $text = '<div class="map-label">';
                        $text .= '<img src="'.$img['src'].'" class="d-block mb-2" />';
                        $text .= '<a class="blue d-block strong font-16  stretched-link" href="'.$arItem['DETAIL_PAGE_URL'].'" >' .$arItem['NAME'].'&nbsp;<i class="fal fa-external-link"></i></a>';
                        if ($arItem['DISPLAY_PROPERTIES']['SHOSSE']) $text .= '<div class="mb-1 green">ш.&nbsp;'.$arItem['DISPLAY_PROPERTIES']['SHOSSE']['DISPLAY_VALUE'].'</div>';
                        if ($arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']) $text .= '<div class="font-18 pink strong">от '.$arItem['DISPLAY_PROPERTIES']['PRICE_PER_SQUARE']['DISPLAY_VALUE'].'₽ за сотку</div>';
                        $text .= '</div>';

                        ?>
                        var myPlacemark<?=$key?> = new ymaps.Placemark(
                            [<?=$arTmp[0]?>, <?=$arTmp[1]?>],
                            {
                                balloonContent: '<?=$text?>',
                                hintContent: '<?=$text?>',
                                iconContent: '<?=$arItem['NAME']?>'
                            }, {
                                preset: 'islands#blueStretchyIcon'
                            });
                        myMap.geoObjects.add(myPlacemark<?=$key?>);

                    <? } ?>

                }
            }
        });
    });
</script>


