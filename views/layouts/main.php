<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" id="metaViewport">
    <meta name="apple-mobile-web-app-status-bar-style">
    <meta name="msapplication-navbutton-color">
    <meta name="theme-color">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<div class="wrap_">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => "VPN MAX",
            'brandUrl' => '/'. Yii::$app->language,
            'innerContainerOptions' => ['class' => 'container-fluid'],
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $item = [];

        if (Yii::$app->user->isGuest) {
            $item = [
                ['label' => 'Справочник', 'url' => ['/support/categories']],
            ];
        }
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->getId();
            if (!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])) {
                $item = [
                    ['label' => 'Пользователи', 'url' => ['/vpn-user-settings/index']],
                    ['label' => 'Cерверы', 'url' => ['/vpn-ips/index']],

                    ['label' => 'Промокоды', 'url' => ['/promocodes/index']],
                    ['label' => 'Настройки', 'url' => ['/settings/index']],
                    ['label' => 'Тариф', 'url' => ['/tariff/list']],
                    [
                        'label' => 'Справочник',
                        'items' => [
                            ['label' => 'Справочник', 'url' => ['/support/index']],
                            ['label' => 'Страны', 'url' => ['/country/index']],
                            ['label' => 'Событии', 'url' => ['/user-events/index']],
                            ['label' => 'Отправка пуши', 'url' => ['/push-test/index']],
                            ['label' => 'DNS', 'url' => ['/dns-servers/index']],
                            ['label' => 'История отправки', 'url' => ['/mail-history/index']],
                            ['label' => 'Шаблоны уведомлений', 'url' => ['/mail-template/index']],
                            ['label' => 'Переводы', 'url' => ['/translations/index']]
                        ],
                    ],
                ];
            } else {
                $item = [
                    ['label' => 'Мой профиль', 'url' => ['/user/settings/account']],
                    ['label' => 'Серверы', 'url' => ['/vpn-ips/list']],
                    ['label' => 'Справочник', 'url' => ['/support/categories']],
//                    ['label' => 'Тариф', 'url' => ['/tariff/index']],
//                    ['label' => 'Промокоды', 'url' => ['/used-promocodes/index']],
//                    ['label' => 'Покупки', 'url' => ['/payment/index']],

                ];
            }
        }

        $items = [
            Yii::$app->user->isGuest ? (
            ['label' => 'Вход', 'url' => ['/site/login']]
            ) : (
                '<li class="form-inline my-2 my-lg-0" style="padding: 8px;">'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline my-2 my-lg-0'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ];
        if (Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Регистрация', 'url' => ['/user/register']];
        }
        $items = array_merge($item, $items);


        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $items,
        ]);
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>


    <?php $this->endBody() ?>
</div>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container" style="    padding-top: 23px;">
        <span class="float-right">VPN MAX</span>
        <a class="pull-right" href="/site/privacy" target="_blank"> Политика конфиденциальности</a>
    </div>
</footer>
</body>
</html>
<?php $this->endPage() ?>
