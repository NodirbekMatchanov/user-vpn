<?php
use yii\widgets\ActiveForm;

?>

<style>
    .form-group {
        width: 100%;
    }
</style>
<div class="mfp-hide">
    <div class="modal modal-contact" data-mfp='question'>
        <div class="modal-content">
            <?php $form = ActiveForm::begin(); ?>

            <h3 class="title-3">Задать вопрос</h3>

            <div class="input-2">
                <label for="" class="input-2-label">Ваше имя</label>
                <?= $form->field($model, 'name')->label(false) ?>
                <div class="question-name input-2-message _error"></div>
            </div>

            <div class="input-2">
                <label for="" class="input-2-label">E-mail</label>
                <?= $form->field($model, 'email')->label(false) ?>
                <div class="question-email input-2-message _error"></div>
            </div>

            <div class="input-2">
                <label for="" class="input-2-label">Вопрос</label>
                <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(false) ?>
                <div class="question-question input-2-message _error"></div>
            </div>

            <button type="button" class="btn-2 send-question">Отправить</button>
            <div class="modal-politic">
                Нажимая на кнопку, вы даете согласие на обработку персональных<br>
                данных и соглашаетесь c <a href="#">политикой конфиденциальности</a>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


    <div class="modal modal-contact" data-mfp='password'>
        <div class="modal-content">

            <h3 class="title-3">
                Войдите снова,<br>
                чтобы продолжить
            </h3>

            <div class="input-2">
                <label class="input-2-label">Пароль</label>
                <input type="password" placeholder="Пароль">

                <div class="input-2-eye">
                    <web/img src="web/img/icons/eye-2.svg">
                    <web/img src="web/img/icons/eye-2-hide.svg">
                </div>
            </div>

            <div class="modal-buttons">
                <button class="btn-2 _disabled modal-close">Отмена</button>
                <button class="btn-2">Отправить</button>
            </div>
        </div>
    </div>


    <div class="modal modal-contact" data-mfp='price-1'>
        <div class="modal-content">

            <h3 class="title-3 _left">
                VPN на 1 год
            </h3>

            <div class="input-2">
                <label class="input-2-label">Электронный адрес (отправим на него квитанцию)*</label>
                <input type="email" placeholder="Ваш e-mail">
            </div>

            <div class="input-2">
                <label class="input-2-label">Введите промокод</label>
                <input type="text">
            </div>

            <div class="modal-prices-description">VPN MAX (1 год): 11 864 р.</div>
            <div class="modal-prices-price">Итоговая сумма : 3 948 р.</div>

            <div class="modal-prices">
                <div class="modal-prices-row">
                    <div class="modal-prices-web/img">
                        <web/img src="web/img/modal-prices-1.png">
                    </div>
                    <div class="modal-prices-text">Банковская карта</div>
                </div>

                <div class="modal-prices-row">
                    <div class="modal-prices-web/img">
                        <web/img src="web/img/modal-prices-2.png">
                    </div>
                    <div class="modal-prices-text">Qiwi кошелек</div>
                </div>

                <div class="modal-prices-row">
                    <div class="modal-prices-web/img">
                        <web/img src="web/img/modal-prices-3.png">
                    </div>
                    <div class="modal-prices-text">ЮMoney / Яндекс Деньги</div>
                </div>

                <div class="modal-prices-row">
                    <div class="modal-prices-web/img">
                        <web/img src="web/img/modal-prices-4.png">
                    </div>
                    <div class="modal-prices-text">Криптовалюта</div>
                </div>
            </div>

            <button class="btn-2">Оплатить</button>
            <div class="modal-politic">
                Нажимая на кнопку, вы даете согласие на обработку персональных<br>
                данных и соглашаетесь c <a href="#">политикой конфиденциальности</a>
            </div>
        </div>
    </div>


    <div class="modal modal-success" data-mfp='success'>
        <div class="modal-content">

            <div class="modal-success-web/img">
                <web/img src="web/img/modal-success.svg">
            </div>

            <h3 class="title-1">
                Спасибо!
            </h3>

            <div class="modal-text">
                Ваш вопрос успешно отправлен<br>
                Мы ответим вам в ближайшее время
            </div>

        </div>
    </div>
</div>