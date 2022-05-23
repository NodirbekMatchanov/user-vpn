<?php
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
    let monthTariff = $(this).data('period');
    var self = this;
    let orderId = orderNumber();
    promise = new Promise((resolve, reject) =>{
        $.ajax({
        url: "$url" + id
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
        invoiceId: orderId, //номер заказа  (необязательно)
        accountId: '$email', //идентификатор плательщика (обязательно для создания подписки)
        data: data
    },
    function (options) { // success
        console.log(options);
        $.ajax({
            url: "$paymentSuccessUrl",
            method: "POST",
            data: {
                tariff: id,
                status : true,
                orderId: orderId,
                amount: price
            }
        }).done(function (data){
            swal("Покупка прошла успешно!"), "success";
        })
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


<style>body {
        background: #B1EA86;
    }

    a {
        text-decoration: none;
    }

    .pricingTable {
        text-align: center;
        background: #fff;
        margin: 0 -15px;
        box-shadow: 0 0 10px #ababab;
        padding-bottom: 40px;
        border-radius: 10px;
        color: #cad0de;
        transform: scale(1);
        transition: all .5s ease 0s
    }

    .pricingTable:hover {
        transform: scale(1.05);
        z-index: 1
    }

    .pricingTable .pricingTable-header {
        padding: 40px 0;
        background: #f5f6f9;
        border-radius: 10px 10px 50% 50%;
        transition: all .5s ease 0s
    }

    .pricingTable:hover .pricingTable-header {
        background: #ff9624
    }

    .pricingTable .pricingTable-header i {
        font-size: 50px;
        color: #858c9a;
        margin-bottom: 10px;
        transition: all .5s ease 0s
    }

    .pricingTable .price-value {
        font-size: 35px;
        color: #ff9624;
        transition: all .5s ease 0s
    }

    .pricingTable .month {
        display: block;
        font-size: 14px;
        color: #cad0de
    }

    .pricingTable:hover .month,
    .pricingTable:hover .price-value,
    .pricingTable:hover .pricingTable-header i {
        color: #fff
    }

    .pricingTable .heading {
        font-size: 24px;
        color: #ff9624;
        margin-bottom: 20px;
        text-transform: uppercase
    }

    .pricingTable .pricing-content ul {
        list-style: none;
        padding: 0;
        margin-bottom: 30px
    }

    .pricingTable .pricing-content ul li {
        line-height: 30px;
        color: #a7a8aa
    }

    .pricingTable .pricingTable-signup a {
        display: inline-block;
        font-size: 15px;
        color: #fff;
        padding: 10px 35px;
        border-radius: 20px;
        background: #ffa442;
        text-transform: uppercase;
        transition: all .3s ease 0s
    }

    .pricingTable .pricingTable-signup a:hover {
        box-shadow: 0 0 10px #ffa442
    }

    .pricingTable.blue .heading,
    .pricingTable.blue .price-value {
        color: #4b64ff
    }

    .pricingTable.blue .pricingTable-signup a,
    .pricingTable.blue:hover .pricingTable-header {
        background: #4b64ff
    }

    .pricingTable.blue .pricingTable-signup a:hover {
        box-shadow: 0 0 10px #4b64ff
    }

    .pricingTable.red .heading,
    .pricingTable.red .price-value {
        color: #ff4b4b
    }

    .pricingTable.red .pricingTable-signup a,
    .pricingTable.red:hover .pricingTable-header {
        background: #ff4b4b
    }

    .pricingTable.red .pricingTable-signup a:hover {
        box-shadow: 0 0 10px #ff4b4b
    }

    .pricingTable.green .heading,
    .pricingTable.green .price-value {
        color: #40c952
    }

    .pricingTable.green .pricingTable-signup a,
    .pricingTable.green:hover .pricingTable-header {
        background: #40c952
    }

    .pricingTable.green .pricingTable-signup a:hover {
        box-shadow: 0 0 10px #40c952
    }

    .pricingTable.blue:hover .price-value,
    .pricingTable.green:hover .price-value,
    .pricingTable.red:hover .price-value {
        color: #fff
    }

    @media screen and (max-width: 990px) {
        .pricingTable {
            margin: 0 0 20px
        }
    }</style>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script type='text/javascript'
        src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>
<script src="https://widget.cloudpayments.ru/bundles/cloudpayments.js"></script>
<script type='text/javascript'></script>
<div class="demo">
    <div class="container text-center">
        <div class="row">
            <?php foreach($model as $item): ?>
            <?php if(!empty($item) && $item->day_30):
                $price = $item->price_30 - (($item->price_30 * $discount) /100);
                ?>
            <div class="col-md-3 col-sm-6">
                <div class="pricingTable green">
                    <div class="pricingTable-header">
                        <i class="fa fa-briefcase"></i>
                        <div class="price-value"> <?=$price.' '.$item->currency ?> <span class="month"><?=30?> дней</span></div>
                    </div>
                    <h3 class="heading"><?=$item->name?></h3>
                    <div class="pricing-content">
                        <ul>
                            <li><b>Страна: </b> <?=$item->country?></li>
                        </ul>
                    </div>
                    <div class="pricingTable-signup">
                        <a class="pay" data-id="<?=$item->id?>" data-period="<?=30?>" data-price="<?=$price?>" data-type="premium" href="#">Купить</a>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php if(!empty($item) && $item->day_180):
                $price = $item->price_180 - (($item->price_180 * $discount) /100);
                ?>
            <div class="col-md-3 col-sm-6">
                <div class="pricingTable green">
                    <div class="pricingTable-header">
                        <i class="fa fa-briefcase"></i>
                        <div class="price-value"> <?=$price.' '.$item->currency ?> <span class="month"><?=180?> дней</span></div>
                    </div>
                    <h3 class="heading"><?=$item->name?></h3>
                    <div class="pricing-content">
                        <ul>
                            <li><b>Страна: </b> <?=$item->country?></li>
                        </ul>
                    </div>
                    <div class="pricingTable-signup">
                        <a class="pay" data-id="<?=$item->id?>" data-period="<?=180?>" data-price="<?=$price?>" data-type="premium" href="#">Купить</a>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php if(!empty($item) && $item->day_365):
                $price = $item->price_365 - (($item->price_365 * $discount) /100);
                ?>
            <div class="col-md-3 col-sm-6">
                <div class="pricingTable green">
                    <div class="pricingTable-header">
                        <i class="fa fa-briefcase"></i>
                        <div class="price-value"> <?=$price.' '.$item->currency ?> <span class="month"><?=365?> дней</span></div>
                    </div>
                    <h3 class="heading"><?=$item->name?></h3>
                    <div class="pricing-content">
                        <ul>
                            <li><b>Страна: </b> <?=$item->country?></li>
                        </ul>
                    </div>
                    <div class="pricingTable-signup">
                        <a class="pay" data-id="<?=$item->id?>" data-period="365" data-price="<?=$price?>" data-type="premium" href="#">Купить</a>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</div>
