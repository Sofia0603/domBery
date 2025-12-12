<!--Ипотечный калькулятор-->
<section id="zembery-calculator-section">
    <div class="container">
        <div class="row align-items-stretch">
            <div class="col-12 col-lg-12 col-xl-7 col-xxl-7">
                <div class="p-4 p-lg-5 zembery-calculator" >
                    <h3 class="mb-4 ">Калькулятор расчета</h3>

                    <ul class="nav nav-underline mb-4" role="tablist" id="calc-switch">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="#calc-ipoteka" data-bs-toggle="pill" aria-selected="true">Ипотека</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#calc-rassrocka" data-bs-toggle="pill" aria-selected="false">Рассрочка</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane overflow-hidden active" id="calc-ipoteka" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                            <div  class="row align-items-stretch mb-4">
                                <input type="hidden" name="form_name" value="Заявка на ипотеку">
                                <input type="hidden" name="name" value="Ипотека">
                                <div class="col-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7 mb-4 mb-md-0">

                                    <div class="form-group">
                                        <label for="object-price">Стоимость недвижимости</label>
                                        <div class="range-output">
                                            <input name="object-price-output" class="money text-input" id="object-price-output">
                                            <input type="hidden" id="object-price-hidden">
                                        </div>
                                        <input type="range" list="object-price-tickmarks" min="500000" max="10000000" value="6000000" class="form-control-range" id="object-price">

                                        <div class="datalist" id="object-price-tickmarks">
                                            <option value="500000" label="500 тыс.">
                                            <option value="1000000">
                                            <option value="1500000">
                                            <option value="2000000">
                                            <option value="2500000">
                                            <option value="3000000">
                                            <option value="3500000">
                                            <option value="4000000">
                                            <option value="4500000">
                                            <option value="5000000">
                                            <option value="5500000">
                                            <option value="6000000">
                                            <option value="6500000">
                                            <option value="7000000">
                                            <option value="7500000">
                                            <option value="8000000">
                                            <option value="8500000">
                                            <option value="9000000">
                                            <option value="9500000">
                                            <option value="10000000" label="10 млн.">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="first-payment">Первоначальный взнос</label>
                                        <div class="range-output">
                                            <input  class="money text-input" name="first-payment-output" id="first-payment-output">
                                            <input type="hidden" id="first-payment-hidden">
                                        </div>
                                        <input type="range" list="first-payment-tickmarks" min="300000" max="5000000" value="1000000" class="form-control-range" id="first-payment">
                                        <div class="datalist" id="first-payment-tickmarks">
                                            <option value="300000" label="300 тыс.">
                                            <option value="500000">
                                            <option value="1000000">
                                            <option value="1500000">
                                            <option value="2000000">
                                            <option value="2500000">
                                            <option value="3000000">
                                            <option value="4500000">
                                            <option value="5000000" label="5 млн.">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="years">Срок кредита</label>
                                        <div class="range-output">
                                            <input class="text-input" name="years-output" id="years-output">
                                        </div>

                                        <input type="range" list="years-tickmarks" min="1" max="30" value="20" class="form-control-range" id="years">

                                        <div class="datalist" id="years-tickmarks">
                                            <option value="1" label="1 год">
                                            <option value="30" label="30 лет">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="percent">Ипотечные программы</label>
                                        <div id="percent">
                                            <input type="hidden" name="bank-select" id="bank-select-hidden">
                                            <select  id="bank-select">
                                                <option value="6.5" selected>Льготная ипотека для новостроек</option>
                                                <option value="4.9">Семейная ипотека</option>
                                                <option value="2.7">Сельская ипотека</option>
