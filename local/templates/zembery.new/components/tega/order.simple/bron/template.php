<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<div class="">
    <?
    if ($arResult["ORDER_SUCCESSFULLY_CREATED"] == "Y") {
        echo '<div class="alert alert-success" role="alert">'.GetMessage("ORDER_SUCCESSFULLY_CREATED").'</div>';
        return;
    }
    ?>

    <script type="text/javascript">
        function submitForm(val) {
            BX('<? echo $arParams["ENABLE_VALIDATION_INPUT_ID"]; ?>').value = (val !== 'Y') ? "N" : "Y";
            var orderForm = BX('<? echo $arParams["FORM_ID"]; ?>');
            BX.submit(orderForm);
            return true;
        }
    </script>

    <form method="post"
          id="<? echo $arParams["FORM_ID"]; ?>"
          name="<? echo $arParams["FORM_NAME"]; ?>"
          action="<? echo $arParams["FORM_ACTION"]; ?>">

        <h2 class="mb-4">Бронирование участка</h2>

        <?= bitrix_sessid_post() ?>

        <input type="hidden"
               name="<? echo $arParams["ENABLE_VALIDATION_INPUT_NAME"]; ?>"
               id="<? echo $arParams["ENABLE_VALIDATION_INPUT_ID"]; ?>"
               value="Y">

        <? if (is_array($arResult["ERRORS"]) && $arResult["HIDE_ERRORS"] != "Y") { ?>
            <? foreach ($arResult["ERRORS"] as $error) { ?>
                <div class="alert alert-danger" role="alert"><? echo $error; ?></div>
            <? } ?>
        <? } ?>

        <? if (!empty($arResult["ORDER_PROPS"])) { ?>
            <div class="form-row">
                <?
                foreach ($arResult["ORDER_PROPS"] as $arProp) { ?>
                    <div class="col-12  mb-3">
                        <input class="form-control form-control-lg"
                               type="text"
                               name="<?= $arParams["FORM_NAME"] ?>[<?= $arProp["CODE"] ?>]"
                               placeholder="<?= $arProp["NAME"] ?>"
                               value="<?= $arResult["CURRENT_VALUES"]["ORDER_PROPS"][$arProp["CODE"]]; ?>"
                        >
                    </div>
                <? } ?>
            </div>
        <? } ?>

        <? if (!empty($arResult["DELIVERY"])) {
            $arDelivery = reset($arResult["DELIVERY"]);
            ?>
            <input type="hidden" name="<?=$arParams["FORM_NAME"] ?>[DELIVERY]" value="<?= $arDelivery["ID"] ?>" />
        <? } ?>

        <? if ($arResult["PAY_SYSTEM"]) {
            $arPaySystem = reset($arResult["PAY_SYSTEM"]);
            ?>
            <input type="hidden" name="<?=$arParams["FORM_NAME"] ?>[PAY_SYSTEM]" value="<?= $arPaySystem["ID"] ?>" />
        <? } ?>


        <!-- textarea
                name="<? echo $arParams["FORM_NAME"] ?>[USER_COMMENT]"
                id="comment"
        ><? echo $arResult["CURRENT_VALUES"]["ORDER_PROPS"]["USER_COMMENT"]; ?></textarea -->


        <div class="strong mb-4">
            Итого к оплате:
            <?=$arResult["PRICES"]["TOTAL_PRICE_FORMATTED"]; ?>
        </div>

        <? if ($arParams['USER_CONSENT'] == 'Y' && $arParams["AJAX_MODE"] != "Y") {
            $APPLICATION->IncludeComponent(
                "bitrix:main.userconsent.request",
                "",
                array(
                    "ID" => $arParams["USER_CONSENT_ID"],
                    "IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
                    "AUTO_SAVE" => "N",
                    "IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
                    "INPUT_NAME" => "order_userconsent",
                    "INPUT_ID" => "order_userconsent",
                    "REPLACE" => array(
                        'button_caption' => "Согласие",
                        'fields' => $arResult['USER_CONSENT_FIELDS']
                    )
                )
            );
        } ?>

        <div class=" mb-3">
            <button class="btn btn-primary btn-lg btn-block" onclick="submitForm('Y'); return false;"><? echo GetMessage("SUBMIT_BUTTON"); ?></button>
        </div>

    </form>

</div>