<?php
$email = Yii::$app->user->identity->email;
$url = \yii\helpers\Url::to(['tariff/get-price?id=']);
$paymentSuccessUrl = \yii\helpers\Url::to(['tariff/payment-success']);
$code = Yii::$app->user->identity->promoCodes;
$paymentErrorUrl = \yii\helpers\Url::to(['tariff/payment-error']);
$script = <<<JS
  function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
  function orderNumber() {
      let now = Date.now().toString() // '1492341545873'
      // pad with extra random digit
      now += now + Math.floor(Math.random() * 10)
      // format
      return  [now.slice(0, 4), now.slice(4, 10), now.slice(10, 14)].join('-')
    }
    
    function cardPay(e) {
    promise = new Promise((resolve, reject) =>{
        $.ajax({
           url: "$url" + id + "&promocode=" + promocode + "&orderId=" + orderId+"&email="+email
         }).done(function(data){
             resolve(data);
         }).fail(function(err){
             alert(err);
             reject(err);
         })
    });
    promise.then((amount) =>{
        console.log(amount);
         amount = JSON.parse(amount);
            $('.total-price').html(amount.totalPrice)
            $('.tariff-price').html(amount.price)
            $('.discount').html(amount.discount)
            $('.choose-tariff-label').html($(this).closest('.prices-item').find('.tariff-title').html())
        self.pay = function () {
    var widget = new cp.CloudPayments();
    var price = parseFloat(amount.totalPrice);
    var receipt = {
            Items: [//товарные позиции
                 {
                    label: 'Оплата за подписку', //наименование товара
                    price: price, //цена
                    quantity: 1.00, //количество
                    amount: price, //сумма
                    vat: 0, //ставка НДС
                    method: 0, // тег-1214 признак способа расчета - признак способа расчета
                    object: 1, // тег-1212 признак предмета расчета - признак предмета товара, работы, услуги, платежа, выплаты, иного предмета расчета
                }
            ],
            isBso: false, //чек является бланком строгой отчетности
        };

    var data = {};
    data.CloudPayments = {
        CustomerReceipt: receipt, //чек для первого платежа
        recurrent: {
         interval: amount.periodType,
         period: amount.period, 
         customerReceipt: receipt //чек для регулярных платежей
         }
         }; //создание ежемесячной подписки

    widget.charge({ // options
        publicId: 'pk_16424c5787dd7ebfbba47e66aafa8', //id из личного кабинета
        description: 'Подписка на ежемесячный доступ к сайту https://www.vpnmax.org/', //назначение
        amount: price, //сумма
        currency: 'RUB', //валюта
        TestMode: false,
         accountId: '$email',
        invoiceId: orderId, //номер заказа  (необязательно)
        data: data
    },
    function (options) { // success
                    document.location.href = "/site/success"
    },
    function (reason, options) { // fail
        //действие при неуспешной оплате
          $.ajax({
            url: "$paymentErrorUrl",
            method: "POST",
            data: {
                tariff: id,
                status : false,
                orderId: orderId,
                amount: price
            }
        }).done(function (data){
            swal("Покупка прошла не успешно!"), "error";
        })
    });
};
        e.preventDefault();
        self.pay();
    })
}

  function ValidateEmail(input) {

        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (input.value.match(validRegex)) {


            return true;

        } else {

            return false;

        }

    }
    
 var id = "";
    var method = "";
    var promocode = "";
    var orderId = "";
    var email = "";
$(document).on('click', '.pay', function (e) {
     id = $('.prices-item._active').data('id') ;
     method = $('[name="method"]').val();
     promocode = getCookie('promocode') ?? $('[name="payer-promocode"]').val();
     orderId = orderNumber();
     email = $('[name="email-payer"]').val()
     if(email) {
         if(!ValidateEmail($('[name="email-payer"]')[0])) {
             $('.email-payer-message').html('не валидный email');
             return false;
         }
        // типы оплаты
        switch (method) {
            case "card" : cardPay(e);
            break;
            case "qiwi" : cardPay();
            break;
            case "yomaney" : cardPay();
            break;
            case "bitcoin" : cardPay();
            break;
        } 
     } else {
         $('.email-payer-message').closest('.input-2').addClass('_error');
         $('.email-payer-message').html('не заполнено поле e-mail');
     }
     
    });
$(document).ready(function() {
      $('.prices-item._active').trigger('click');
})
$('.prices-item, .prices-item._active').on('click',function () {
        id = $(this).closest('.prices-item').data('id') ;
        method = $('[name="method"]').val();
        promocode = getCookie('promocode') ?? $('[name="payer-promocode"]').val();
        orderId = orderNumber();

        promise = new Promise((resolve, reject) => {
            $.ajax({
                url: "$url" + id + "&promocode=" + promocode + "&orderId=" + orderId
            }).done(function(data){
                resolve(data);
            }).fail(function(err){
                alert(err);
                reject(err);
            })
        });
        promise.then((amount) =>{
            amount = JSON.parse(amount);
            $('.total-price').html(amount.totalPrice)
            $('.tariff-price').html(amount.price)
            if(amount.discount) {
                $('.prices-form-coupon').removeClass('hidden');
            }
            $('.discount').html(amount.discount)
            $('.choose-tariff-label').html($(this).closest('.prices-item').find('.tariff-title').html())
        })
        if($('.prices-form').hasClass('hidden')) {
            $('.prices-form').removeClass('hidden');
        }
    })
JS;
$this->registerJs($script, $this::POS_END);
?>
<script src="https://widget.cloudpayments.ru/bundles/cloudpayments.js"></script>
<?php if(!empty($subscribe)):?>
<div class="container">
    <h2 class="title-2">
        У вас есть активная подписка
    </h2>