<!--                                                <option value="6.5">Покупка квартиры в новостройке</option>-->
<!--                                                <option value="8.9">Покупка вторичного жилья</option>-->
                                            </select>
                                            <div class="bank-percent">
                                                <input class="text-input-percent" id="bank-percent-span" value="6.5">%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="font-12 gray mt-n1 lh-sm mt-4">
                                        Приведенные расчеты носят предварительный характер. Окончательный расчет суммы кредита и рассрочки, размер ежемесячного платежа производятся после предоставления комплекта документов.
                                    </div>
                                </div>

                                <div class="col-md-5 col-lg-5 col-xl-5 col-xxl-5 d-flex flex-column ps-lg-5 px-xl-3">
                                    <div class="mc-item mc-item-first">
                                        <p>Сумма кредита</p>
                                        <p class="mc-item-number"><span id="credit-summ">5 000 000,00</span> ₽</p>
                                        <hr>
                                    </div>
                                    <div class="mc-item">
                                        <p>Ежемесячный платеж</p>
                                        <p class="mc-item-number"><span id="month-pay">37 278,66</span> ₽</p>
                                        <hr>
                                    </div>
                                    <? /* <div class="mc-item">
                        <p>Ежемесячный платеж c нами</p>
                        <p class="mc-item-number"><span id="month-pay-with-us">17 910,78</span> ₽</p>
                    </div> */ ?>

                                    <div class="mc-item-bottom mt-auto">
                                        <!-- p>Получите одобрение ипотеки<br>с этими условиями</p -->
                                        <input type="hidden" name="woc" value="1">
                                        <a href="#callback2" data-fancybox class="calc-submit-btn popmake-ipoteka-calc pum-trigger w-100" id="calc-submit"  style="cursor: pointer;">Подать заявку</a>
<!--                                        <button  type="submit" class="calc-submit-btn popmake-ipoteka-calc pum-trigger w-100" id="calc-submit" style="cursor: pointer;">Подать заявку</button>-->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane overflow-hidden" id="calc-rassrocka" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="row align-items-stretch mb-4">
                                <div class="col-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7 mb-4 mb-md-0">
                                    <input type="hidden" name="form_name" value="Заявка на рассрочку">
                                    <input type="hidden" name="name" value="Рассрочка">
                                    <div class="form-group">
                                        <label for="object-price">Стоимость недвижимости</label>
                                        <div class="range-output">
                                            <input class="money text-input" name="object-price-output" id="object-price-output2">
                                            <input type="hidden" id="object-price-hidden2">
                                        </div>
                                        <input type="range" list="object-price-tickmarks" min="500000" max="10000000" value="6000000" class="form-control-range" id="object-price2">

                                        <div class="datalist" id="object-price-tickmarks2">
                                            <option value="500000" label="500 тыс.">
                                            <option value="1000000">
                                            <option value="1500000">
                                            <option value="2000000">
                                            <option value="2500000">
                                            <option value="3000000">
                                            <option value="3500000">
                                            <option value="4000000">
                                            <option value="4500000">
                                            <option value="5000000">
                                            <option value="5500000">
                                            <option value="6000000">
                                            <option value="6500000">
                                            <option value="7000000">
                                            <option value="7500000">
                                            <option value="8000000">
                                            <option value="8500000">
                                            <option value="9000000">
                                            <option value="9500000">
                                            <option value="10000000" label="10 млн.">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="first-payment">Первоначальный взнос</label>
                                        <div class="range-output">
                                            <input class="money text-input" name="first-payment-output" id="first-payment-output2">
                                            <input type="hidden" id="first-payment-hidden2">
                                        </div>
                                        <input type="range" list="first-payment-tickmarks" min="300000" max="5000000" value="1000000" class="form-control-range" id="first-payment2">
                                        <div class="datalist" id="first-payment-tickmarks2">
                                            <option value="300000" label="300 тыс.">
                                            <option value="500000">
                                            <option value="1000000">
                                            <option value="1500000">
                                            <option value="2000000">
                                            <option value="2500000">
                                            <option value="3000000">
                                            <option value="4500000">
                                            <option value="5000000" label="5 млн.">
                                        </div>

                                    </div>
                                    <div class="font-12 gray mt-n1 lh-sm mt-4">
                                        Приведенные расчеты носят предварительный характер. Окончательный расчет суммы кредита и рассрочки, размер ежемесячного платежа производятся после предоставления комплекта документов.
                                    </div>
                                </div>

                                <div class="col-md-5 col-lg-5 col-xl-5 col-xxl-5 d-flex flex-column ps-lg-5 px-xl-3">
                                    <div class="mc-item mc-item-first">
                                        <p>Сумма рассрочки</p>
                                        <p class="mc-item-number"><span id="credit-summ2">5 000 000,00</span> ₽</p>
                                        <hr>
                                    </div>
                                    <div class="mc-item">
                                        <p>Ежемесячный платеж</p>
                                        <p class="mc-item-number"><span id="month-pay2">833 333,33</span> ₽</p>
                                        <hr>
                                    </div>

                                    <div class="mc-item mb-4">
                                        <p>Срок рассрочки</p>
                                        <input type="hidden" value="6" id="years2">
                                        <p class="mc-item-number"><span >6 месяцев</span></p>
                                    </div>

                                    <div class="mc-item-bottom mt-auto">
                                        <!-- p>Получите одобрение ипотеки<br>с этими условиями</p -->
                                        <input type="hidden" name="woc" value="1">
                                        <a href="#callback2" data-fancybox class="calc-submit-btn popmake-ipoteka-calc pum-trigger w-100" id="calc-submit2" >Оставить заявку</a>
