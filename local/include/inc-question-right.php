<div class="gray-bg p-4 rounded-lg">
    <img class="mb-2" src="/images/ico-question-green.svg" />
    <h2>
        Остались вопросы?
    </h2>

    <div class="gray mb-3">
        Квалифицированные сотрудники отвечали на все мои вопросы, дружелюбно рассказывали о плюсах и минусах разных посёлков
    </div>

    <a class="btn btn-lg btn-primary btn-block" href="#question" data-fancybox >Написать</a>
</div>

<div id="question" class="popup" style="display: none;">
    <h2 class="mb-4">
        Остались вопросы?
    </h2>
    <form class="form-ajax row gx-2">
        <input type="hidden" name="form_name" value="Остались вопросы">

        <div class="col-12 col-sm-6   mb-3">
            <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
        </div>
        <div class="col-12 col-sm-6 mb-3">
            <input class="form-control form-control-lg " type="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="col-12 mb-3">
            <textarea class="form-control form-control-lg " name="message" placeholder="Текст вопроса" required rows="5"></textarea>
        </div>

        <? /* <div class="col-12 input-group mb-3">
            <input class="captchaSid" type="hidden" name="captcha_sid" value=""/>
            <div class="input-group-prepend border">
                <img class="jsReloadCaptcha captchaImg" alt="CAPTCHA"/>
            </div>

            <input class="form-control form-control-lg" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите код с картинки" required />
        </div> */ ?><input type="hidden" name="woc" value="1">

        <div class="col-12">
        	<p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
        </div>
        <div class="col-12  mb-3">
            <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Отправить">
        </div>
    </form>
</div>