<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\models\Questions;
use app\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

\app\assets\AppAsset_::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          id="metaViewport">
    <meta name="apple-mobile-web-app-status-bar-style">
    <meta name="msapplication-navbutton-color">
    <meta name="theme-color">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          id="metaViewport">
    <meta name="twitter:title" content="VPN MAX">
    <meta property="og:title" content="VPN MAX">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="/web/img/default.png">
    <meta property="vk:image" content="/web/img/default.png">
    <meta name="twitter:image" content="/web/img/default.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="/web/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="/web//web/img//favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/web/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/web/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/web/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/web/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/web/img/favicon/safari-pinned-tab.svg" color="#00bdd7">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>


<div id="app">
    <div id="loader" class='active'></div>

    <header class="header <?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') echo '_full'; ?>">
        <div class="header-top">
            <div class="container">
                <div class="header-top-content">
                    <a href="/" class="header-logo">
                        <img src="/web/img/logo.svg">
                    </a>

                    <div class="header-menu">
                        <ul>
                            <li><a href="#features">Особенности</a></li>
                            <li><a href="#faq">Вопросы</a></li>
                            <li><a href="#feedbacks">Отзывы</a></li>
                            <li><a href="#prices">Цены</a></li>
                        </ul>
                    </div>

                    <div class="header-actions">
                        <div class="header-buttons">
                            <a href="#" class="btn">Скачать</a>
                            <?php if (Yii::$app->user->isGuest): ?>
                                <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>"
                                   class="btn">Войти</a>
                            <?php else: ?>

                                <?php $userId = Yii::$app->user->identity->getId();
                                if (!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])): ?>
                                    <a href="<?= \yii\helpers\Url::to(['/vpn-user-settings/']) ?>"
                                       class="btn">Профиль</a>
                                <?php else: ?>
                                    <?php if ((Yii::$app->controller->id != 'site')): ?>
                                        <?php echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline my-2 my-lg-0'])
                                            . Html::submitButton(
                                                'Выйти',
                                                ['class' => 'btn btn-link logout']
                                            )
                                            . Html::endForm(); ?>
                                    <?php else: ?>
                                        <a href="<?= \yii\helpers\Url::to(['/user/settings/account']) ?>"
                                           class="btn">Профиль</a>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>

                        <div class="header-langs">
                            <div class="header-langs-current">
                                <img src="/web/img/langs-ru.svg">
                            </div>
                            <div class="header-langs-items">
                                <a href="#" class="header-langs-item">
                                    <img src="/web/img/langs-en.png">
                                </a>
                            </div>
                        </div>

                        <div id="mob-menu-btn">
                            <button class="hamburger hamburger--elastic" type="button">
									<span class="hamburger-box">
										<span class="hamburger-inner"></span>
									</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'): ?>
            <div class="container">
                <div class="header-intro">
                    <div class="header-intro-img">
                        <img src="/web/img/header-intro-img.svg">
                    </div>

                    <h1 class="title-1">
                        Быстрый и <br>
                        анонимный доступ <br>
                        к любым сайтам
                    </h1>

                    <a href="#sign" style="text-decoration: none; color: #fff; ">
                        <button style="margin-top: 30px;" class="btn-2">Попробовать бесплатно</button>
                    </a>

                </div>
            </div>
        <?php endif; ?>
    </header>

    <div id="content">
        <div class="header-mob">
            <div class="header-mob-content">
                <a href="#" class="header-logo">
                    <img src="/web/img/logo.svg">
                </a>

                <div class="spacer"></div>

                <div class="header-menu">
                    <ul>
                        <li><a href="#features">Особенности</a></li>
                        <li><a href="#faq">Вопросы</a></li>
                        <li><a href="#feedbacks">Отзывы</a></li>
                        <li><a href="#prices">Цены</a></li>
                    </ul>
                </div>

                <div class="spacer"></div>

                <div class="header-actions">
                    <div class="header-buttons">
                        <a href="#" class="btn">Скачать</a>
                        <?php if (Yii::$app->user->isGuest): ?>
                            <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>"
                               class="btn">Войти</a>
                        <?php else: ?>

                            <?php $userId = Yii::$app->user->identity->getId();
                            if (!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])): ?>
                                <a href="<?= \yii\helpers\Url::to(['/vpn-user-settings/']) ?>"
                                   class="btn">Профиль</a>
                            <?php else: ?>
                                <?php if (!Yii::$app->controller->id == 'site'): ?>
                                    <?php echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline my-2 my-lg-0'])
                                        . Html::submitButton(
                                            'Выйти',
                                            ['class' => 'btn btn-link logout']
                                        )
                                        . Html::endForm(); ?>
                                <?php else: ?>
                                    <a href="<?= \yii\helpers\Url::to(['/user/settings/account']) ?>"
                                       class="btn">Профиль</a>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                    <div class="header-langs">
                        <div class="header-langs-current">
                            <img src="/web/img/langs-ru.svg">
                        </div>
                        <div class="header-langs-items">
                            <a href="#" class="header-langs-item">
                                <img src="/web/img/langs-en.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ((Yii::$app->controller->id == 'tariff' || Yii::$app->controller->action->id == 'account' || Yii::$app->controller->id == 'vpn-ips' || Yii::$app->controller->action->id == 'config' || Yii::$app->controller->id == 'tariff' ||
            (Yii::$app->controller->id == 'categories' && !Yii::$app->user->isGuest)
        )): ?>
            <?php echo $this->render('account_nav', ['cabinet' => true]); ?>
        <?php endif; ?>
        <?= $content ?>



        <?php $this->endBody() ?>


    </div>

    <footer class="footer">
        <div class="container">

            <div class="footer-top">
                <a href="#" class="footer-logo">
                    <img src="/web/img/logo.svg">
                </a>

                <div class="footer-socials" style="display: none">
                    <a href='#' class="footer-socials-item"><img src="/web/img/footer-socials-1.svg"></a>
                    <a href='#' class="footer-socials-item"><img src="/web/img/footer-socials-2.svg"></a>
                    <a href='#' class="footer-socials-item"><img src="/web/img/footer-socials-3.svg"></a>
                    <a href='#' class="footer-socials-item"><img src="/web/img/footer-socials-4.svg"></a>
                    <a href='#' class="footer-socials-item"><img src="/web/img/footer-socials-5.svg"></a>
                </div>

                <div class="footer-data">
                    <div class="footer-text">VPN MAX, 2020-<?=date("Y")?></div>
                    <a href="/site/privacy" class="footer-text">Политика конфиденциальности</a>
                </div>
            </div>

            <div class="footer-developer">
                <div class="footer-developer-text">Разработка и создание сайта</div>
                <a href='#' class="footer-developer-logo"><img src="/web/img/footer-developer-logo.svg"></a>
            </div>
        </div>
    </footer>
</div>

<?php echo $this->render('_modals', ['model' => new Questions()]); ?>

</body>
</html>
<?php $this->endPage() ?>
