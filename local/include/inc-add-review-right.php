<?
global $APPLICATION;
$arTownship = array();
CModule::IncludeModule("iblock");
$res = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), array("IBLOCK_ID" => 1, "ACTIVE" => "Y"), false, false, array("ID", "NAME"));
while($arFields = $res->GetNext()) $arTownship[ $arFields['ID'] ] = $arFields['NAME'];

?>
<div class="gray-bg p-4 rounded-lg">
    <img class="mb-2" src="/images/ico-edit_chat_history.svg" />
    <h2>
        Оставьте свой отзыв
    </h2>

    <div class="gray mb-3">
        Квалифицированные сотрудники отвечали на все мои вопросы, дружелюбно рассказывали о плюсах и минусах разных посёлков
    </div>

    <a class="btn btn-lg btn-primary btn-block" href="#addreview" data-fancybox >Написать</a>
</div>

<div id="addreview" class="popup" style="display: none;">
    <h2 class="mb-4">
        Оставьте свой отзыв
    </h2>
    <form action="/local/include/ajax-review.php" class="form-ajax row gx-2">
        <input type="hidden" name="form_name" value="Оставьте свой отзыв">
        <div class="col-12 col-sm-6   mb-3">
            <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
        </div>

        <div class="col-12 col-sm-6 mb-3">
            <input class="form-control form-control-lg " type="email" name="email" placeholder="E-mail" required>
        </div>

        <div class="col-12 mb-3">
            <select class="custom-select form-control form-control-lg" name="township">
                <option value="" selected disabled>Выбрать поселок</option>
                <? foreach ($arTownship as $id => $name) { ?>
                    <option value="<?=$id?>"><?=$name?></option>
                <? } ?>
            </select>
        </div>

        <div class="col-12 mb-3">
            <textarea class="form-control form-control-lg " name="message" placeholder="Текст отзыва" required rows="5"></textarea>
        </div>

        <? /* <input class="captchaSid" type="hidden" name="captcha_sid" value=""/>
        <div class="col-12 input-group mb-4">
            <div class="input-group-prepend border">
                <img class="jsReloadCaptcha captchaImg" alt="CAPTCHA"/>
            </div>

            <input class="form-control form-control-lg" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите код с картинки" required />
        </div> */ ?><input type="hidden" name="woc" value="1">

        <div class="col-12 mb-3">
            <?$APPLICATION->IncludeComponent(
                    "bitrix:main.file.input",
                    "drag_n_drop",
                array(
                    "INPUT_NAME"=>"IMAGE",
                    "MULTIPLE"=>"N",
                    "MODULE_ID"=>"iblock",
                    //"MAX_FILE_SIZE"=>"",
                    "ALLOW_UPLOAD"=>"I",
                ),
                false
            );?>
        </div>
<div class="col-12">
        <p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
       </div>
        <div class="col-12  mb-3">
            <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Отправить">
        </div>
    </form>
</div>