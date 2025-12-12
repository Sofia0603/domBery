<div class="container" style="margin-top:70px;">
    <div class="green-grad-bg rounded-lg white p-5">
        <div class="green-form-house">
            <div class="h1 mb-3">
                Построим дом вашей мечты
            </div>

            <div class="">
                Мы можем построить любой дом - просто отправьте свои имя и номер телефона
            </div>
            <img src="/images/green-from-house.png" />
        </div>

        <div class="white-bg p-3 rounded-lg ">
            <form class="form-ajax form-row" action="/local/include/ajax-feedback-dombery.php">
                <input type="hidden" name="form_name" value="Подобрать участок" >
                <div class="col-12 col-md mb-3 mb-md-0">
                    <input class="form-control form-control-lg" type="text" name="name" placeholder="Имя" required>
                </div>
                <div class="col-12 col-md mb-3 mb-md-0">
                    <input class="form-control form-control-lg  mask-phone" type="tel" name="phone" placeholder="Телефон" required>
                </div>
                <div class="col-12 col-md">
                    <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" placeholder="Отправить">
                </div>
				<div class="col-12">
        			<p class="question__description gray">При нажатии на кнопку “Отправить”, Вы даёте согласие на обработку <a style="color: #135A9E;" href="#">персональных данных</a></p>
       			</div>
            </form>
        </div>

    </div>
    <br> <br> <br> <br>
</div>