<!--                                        <button type="submit" name="submit" class="calc-submit-btn popmake-ipoteka-calc pum-trigger w-100" id="calc-submit2" style="cursor: pointer;">Оставить заявку</button>-->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-4 col-xl-5 col-xxl-5 right-img d-xl-block">
                <img src="<?=SITE_TEMPLATE_PATH?>/image/family2.jpg" alt="family">
            </div>
        </div>

    </div>
</section>
<div id="callback2" class="popup" style="display: none;">
    <img class="mb-2" src="/images/ico-question2-green.svg" />
    <h2>
        Заявка
    </h2>


    <div class="darkgray-bg rounded-lg px-3 pt-3">
        <form class="form-ajax row gx-2 justify-content-center" id="form-credit" data-reachgoal="callback_form">
            <input type="hidden" name="form_name" id="form_sbm_name" value="Заявка на ипотеку">
            <input name="object-price-output"  type="hidden" id="object-price-output-form">
            <input  type="hidden" name="first-payment-output" id="first-payment-output-form">
            <input type="hidden" name="years-output" id="years-output-form">
            <input type="hidden" name="bank-select" id="bank-select-hidden-form">
            <input type="hidden" name="bank-percent"  id="bank-percent-span-form" value="6.5">
            <input type="hidden" name="summ-credit" id="summ-credit" value="5 000 000,00">

            <input type="hidden" name="month-pay" id="month-pay-form" value="37 278,66">

            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <input class="form-control form-control-lg mask-phone" type="tel" name="phone" placeholder="Телефон" required>
            </div>

            <? /* <input class="captchaSid" type="hidden" name="captcha_sid" value=""/>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend border">
                    <img class="jsReloadCaptcha captchaImg" alt="CAPTCHA"/>
                </div>

                <input class="form-control form-control-lg" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Введите код с картинки" required />
            </div> */ ?><input type="hidden" name="woc" value="1">

            <div class="col-12">
                <p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="/personaldata/">персональных данных</a></p>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Обратный звонок">
            </div>
        </form>
    </div>
</div>

