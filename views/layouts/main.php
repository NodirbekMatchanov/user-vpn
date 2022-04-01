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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<div class="wrap">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => "Vpn",
        'brandUrl' => '/',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $item=[];

        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->getId();
            if(!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])) {


                $item = [
                ['label' => 'Пользователи', 'url' => ['/web/vpn-user-settings/index']],
                ['label' => 'Cерверы', 'url' => ['/web/vpn-ips/index']],
                ['label' => 'Справочник', 'url' => ['/web/support/index']],
                ['label' => 'Шаблоны', 'url' => ['/web/mail-template/index']],
                ['label' => 'История отправки', 'url' => ['/mail-history/index']]
            ];
        } else {
                $item = [
                    ['label' => 'Мой профиль', 'url' => ['/user/settings/profile']],
                    ['label' => 'VPN', 'url' => ['/vpn-user-settings/my-vpn']],
                    ['label' => 'Серверы', 'url' => ['/vpn-ips/list']],
                ];
            }
        }

        $items = [
            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
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
            $items[] = ['label' => 'Sign', 'url' => ['/user/register']];
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

<footer class="footer mt-auto py-3 text-muted" >
    <div class="container">
        <br>
        <p class="float-right">VPN MAX</p>
    </div>
</footer>
</body>
</html>
<?php $this->endPage() ?>
