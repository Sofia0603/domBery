<div class="gray-bg p-4 p-lg-5 rounded-lg">
    <div class="row align-items-center justify-content-between">
        <div class="col-12 col-md-8 col-lg-9 col-xl-8">
            <img class="mb-2" src="/images/ico-send_mail.svg" />
            <h2>
                Подпишитесь и получите больше предложений
            </h2>

            <div class="gray mb-3 mb-md-0">
                Квалифицированные сотрудники отвечали на все мои вопросы, дружелюбно рассказывали о плюсах и минусах разных посёлков
            </div>
        </div>

        <div class="col-12 col-md-4 col-lg-3 col-xl-3">
            <a class="btn btn-lg btn-primary btn-block" href="#subscribe" data-fancybox >Подписаться</a>
        </div>
    </div>
</div>

<div id="subscribe" class="popup-mini" style="display: none;">
    <h2 class="mb-4">
        Подпишитесь и получите
        больше предложений
    </h2>
    <form class="form-ajax row gx-2">
        <input type="hidden" name="form_name" value="Подписка на спецпредложения">

        <div class="col-12  mb-3">
            <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
        </div>
        <div class="col-12  mb-3">
            <input class="form-control form-control-lg " type="email" name="email" placeholder="E-mail" required>
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