<style>
    .calc-right {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: end;
        background: no-repeat url(/images/calc-right-bg.jpg) center / cover #864026;
        padding: 20px;
        border-radius: 16px;
    }
    .calc-right > span {
        display: inline-block;
        color: #ffffff;
        background: #FFFFFF0D;
        border: 0.58px solid #FFFFFF4D;
        backdrop-filter: blur(10.354155540466309px);
        font-size: 18px;
        font-weight: 500;
        padding: 4px 13px;
        border-radius: 30px;
    }

    /* Калькулятор ипотеки */
    #zembery-calculator-section {
        background-color: #fff;
        padding-top:50px;
        padding-bottom:100px;
    }
    .right-img img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .zembery-calculator {
        border-radius: 16px;
        box-shadow: 0px 2px 13px rgba(0, 0, 0, 0.08);
    }
    .zembery-calculator #credit-purpose {
        width: 100%;
        background: #fff;
        border: 1px solid #ccc;
        height: 45px;
        margin-bottom: 10px;
    }
    .zembery-calculator label {
        font-size: 14px;
        color: #333;
        opacity: 0.7;
    }
    .zembery-calculator .range-output span {
        color:#333;
    }
    .zembery-calculator .datalist {
        display: flex;
        justify-content: space-between;
        padding-bottom:7px;
    }

    .zembery-calculator .datalist option {
        display: inline;
        color: #ccc;
        font-weight: 300;
        font-size: 12px;
    }
    .money, .text-input {
        width:100%;
        border:none;
    }
    .text-input-percent {
        width:60%;
        border:none;
    }
    .zembery-calculator input[type="range"] {
        width: 100%;
        height: 3px;
        border-radius: 4px;
        background-color: #10B981;
        -webkit-appearance: none;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .zembery-calculator input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        background: #fff;
        border:2px solid #10B981;
        /*cursor: pointer;*/
        cursor: ew-resize;
    }

    .zembery-calculator input[type="range"]::-moz-range-thumb {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #4CAF50;
        cursor: pointer;
    }

    .zembery-calculator input[type="range"]::-moz-range-progress {
        background-color: #10B981;
    }
    .zembery-calculator input[type="range"]::-moz-range-track {
        background-color: #10B981;
    }


    .zembery-calculator .range-output {
        border:1px solid #ccc;
        padding:10px;
        border-radius: 4px;
    }
    .zembery-calculator #percent {
        display:flex;
        align-items: center;
        justify-content: space-between;
    }

    .zembery-calculator select {
        background: #fff;
        border: 1px solid #ccc;
        height: 47px;
        border-radius: 4px;
    }
    .zembery-calculator #percent #bank-select {
        width: 100%;
        flex-grow: 2;
    }
    .zembery-calculator #percent .bank-percent {
        width: 78px;
        float: left;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 9px;
        margin-left:16px;
        text-align: center;
        color: #04B040;
        font-size:16px;
    }
    .zembery-calculator .mc-item-first {
        /*margin-top:27px;*/
    }
    .zembery-calculator .mc-item p {
        line-height:1;
        color:#333;
    }
    .zembery-calculator .mc-item p.mc-item-number {
        color:#04B040;
        font-size:22px;
    }
    .zembery-calculator .mc-item-bottom {
        margin-top:40px;
    }
    .zembery-calculator .mc-item-bottom p {
        font-size:18px;
        color:#333;
        font-weight: 500;
    }
    /*.zembery-calculator .mc-item-bottom button {*/
    /*    background:#10B981;*/
    /*    color:#fefefe;*/
    /*    border-radius: 4px;*/
    /*    padding:13px 20px;*/
    /*    border:none;*/
    /*}*/
    .zembery-calculator .mc-item-bottom a {
        background:#10B981;
        color:#fefefe;
        border-radius: 4px;
        padding:13px 20px;
        border:none;
        display: inline-block;
        text-align: center;
    }
    .zembery-calculator .nav-link {
        color: #04B040;
    }
</style>

