<?php
$script = <<<JS
this.pay = function () {
    var widget = new cp.CloudPayments();
    var receipt = {
            Items: [//товарные позиции
                 {
                    label: 'Наименование товара 3', //наименование товара
                    price: 300.00, //цена
                    quantity: 3.00, //количество
                    amount: 900.00, //сумма
                    vat: 20, //ставка НДС
                    method: 0, // тег-1214 признак способа расчета - признак способа расчета
                    object: 0, // тег-1212 признак предмета расчета - признак предмета товара, работы, услуги, платежа, выплаты, иного предмета расчета
                }
            ],
            taxationSystem: 0, //система налогообложения; необязательный, если у вас одна система налогообложения
            email: 'user@example.com', //e-mail покупателя, если нужно отправить письмо с чеком
            phone: '', //телефон покупателя в любом формате, если нужно отправить сообщение со ссылкой на чек
            isBso: false, //чек является бланком строгой отчетности
            amounts:
            {
                electronic: 900.00, // Сумма оплаты электронными деньгами
                advancePayment: 0.00, // Сумма из предоплаты (зачетом аванса) (2 знака после запятой)
                credit: 0.00, // Сумма постоплатой(в кредит) (2 знака после запятой)
                provision: 0.00 // Сумма оплаты встречным предоставлением (сертификаты, др. мат.ценности) (2 знака после запятой)
            }
        };

    var data = {};
    data.CloudPayments = {
        CustomerReceipt: receipt, //чек для первого платежа
        recurrent: {
         interval: 'Month',
         period: 1, 
         customerReceipt: receipt //чек для регулярных платежей
         }
         }; //создание ежемесячной подписки

    widget.charge({ // options
        publicId: 'pk_16424c5787dd7ebfbba47e66aafa8', //id из личного кабинета
        description: 'Подписка на ежемесячный доступ к сайту example.com', //назначение
        amount: 1000, //сумма
        currency: 'RUB', //валюта
        invoiceId: '1234567', //номер заказа  (необязательно)
        accountId: 'user@example.com', //идентификатор плательщика (обязательно для создания подписки)
        data: data
    },
    function (options) { // success
        $.ajax({
            url: "/payment-success",
            method: "POST",
            data: {
                tariff: "",
                status : true,
                orderId: "",
                amount: ""
            }
        })
    },
    function (reason, options) { // fail
        //действие при неуспешной оплате
    });
};
function orderNumber() {
  let now = Date.now().toString() // '1492341545873'
  // pad with extra random digit
  now += now + Math.floor(Math.random() * 10)
  // format
  return  [now.slice(0, 4), now.slice(4, 10), now.slice(10, 14)].join('-')
}
$(document).on('click', '#pay', function (e) {
        e.preventDefault();
        pay();
    });
JS;

$this->registerJs($script, $this::POS_END);

?>
<script src="https://widget.cloudpayments.ru/bundles/cloudpayments.js"></script>
<button id="pay" class="btn btn-primary">payment</button>