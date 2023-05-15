<?php


/** @var yii\web\View $this */

$url = \yii\helpers\Url::to(Yii::$app->params['backendUrl'].'/tariff/get-price?id=');
$checkEmail = \yii\helpers\Url::to(Yii::$app->params['backendUrl'].'/tariff/check-email');
$paymentSuccessUrl = \yii\helpers\Url::to(Yii::$app->params['backendUrl'].'/tariff/payment-success');
$paymentErrorUrl = \yii\helpers\Url::to(Yii::$app->params['backendUrl'].'/tariff/payment-error');
$selectTariff = Yii::$app->request->get('period');
if($selectTariff) {
    switch ($selectTariff) {
        case 1: $selectTariff = "1_month";
            break;
        case 6: $selectTariff = "6_month";
            break;
        case 12: $selectTariff = "12_month";
            break;
    }
}

$titleDebited = \Yii::t('app', 'web-home-text-54');
$titleDebited6 = \Yii::t('app', 'web-home-text-56');
$titleDebited12 = \Yii::t('app', 'web-home-text-57');
$novalidemail = \Yii::t('app', 'web-home-error-1');
$notfilledemail = \Yii::t('app', 'web-home-error-2');
$hassubscribe = \Yii::t('app', 'web-home-error-3');
$validateEmail = \Yii::t('app', 'web-home-error-4');
$usedsuccess = \Yii::t('app', 'web-home-error-5');
$threedays = \Yii::t('app', 'web-home-error-6');
$language = Yii::$app->language;
$script = <<<JS

  function autoSignup () {
        let element = $('[name="email"]')[0];
        $('[name="email"]').removeClass('validate-email');
        $('.error-email').remove();
        if (validateEmailPayer(element)) {
            let password = Password.generate(8);
            $.ajax({
                url: BACKURL + "/user/registration/auto-register?" + $.param(getParams),
                method: "GET",
                data: {password: password, password_repeat: password, email: element.value}
            }).done(function (data) {
                if (data) {
                    window.location.href = BACKURL + "/user/registration/verify-code";
                }
            }).fail(function () {
                alert('ошибка регистрации')
            })
        } else {
            $('[name="email"]').addClass('validate-email');
            $('[name="email"]').after("<span class='error-email' style='color: red; font-size: 14px'>$novalidemail</span>")
        }
    }
    
    function validateEmailPayer(field) {
      $('.email-payer-message').closest('.input-2').removeClass('_error');
        $('.email-payer-message').html('');

        if (!ValidateEmail($(field)[0])) {
            $('.email-payer-message').html("$validateEmail");
        }
        if ($(field).val() == '') {
            $('.email-payer-message').closest('.input-2').addClass('_error');
            $('.email-payer-message').html("$notfilledemail");
        }
    }
   var URLToArray = function (url) {
        function parse_mdim(name, val, data) {
            let params = name.match(/(\[\])|(\[.+?\])/g);
            if (!params) params = new Array();
            let tg_id = name.split('[')[0];


            if (!(tg_id in data)) data[tg_id] = [];
            var prev_data = data[tg_id];

            for (var i = 0; i < params.length; i++) {
                if (params[i] != '[]') {
                    let tparam = params[i].match(/\[(.+)\]/i)[1];
                    if (!(tparam in prev_data)) prev_data[tparam] = [];
                    prev_data = prev_data[tparam];
                } else {
                    prev_data.push([]);
                    prev_data = prev_data[prev_data.length - 1];
                }

            }
            prev_data.push(val);

        }

        var request = {};
        var arr = [];
        var pairs = url.substring(url.indexOf('?') + 1).split('&');

        for (var i = 0; i < pairs.length; i++) {
            var pair = pairs[i].split('=');
            if (decodeURIComponent(pair[0]).indexOf('[') != -1)
                parse_mdim(decodeURIComponent(pair[0]), decodeURIComponent(pair[1]), request);
            else
                request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
        }

        //To-do here check array and simplifity it: if parameter end with one index in array replace it by value [0]

        return request;
    }
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
        var getParams = URLToArray(window.location.href);

    function cardPay(e) {
    promise = new Promise((resolve, reject) =>{
        $.ajax({
           url: "$url" + id + "&promocode="   + promocode  + "&orderId=" + orderId+"&email="+email+'&'+ $.param(getParams)
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
        description: 'Подписка для '+ email +' на доступ к сайту https://www.vpn-max.com', //назначение
        amount: price, //сумма
        currency: 'RUB', //валюта
        TestMode: false,
         accountId: email,
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
     $.ajax({
        url: '$checkEmail?email='+ email 
     }).done(function(data) {
       if(data) {
           if(email) {
                 if(!ValidateEmail($('[name="email-payer"]')[0])) {
                     $('.email-payer-message').html("$novalidemail");
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
                 $('.email-payer-message').html("$notfilledemail");
             }
       } else {
           $('.email-payer-message').html("$hassubscribe");
       }
     }).fail(function() {
       
     })

     
    });
$(document).ready(function() {
      $('.prices-item._active').trigger('click');
      $('[data-id="$selectTariff"]').trigger('click');
      var selectTariff = "$selectTariff";
      setTimeout(function() {
        if (selectTariff) {
          document.querySelector('.prices-header').scrollIntoView({
              behavior: 'smooth'
          });
      }
      },1000)

    $(document).on('focusout', '[name="payer-promocode"]', function () {
            $('.promocode-payer-message._success').html('');
            $('.promocode-payer-message._error').html('');
            $.ajax({
                url: BACKURL + "/promocodes/validation",
                method: "GET",
                data: {code: $(this).val(),language: '$language'}
            }).done(function (data) {
                data = JSON.parse(data);
                // Промокод успешно применен
                if (data.result == 'success') {
                    $('.promocode-payer-message._success').html("$usedsuccess");
                    $('.prices-item._active').trigger('click');
                }
                else if (data.result == 'user-promocode') {
                    $('.valid-promocode').html("<i>$threedays</i>");
                }
                if (data.result == 'error') {
                    $('.promocode-payer-message._error').html(data.error);
                    $('.prices-item._active').trigger('click');
                }
            })
        })
})
$('.prices-item, .prices-item._active').on('click',function () {
        id = $(this).closest('.prices-item').data('id') ;
        method = $('[name="method"]').val();
        promocode = getCookie('promocode') ?? $('[name="payer-promocode"]').val();
        orderId = orderNumber();

        promise = new Promise((resolve, reject) => {
            $.ajax({
                url: "$url" + id + "&promocode="  + promocode + "&language=" + '$language'  + "&orderId=" + orderId +'&'+ $.param(getParams)
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
        if(id == '1_month') {
           $('.payout_info').text("$titleDebited");
        } else if(id == '6_month') {
           $('.payout_info').text("$titleDebited6");
        } else if(id == '12_month') {
           $('.payout_info').text("$titleDebited12");            
        }
    })
JS;
$this->registerJs($script, $this::POS_END);
?>
<div class="prices <?php if (isset($vars->space)) echo '_space'; ?>" name='prices'>
    <div class="container">
        <div class="prices-header">
            <?php if (empty($vars->simple)): ?>
                <h2 class="title-2">
                    <?=\Yii::t('app', 'web-home-subtitle-8');?>
                </h2>

                <div class="prices-note"><?=\Yii::t('app', 'web-home-text-44');?></div>
            <?php else: ?>
                <h2 class="title-3 _bold">
                    <?=\Yii::t('app', 'web-home-text-45');?>
                </h2>
            <?php endif; ?>
        </div>

        <div class="prices-items">


                <?php if (!empty($tariff) && $tariff->day_30): ?>
                    <div class="prices-item _active" data-id="1_month">
                        <h3 class="title-3 tariff-title">1 <?=\Yii::t('app', 'web-home-text-46');?></h3>

                        <div class="spacer"></div>

                        <?php if($tariff->discount_30):?>
                           <div class="prices-sale-percent">-<?=$tariff->discount_30?>%</div>
                        <?php endif; ?>

                        <div>
                            <div class="prices-price">
                                <?php if ($tariff->position_currency == 'rtl'): ?>
                                    <?= Yii::$app->formatter->asDecimal($tariff->price_30, 0) ?> <?=$tariff->currency?> / мес
                                <?php else: ?>
                                    <?=$tariff->currency?><?= Yii::$app->formatter->asDecimal($tariff->price_30, 2) ?>  / мес
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="prices-check"></div>
                    </div>

                <?php endif; ?>
                <?php if (!empty($tariff) && $tariff->day_180): ?>
                    <div class="prices-item" data-id="6_month">
                        <h3 class="title-3 tariff-title">6 <?=\Yii::t('app', 'web-home-text-47');?></h3>

                        <div class="spacer"></div>
                        <?php if($tariff->discount_180):?>
                            <div class="prices-sale-percent">-<?=$tariff->discount_180?>%</div>
                        <?php endif; ?>

                        <div>
                            <div class="prices-price">
                                <?php if ($tariff->position_currency == 'rtl'): ?>
                                    <?= Yii::$app->formatter->asDecimal($tariff->price_180, 0) ?> <?=$tariff->currency?>
                                <?php else: ?>
                                    <?=$tariff->currency?><?= Yii::$app->formatter->asDecimal($tariff->price_180, 2) ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="prices-check"></div>
                    </div>

                <?php endif; ?>
                <?php if (!empty($tariff) && $tariff->price_365): ?>
                    <div class="prices-item " data-id="12_month">
                        <div class="prices-best">
                            <div class="prices-best-img">
                                <img src="/web/img/logo-3.svg">
                            </div>
                            <div class="prices-best-text"><?=\Yii::t('app', 'web-tariff-text-9');?></div>
                        </div>

                        <h3 class="title-3 tariff-title">1 <?=\Yii::t('app', 'web-home-text-48');?></h3>

                        <div class="spacer"></div>

                        <div class="prices-sale">
                            <div class="prices-sale-text">
                            </div>
                            <?php if($tariff->discount_365):?>
                                <div class="prices-sale-percent">-<?=$tariff->discount_365?>%</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <div class="prices-price">
                                <?php if ($tariff->position_currency == 'rtl'): ?>
                                    <?= Yii::$app->formatter->asDecimal($tariff->price_365, 0) ?> <?=$tariff->currency?>
                                <?php else: ?>
                                    <?=$tariff->currency?><?= Yii::$app->formatter->asDecimal($tariff->price_365, 2) ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="prices-check"></div>
                    </div>
                <?php endif; ?>



        </div>

        <div class="prices-tags">
            <div class="prices-tags-item"><?=\Yii::t('app', 'web-home-text-49');?></div>
            <div class="prices-tags-item"><?=\Yii::t('app', 'web-home-text-50');?></div>
            <div class="prices-tags-item"><?=\Yii::t('app', 'web-home-text-51');?></div>
            <div class="prices-tags-item"><?=\Yii::t('app', 'web-home-text-52');?></div>
        </div>

        <div class="prices-form hidden">

            <div class="input-2 ">
                <label for="" class="input-2-label"><?=\Yii::t('app', 'web-home-title-1');?></label>
                <input type="email" name="email-payer" value="<?=Yii::$app->request->get('email')?>" onchange="validateEmailPayer(this)"  placeholder='<?=\Yii::t('app', 'web-home-text-61');?>'>
                				<div class="email-payer-message input-2-message _error"></div>
            </div>

            <div class="input-2 ">
                <label for="" class="input-2-label"><?=\Yii::t('app', 'web-home-title-2');?></label>
                <input type="text" value="<?= Yii::$app->request->get('ref') ?? Yii::$app->request->get('promocode') ?>" name="payer-promocode">
                				<div class="promocode-payer-message input-2-message _success"></div>
                                <div class="promocode-payer-message input-2-message _error"></div>

            </div>

            <div class="prices-form-variant">VPN MAX (<span class="choose-tariff-label"></span>):

                <?php if ($tariff->position_currency == 'rtl'): ?>
                    <span class="total-price">0</span> <?=$tariff->currency ?? 'р'?>.
                <?php else: ?>
                    <?=$tariff->currency ?? 'р'?><span class="total-price">0</span>
                <?php endif; ?>

            </div>

            <div class="prices-form-coupon hidden"><?=\Yii::t('app', 'web-home-text-58');?> <span class="discount">0 </span>%</div>

            <div class="prices-form-total"><?=\Yii::t('app', 'web-home-text-53');?>:

                <?php if ($tariff->position_currency == 'rtl'): ?>
                    <span class="tariff-price">0</span> <?=$tariff->currency ?? 'р'?>.
                <?php else: ?>
                    <?=$tariff->currency ?? 'р'?><span class="tariff-price">0</span>
                <?php endif; ?>

            </div>
            <p class="payout_info" style="text-align: center"><?=\Yii::t('app', 'web-home-text-54');?></p>
            <div class="prices-methods">
<!--                <h3 class="title-4">Способы оплаты</h3>-->
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

            <button type="button" <?= ($language == 'en') ? 'disabled="true"' : ''?> class="btn-2 pay"><?=\Yii::t('app', 'web-button-buy');?></button>

            <div class="form-politic">
                    <?=\Yii::t('app', 'web-home-text-55');?>
             </div>

        </div>

    </div>
</div>