<script>
    function btnClicked() {
        document.getElementById('ipoteka-modal-form-span').innerHTML = "Льготная ипотека для новостроек от 6,5%";
        document.getElementById('zembery-program').value = "Льготная ипотека для новостроек от 6,5%";
    }
    function btn2Clicked() {
        document.getElementById('ipoteka-modal-form-span').innerHTML = "Семейная ипотека от 4,9%";
        document.getElementById('zembery-program').value = "Семейная ипотека от 4,9%";
    }
    function btn3Clicked() {
        document.getElementById('ipoteka-modal-form-span').innerHTML = "Сельская ипотека от 2,7%";
        document.getElementById('zembery-program').value = "Сельская ипотека от 2,7%";
    }
    function btn4Clicked() {
        document.getElementById('ipoteka-modal-form-span').innerHTML = "Покупка квартиры в новосторойке от 3,7%";
        document.getElementById('zembery-program').value = "Покупка квартиры в новосторойке от 3,7%";
    }
    function btn5Clicked() {
        document.getElementById('ipoteka-modal-form-span').innerHTML = "Покупка вторичного жилья от 8,9%";
        document.getElementById('zembery-program').value = "Покупка вторичного жилья от 8,9%";
    }
    //Для калькулятора

    //округление
    var rounded = function(number){
        return +number.toFixed(2);
    }

    //вывод в денежный формат
    var moneyFormat = function(n) {
        return parseFloat(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ").replace('.', ',');
    }

    //Переменные вывода значений в правом столбце
    var creditSumm = document.getElementById("credit-summ");
    var creditSummForm = document.getElementById("summ-credit");
    var credit;
    var percentSelectHiddenForm = document.getElementById("bank-select-hidden-form");
    var formCredit = document.getElementById("form-credit");
    var monthPay = document.getElementById("month-pay");
    var monthPayForm = document.getElementById("month-pay-form");
    var monthly;

    var overPay;
    var overPayWithUs;
    var yourSafe = document.getElementById("your-safe");
    var monthPayWithUs = document.getElementById("month-pay-with-us");
    var btnSubmit = document.getElementById("calc-submit");
    var btnSubmit2 = document.getElementById("calc-submit2");
    var formSummit = document.getElementById("form_sbm_name");
    var navLink2 = document.querySelectorAll('.nav-link')

    //Переменные для расчета ежемесячного платежа
    var monthSumm;
    var monthPercent;
    var ann;
    var monthPaySumm;
    function isIssetElem(type, name, id, form, value) {
        if (!document.getElementById(id)) {
            const percentSelectHiddenForm = document.createElement("input");
            percentSelectHiddenForm.type = type;
            percentSelectHiddenForm.name = name;
            percentSelectHiddenForm.id = id;
            percentSelectHiddenForm.value = value

            form.appendChild(percentSelectHiddenForm);
        }
    }
    btnSubmit.addEventListener("click", e => {
        formSummit.value = 'Заявка на ипотеку';

    });
    navLink2[0].addEventListener("click", e => {
        isIssetElem("hidden", "bank-select", "bank-select-hidden-form", formCredit)
        isIssetElem( "hidden", "bank-percent", "bank-percent-span-form", formCredit, "6.5")
        isIssetElem( "hidden", "years-output", "years-output-form", formCredit, "20")
    })
    btnSubmit2.addEventListener("click", e => {
        formSummit.value = 'Заявка на рассрочку';
        if (document.getElementById("bank-select-hidden-form")) {
            document.getElementById("bank-select-hidden-form").remove();
        }
        if (document.getElementById("bank-percent-span-form")) {
            document.getElementById("bank-percent-span-form").remove();
        }
        if (document.getElementById("years-output-form")) {
            document.getElementById("years-output-form").remove();
        }
    });

    //range стоимости объекта
    var slider = document.getElementById("object-price");
    var hidden = document.getElementById("object-price-hidden");
    var output = document.getElementById("object-price-output");
    var outputForm = document.getElementById("object-price-output-form");

    output.value = moneyFormat(slider.value);
    outputForm.value = moneyFormat(slider.value);


    slider.oninput = function() {
        hidden.value = this.value;
        output.value = moneyFormat(hidden.value);
        outputForm.value = moneyFormat(hidden.value);
        //Подсчет суммы кредита
        creditSumm.innerHTML = moneyFormat(this.value - firstPaymentSlider.value);
        creditSummForm.value = moneyFormat(this.value - firstPaymentSlider.value);
        credit = this.value - firstPaymentSlider.value;
        if(credit <= 0) {
            creditSumm.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }

        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }


    }

    output.oninput = function() {
        hidden.value = this.value.replace(/ /g, "").replace(",00", "");
        slider.value = hidden.value;
        outputForm.value =this.value.replace(/ /g, "").replace(",00", "");

        //Подсчет суммы кредита
        creditSumm.innerHTML = moneyFormat(hidden.value - firstPaymentSlider.value);
        creditSummForm.value =  moneyFormat(hidden.value - firstPaymentSlider.value);

        credit = hidden.value - firstPaymentSlider.value;
        if(credit <= 0) {
            creditSumm.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }
        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }
        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }
    }

    //range первоначального взноса
    var firstPaymentSlider = document.getElementById("first-payment");
    var firstPaymentOutput = document.getElementById("first-payment-output");
    var firstPaymentOutputForm = document.getElementById("first-payment-output-form");
    var firstHidden = document.getElementById("first-payment-hidden");
    firstPaymentOutput.value = moneyFormat(firstPaymentSlider.value);
    firstPaymentOutputForm.value = moneyFormat(firstPaymentSlider.value);

    firstPaymentSlider.oninput = function() {

        firstHidden.value = this.value;
        firstPaymentOutput.value = moneyFormat(firstHidden.value);
        firstPaymentOutputForm.value = moneyFormat(firstHidden.value);

        //Подсчет суммы кредита
        creditSumm.innerHTML = moneyFormat(slider.value - this.value);
        creditSummForm.value =   moneyFormat(slider.value - this.value);
        credit = slider.value - this.value;
        if(credit <= 0) {
            creditSumm.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }

        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }

    }

    firstPaymentOutput.oninput = function() {
        firstHidden.value = this.value.replace(/ /g, "").replace(",00", "");
        firstPaymentSlider.value = firstHidden.value;
        firstPaymentOutputForm.value = this.value.replace(/ /g, "").replace(",00", "");
        //Подсчет суммы кредита
        creditSumm.innerHTML = moneyFormat(slider.value - firstHidden.value);
        creditSummForm.value =  moneyFormat(slider.value - firstHidden.value);
        credit = slider.value - firstHidden.value;
        if(credit <= 0) {
            creditSumm.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }

        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }
    }

    //range срока кредита
    var years = document.getElementById("years");
    var yearsOutput = document.getElementById("years-output");
    var yearsOutputForm = document.getElementById("years-output-form");
    yearsOutput.value = years.value;
    yearsOutputForm.value = years.value;

    years.oninput = function() {
        yearsOutput.value = this.value;
        yearsOutputForm.value = this.value;

        credit = slider.value - firstPaymentSlider.value;
        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)*monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }

    }

    yearsOutput.oninput = function() {
        years.value = this.value;
        yearsOutputForm.value = this.value;
        credit = slider.value - firstPaymentSlider.value;
        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }
    }
    //Изменение процентной ставки

    var percentSelect = document.getElementById("bank-select");
    var percentSelectHidden = document.getElementById("bank-select-hidden");
    var bankPercent = document.getElementById("bank-percent-span");
    var bankPercentForm = document.getElementById("bank-percent-span-form");

    percentSelect.onchange = function() {
        bankPercent.value = this.options[this.selectedIndex].value;
        bankPercentForm.value = this.options[this.selectedIndex].value;
        percentSelectHidden.value = this.options[this.selectedIndex].innerHTML;
        percentSelectHiddenForm.value = this.options[this.selectedIndex].innerHTML;
        credit = slider.value - firstPaymentSlider.value;
        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }
    }

    bankPercent.oninput = function() {
        this.value = this.value.replace(",", '.');
        bankPercentForm = this.value.replace(",", '.');
        credit = slider.value - firstPaymentSlider.value;
        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (this.value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthPayForm.value = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
            monthPayForm.value  = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((this.value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }
    }
    /************ рассрочка ****************/

        //Переменные вывода значений в правом столбце
    var creditSumm2 = document.getElementById("credit-summ2");
    var credit2;

    var monthPay2 = document.getElementById("month-pay2");
    var monthly2;

    var overPay2;
    var overPayWithUs2;
    var yourSafe2 = document.getElementById("your-safe2");
    var monthPayWithUs2 = document.getElementById("month-pay-with-us2");

    //Переменные для расчета ежемесячного платежа
    var monthSumm2;
    var monthPercent2;
    var ann2;
    var monthPaySumm2;



    //range стоимости объекта
    var slider2 = document.getElementById("object-price2");
    var hidden2 = document.getElementById("object-price-hidden2");
    var output2 = document.getElementById("object-price-output2");

    output2.value = moneyFormat(slider2.value);
    outputForm.value = moneyFormat(slider2.value);
    slider2.oninput = function() {
        hidden2.value = this.value;
        output2.value = moneyFormat(hidden2.value);
        outputForm.value = moneyFormat(hidden2.value);
        //Подсчет суммы кредита
        creditSumm2.innerHTML = moneyFormat(this.value - firstPaymentSlider2.value);
        creditSummForm.value = moneyFormat(this.value - firstPaymentSlider2.value);
        credit2 = this.value - firstPaymentSlider2.value;
        if(credit2 <= 0) {
            creditSumm2.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }

        //Подсчет ежемесячного платежа
        // monthSumm2 = years2.value * 12;
        monthSumm2 = years2.value;
        //monthPercent2 = (percentSelect2.options[percentSelect.selectedIndex].value / 12) / 100;
        //ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm2 = credit2 / monthSumm2;

        monthPay2.innerHTML = moneyFormat(monthPaySumm2);
        monthPayForm.value = moneyFormat(monthPaySumm2);
        monthly2 = rounded(monthPaySumm2);
        if(monthPaySumm2 <= 0) {
            monthPay2.innerHTML = "0,00";
            monthPayForm.value  = "0,00";
        }
    }

    output2.oninput = function() {
        hidden2.value = this.value.replace(/ /g, "").replace(",00", "");
        outputForm.value = this.value.replace(/ /g, "").replace(",00", "");
        slider2.value = hidden2.value;


        //Подсчет суммы кредита
        creditSumm2.innerHTML = moneyFormat(hidden2.value - firstPaymentSlider2.value);
        creditSummForm.value = moneyFormat(hidden2.value - firstPaymentSlider2.value);
        credit2 = hidden2.value - firstPaymentSlider2.value;
        if(credit2 <= 0) {
            creditSumm2.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }
        //Подсчет ежемесячного платежа
        monthSumm2 = years2.value;
        // monthSumm2 = years2.value * 12;
        monthPaySumm2 = credit2 / monthSumm2;

        monthPay2.innerHTML = moneyFormat(monthPaySumm2);
        monthPayForm.value  = moneyFormat(monthPaySumm2);
        monthly2 = rounded(monthPaySumm2);
        if(monthPaySumm2 <= 0) {
            monthPay2.innerHTML = "0,00";
            monthPayForm.value  = "0,00";
        }
    }

    //range первоначального взноса
    var firstPaymentSlider2 = document.getElementById("first-payment2");
    var firstPaymentOutput2 = document.getElementById("first-payment-output2");
    var firstHidden2 = document.getElementById("first-payment-hidden2");
    firstPaymentOutput2.value = moneyFormat(firstPaymentSlider2.value);
    firstPaymentOutputForm.value =  moneyFormat(firstPaymentSlider2.value);
    firstPaymentSlider2.oninput = function() {

        firstHidden2.value = this.value;
        firstPaymentOutput2.value = moneyFormat(firstHidden2.value);
        firstPaymentOutputForm.value = moneyFormat(firstHidden2.value);

        //Подсчет суммы кредита
        creditSumm2.innerHTML = moneyFormat(slider2.value - this.value);
        creditSummForm.value = moneyFormat(slider2.value - this.value);
        credit2 = slider2.value - this.value;
        if(credit2 <= 0) {
            creditSumm2.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }

        //Подсчет ежемесячного платежа
        // monthSumm2 = years2.value * 12;
        monthSumm2 = years2.value;
        monthPaySumm2 = credit2 / monthSumm2;

        monthPay2.innerHTML = moneyFormat(monthPaySumm2);
        monthPayForm.value  = moneyFormat(monthPaySumm2);
        monthly2 = rounded(monthPaySumm2);
        if(monthPaySumm2 <= 0) {
            monthPay2.innerHTML = "0,00";
            monthPayForm.value = "0,00";
        }
    }

    firstPaymentOutput2.oninput = function() {
        firstHidden2.value = this.value.replace(/ /g, "").replace(",00", "");
        firstPaymentOutputForm.value = this.value.replace(/ /g, "").replace(",00", "");
        firstPaymentSlider2.value = firstHidden2.value;

        //Подсчет суммы кредита
        creditSumm2.innerHTML = moneyFormat(slider2.value - firstHidden2.value);
        creditSummForm.value = moneyFormat(slider2.value - firstHidden2.value);
        credit2 = slider2.value - firstHidden2.value;
        if(credit2 <= 0) {
            creditSumm2.innerHTML = "0,00";
            creditSummForm.value = "0,00";
        }

        //Подсчет ежемесячного платежа
        monthSumm2 = years2.value;
        // monthSumm2 = years2.value * 12;
        monthPaySumm2 = credit2 / monthSumm2;

        monthPay2.innerHTML = moneyFormat(monthPaySumm2);
        monthly2 = rounded(monthPaySumm2);
        if(monthPaySumm2 <= 0) {
            monthPay2.innerHTML = "0,00";
            monthPayForm.value  = "0,00";
        }
    }

    //range срока кредита
    var years2 = document.getElementById("years2");
    var yearsOutput2 = document.getElementById("years-output2");
    if (yearsOutput2){
        yearsOutput2.value = years2.value;
        yearsOutputForm.value = years2.value;
    }
/*
    years.oninput = function() {
        yearsOutput.value = this.value;

        credit = slider.value - firstPaymentSlider.value;
        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)*monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }

    }

    yearsOutput.oninput = function() {
        years.value = this.value;
        credit = slider.value - firstPaymentSlider.value;
        //Подсчет ежемесячного платежа
        monthSumm = years.value * 12;
        monthPercent = (percentSelect.options[percentSelect.selectedIndex].value / 12) / 100;
        ann = (monthPercent * ((1 + monthPercent)**monthSumm)) / (((1 + monthPercent)**monthSumm) - 1);
        monthPaySumm = credit * ann;

        monthPay.innerHTML = moneyFormat(monthPaySumm);
        monthly = rounded(monthPaySumm);
        if(monthPaySumm <= 0) {
            monthPay.innerHTML = "0,00";
        }

        //Подсчет переплаты по кредиту
        overPay = rounded(monthly * monthSumm - credit);

        //Подсчет переплаты по кредиту с нами
        var monthPercentWithUs = ((percentSelect.options[percentSelect.selectedIndex].value - 0.7) / 12) / 100;
        var annWithUs = (monthPercentWithUs * ((1 + monthPercentWithUs)**monthSumm)) / (((1 + monthPercentWithUs)**monthSumm) - 1);
        var monthPaySummWithUs = credit * annWithUs;
        overPayWithUs = rounded(monthPaySummWithUs * monthSumm - credit);

        //Подсчет сэкономленной суммы
        monthPayWithUs.innerHTML = moneyFormat(monthPaySummWithUs);
        yourSafe.innerHTML = moneyFormat(overPay - overPayWithUs);
        if(monthPaySummWithUs <= 0) {
            monthPayWithUs.innerHTML = "0,00";
        }

        if(overPay - overPayWithUs <= 0) {
            yourSafe.innerHTML = "0,00";
        }
    }
    //Изменение процентной ставки
*/

</script>