</div>
<?php else: ?>
<div class="prices <?php if (isset($vars->space)) echo '_space'; ?>" name='prices'>
    <div class="container">
        <div class="prices-header">
            <?php if (empty($vars->simple)): ?>
                <h2 class="title-2">
                    Получите
                    <span>
					<span class="accent">анонимный</span><br>
					<span class="accent">доступ</span>
					</span>
                    к любым сайтам
                </h2>

                <div class="prices-note">30 дневная гарантия возврата средств</div>
            <?php else: ?>
                <h2 class="title-3 _bold">
                    Тарифы
                </h2>
            <?php endif; ?>
        </div>

        <div class="prices-items">
            <?php foreach ($tariffs as $tariff): ?>

                <?php if (!empty($tariff) && $tariff->day_30): ?>
                    <div class="prices-item" data-id="1_month">
                        <h3 class="title-3 tariff-title">1 месяц</h3>

                        <div class="spacer"></div>

                        <div>
                            <div class="prices-price">
                                <?= Yii::$app->formatter->asDecimal($tariff->price_30, 0) ?> ₽ / мес
                            </div>
                            <div class="prices-price-note">
                                +НДС
                            </div>
                        </div>

                        <div class="prices-check"></div>
                    </div>

                <?php endif; ?>
                <?php if (!empty($tariff) && $tariff->day_180): ?>
                    <div class="prices-item" data-id="6_month">
                        <h3 class="title-3 tariff-title">6 месяцев</h3>

                        <div class="spacer"></div>
                        <div class="prices-sale-percent">-5%</div>

                        <div>
                            <div class="prices-price">
                                <?= Yii::$app->formatter->asDecimal($tariff->price_180, 0) ?> ₽
                            </div>
                            <div class="prices-price-note">
                                +НДС
                            </div>
                        </div>

                        <div class="prices-check"></div>
                    </div>

                <?php endif; ?>
                <?php if (!empty($tariff) && $tariff->price_365): ?>
                    <div class="prices-item _active" data-id="12_month">
                        <div class="prices-best">
                            <div class="prices-best-img">
                                <img src="/web/img/logo-3.svg">
                            </div>
                            <div class="prices-best-text">Лучший выбор</div>
                        </div>

                        <h3 class="title-3 tariff-title">1 год</h3>

                        <div class="spacer"></div>

                        <div class="prices-sale">
                            <div class="prices-sale-text">
                            </div>
                            <div class="prices-sale-percent">-35%</div>
                        </div>

                        <div>
                            <div class="prices-price">
                                <?= Yii::$app->formatter->asDecimal($tariff->price_365, 0) ?> ₽
                            </div>
                            <div class="prices-price-note">
                                +НДС, оплата раз в год
                            </div>
                        </div>

                        <div class="prices-check"></div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>


        </div>

        <div class="prices-tags">
            <div class="prices-tags-item">Неограниченная скорость</div>
            <div class="prices-tags-item">Все локации</div>
            <div class="prices-tags-item">До 6 устройств</div>
            <div class="prices-tags-item">Безлимитный трафик</div>
        </div>

        <div class="prices-form hidden">

            <div class="input-2 ">
                <label for="" class="input-2-label">Электронный адрес (отправим на него квитанцию)*</label>
                <input type="email" class="hidden" value="<?=$email?>" name="email-payer" placeholder='Ваш e-mail'>
                				<div class="email-payer-message  input-2-message _error"></div>
            </div>

            <div class="input-2 ">
                <label for="" class="input-2-label">Введите промокод</label>
                <input type="text" value="<?= Yii::$app->request->get('ref') ?? Yii::$app->request->get('promocode') ?>" name="payer-promocode">
                				<div class="promocode-payer-message input-2-message _success"></div>
                                <div class="promocode-payer-message input-2-message _error"></div>

            </div>

            <div class="prices-form-variant">VPN MAX (<span class="choose-tariff-label"></span>): <span
                        class="tariff-price">11 864</span> р.
            </div>

            <div class="prices-form-coupon hidden">Вы применили купон со скидкой <span class="discount">0 </span>%</div>

            <div class="prices-form-total">Итоговая сумма: <span class="total-price">3 948</span> р.</div>
            <p style="text-align: center">данная сумма будет списываться ежемесячно</p>
            <div class="prices-methods">
                <h3 class="title-4">Способы оплаты</h3>
                <div class="prices-methods-items " style="display: none">
                    <label class="prices-methods-item">
                        <input type="radio" name='method' value="card" checked hidden>
                        <span class="prices-methods-thumb"></span>
                        <span class="prices-methods-img"><img src="/web/img/modal-prices-1.png"></span>
                    </label>
                    <label class="prices-methods-item">
                        <input type="radio" name='method' hidden>
                        <span class="prices-methods-thumb"></span>
                        <span class="prices-methods-img"><img src="/web/img/modal-prices-2.png"></span>
                    </label>
                    <label class="prices-methods-item">
                        <input type="radio" name='method' hidden>
                        <span class="prices-methods-thumb"></span>
                        <span class="prices-methods-img"><img src="/web/img/modal-prices-3.png"></span>
                    </label>
                    <label class="prices-methods-item">
                        <input type="radio" name='method' hidden>
                        <span class="prices-methods-thumb"></span>
                        <span class="prices-methods-img"><img src="/web/img/modal-prices-4.png"></span>
                    </label>
                </div>
            </div>

            <button type="button" class="btn-2 pay">Купить</button>

            <div class="form-politic">
                Нажимая на кнопку, вы даете согласие на обработку персональных<br>
                данных и соглашаетесь c <a href="<?=\yii\helpers\Url::to(['/site/privacy'])?>">политикой конфиденциальности</a>
            </div>

        </div>

    </div>
</div>
<?php endif; ?>
