<div class="mt-3 py-2 row">
    <div class="col-12 col-lg-12 mb-1">
        <h2 class="mb-4">Продажа участков земли в Подмосковье по направлениям</h2>
        <div class="">
            <!-- <div class="font-18 weight-500 mb-3">Поселки на популярных шоссе</div> -->
            <div class="row gx-2 mb-4">
                <div class="col-auto mb-3">
                    <a class="btn btn-light" href="/catalog/filter/shosse-is-kashirskoye/apply/">Каширское</a>
                </div>
                <div class="col-auto mb-3">
                    <a class="btn btn-light" href="/catalog/filter/shosse-is-novorizhskoe/apply/">Новорижское</a>
                </div>
                <div class="col-auto mb-3">
                    <a class="btn btn-light" href="/catalog/filter/shosse-is-ryazanskoe/apply/">Рязанское</a>
                </div>
                <div class="col-auto mb-3">
                    <a class="btn btn-light" href="/catalog/filter/shosse-is-simfiropolskoe/apply/">Симферопольское</a>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 col-lg-12 mb-5">
        <h2 class="mb-4">Поселки на карте</h2>
        <div class="map-wrap border">
            <?$APPLICATION->IncludeComponent(
                "bitrix:map.yandex.view",
                "shops_on_map",
                array(
                    "INIT_MAP_TYPE" => "MAP",
                    "MAP_DATA" => "a:3:{s:10:\"yandex_lat\";d:55.75999999998768;s:10:\"yandex_lon\";d:37.63999999999997;s:12:\"yandex_scale\";i:8;}",
                    "MAP_WIDTH" => "100%",
                    "MAP_HEIGHT" => "500",
                    "CONTROLS" => array(
                        0 => "ZOOM",
                        1 => "SMALLZOOM",
                        //2 => "MINIMAP",
                        3 => "TYPECONTROL",
                        4 => "SCALELINE",
                    ),
                    "OPTIONS" => array(
                        0 => "ENABLE_DBLCLICK_ZOOM",
                        1 => "ENABLE_DRAGGING",
                    ),
                    "MAP_ID" => "yam_1",
                    "COMPONENT_TEMPLATE" => "shops_on_map",
                    "API_KEY" => ""
                ),
                false
            );?>
        </div>
    </div>
</div>