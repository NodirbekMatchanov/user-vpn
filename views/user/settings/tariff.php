<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $model
 */

$this->title = Yii::t('user', 'Тариф');
$this->params['breadcrumbs'][] = $this->title;
$email = Yii::$app->user->identity->email;
$url = \yii\helpers\Url::to(['tariff/get-price?id=']);
$paymentSuccessUrl = \yii\helpers\Url::to(['tariff/payment-success']);
$paymentErrorUrl = \yii\helpers\Url::to(['tariff/payment-error']);
$script = <<<JS
  function orderNumber() {
      let now = Date.now().toString() // '1492341545873'
      // pad with extra random digit
      now += now + Math.floor(Math.random() * 10)
      // format
      return  [now.slice(0, 4), now.slice(4, 10), now.slice(10, 14)].join('-')
    }
$(document).on('click', '.pay', function (e) {
    let id = $(this).data('id');
    let promocode = getCookie('promocode');
    let monthTariff = $(this).data('period');
    var self = this;
    let orderId = orderNumber();
    promise = new Promise((resolve, reject) =>{
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
        console.log(amount);
        self.pay = function () {
    var widget = new cp.CloudPayments();
    var price = parseFloat(amount);
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
            email: '$email', //e-mail покупателя, если нужно отправить письмо с чеком
            phone: '', //телефон покупателя в любом формате, если нужно отправить сообщение со ссылкой на чек
            isBso: false, //чек является бланком строгой отчетности
        };

    var data = {};
    data.CloudPayments = {
        CustomerReceipt: receipt, //чек для первого платежа
        recurrent: {
         interval: 'Month',
         period: monthTariff, 
         customerReceipt: receipt //чек для регулярных платежей
         }
         }; //создание ежемесячной подписки

    widget.charge({ // options
        publicId: 'pk_16424c5787dd7ebfbba47e66aafa8', //id из личного кабинета
        description: 'Подписка на ежемесячный доступ к сайту https://www.vpnmax.org/', //назначение
        amount: price, //сумма
        currency: 'RUB', //валюта
        requireEmail: true,
        invoiceId: orderId, //номер заказа  (необязательно)
        accountId: '$email', //идентификатор плательщика (обязательно для создания подписки)
        data: data
    },
    function (options) { // success
         swal("Покупка прошла успешно!", "success");
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
    
    });
JS;
$this->registerJs($script, $this::POS_END);
$code = Yii::$app->user->identity->promoCodes;
$discount = $code['code']['discount'] ?? 0;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
               <div class="alert alert-info"> <?= (!empty($accs)) ? $accs->tariff.' подписка до '. date("d.m.Y", $accs->untildate) : 'free'?></div>
            </div>
            <div class="container" style="margin: 25px 15px">
                <label>Промокод</label>
                <input name="promocode" placeholder="code" value="<?=$code['promocode'] ?? ''?>" class="input-sm" style="width: 400px" type="text" >
                <button id="usePromocode" class="btn btn-primary <?=(!empty($code) ? 'hidden' : '' )?>"> Применить</button>
                <button id="cancelPromocode" class="btn btn-danger <?=(empty($code) ? 'hidden' : '' )?>"> Отменить</button>
            </div>
        </div>

    </div>
</div>
