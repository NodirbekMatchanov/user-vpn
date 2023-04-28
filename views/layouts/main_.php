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
use \yii\helpers\Url;

\app\assets\AppAsset_::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" id="metaViewport">

    <title><?=\Yii::t('app', 'web-meta-title');?></title>
    <meta name="twitter:title" content="<?=\Yii::t('app', 'web-meta-title');?>">
    <meta property="og:title" content="<?=\Yii::t('app', 'web-meta-title');?>">

    <meta name="description" content="<?=\Yii::t('app', 'web-meta-title');?>">
    <meta property="og:description" content="<?=\Yii::t('app', 'web-meta-title');?>">
    <meta property="og:image" content="/web/img/logo.png">
    <meta property="vk:image" content="/web/img/logo.png">
    <meta name="twitter:image" content="/web/img/logo.png">
    <link rel="shortcut icon" href="/web/img/favicon/favicon.ico" type="image/x-icon">


    <link rel="manifest" href="/web/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/web/img/favicon/safari-pinned-tab.svg" color="#00bdd7">
    <meta name="msapplication-TileColor" content="#008CF2">

    <meta name="theme-color" content="#008CF2">
    <meta name="msapplication-navbutton-color" content="#008CF2">
    <meta name="apple-mobile-web-app-status-bar-style" content="#008CF2">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          id="metaViewport">
    <meta name="apple-mobile-web-app-status-bar-style">
    <meta name="msapplication-navbutton-color">
    <meta name="theme-color">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          id="metaViewport">


    <link rel="apple-touch-icon" sizes="180x180" href="/web/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/web/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/web/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/web/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/web/img/favicon/safari-pinned-tab.svg" color="#00bdd7">
    <meta name="msapplication-TileColor" content="#008CF2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="/web/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="/web/img/favicon/favicon.ico" type="image/x-icon">
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
                    <a href="/<?=Yii::$app->language?>" class="header-logo">
                        <img src="/web/img/logo.svg">
                    </a>

                    <div class="header-menu">
                        <ul>
                            <li><a href="#features"><?=\Yii::t('app', 'web-menu-menu-1');?></a></li>
                            <li><a href="#faq"><?=\Yii::t('app', 'web-menu-menu-2');?></a></li>
                            <li><a href="#feedbacks"><?=\Yii::t('app', 'web-menu-menu-3');?></a></li>
                            <li><a href="#prices"><?=\Yii::t('app', 'web-menu-menu-4');?></a></li>
                        </ul>
                    </div>

                    <div class="header-actions" style="
    display: -webkit-inline-box;">
                        <div class="header-buttons">
                            <a href="<?=Url::to('https://apps.apple.com/app/vpn-max/id1619787851')?>" target="_blank" class="btn"><?=\Yii::t('app', 'web-button-download');?></a>
                            <?php if (Yii::$app->user->isGuest): ?>
                                <a href="<?= Url::to(Yii::$app->params['backendUrl'].'/'.Yii::$app->language.'/site/login?language='. Yii::$app->language) ?>"
                                   class="btn"><?=\Yii::t('app', 'web-login-title');?></a>
                            <?php else: ?>

                                <?php $userId = Yii::$app->user->identity->getId();
                                if (!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])): ?>
                                    <a href="<?= Url::to(Yii::$app->params['backendUrl'].'/'.Yii::$app->language.'/vpn-user-settings/') ?>"
                                       class="btn"><?=\Yii::t('app', 'web-profile-button');?></a>
                                <?php else: ?>
                                    <?php if ((Yii::$app->controller->id != 'site')): ?>
                                        <?php echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline my-2 my-lg-0'])
                                            . Html::submitButton(
                                                \Yii::t('app', 'web-button-logout'),
                                                ['class' => 'btn btn-link logout']
                                            )
                                            . Html::endForm(); ?>
                                    <?php else: ?>
                                        <a href="<?= Url::to(['/user/settings/account']) ?>"
                                           class="btn"><?=\Yii::t('app', 'web-profile-button');?></a>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>

                        <div class="header-langs" style=" font-size: 25px; box-shadow: none; text-align: center; ">
                            <div class="header-langs-current" style="text-decoration: none;    outline: none;    color: inherit; width: 50px;">
                                <?=Yii::$app->language?>
                            </div>
                            <div class="header-langs-items">
                                <a href="<?='/site/change-language?language='.(Yii::$app->language == 'ru' ? 'en' : 'ru')?>" class="header-langs-item">
                                    <?=(Yii::$app->language == 'ru') ? 'en' : 'ru'?>
                                </a>
                            </div>
                        </div>
                        <div id="mob-menu-btn-lng" style="margin-right:15px;margin-top: -8px;">
                                 <div class="header-langs" style="display: inline; font-size: 25px; box-shadow: none; text-align: center; ">
                                    <div class="header-langs-current" style="text-decoration: none;    outline: none;    color: inherit; width: 50px;">
                                        <?=Yii::$app->language?>
                                    </div>
                                    <div class="header-langs-items" style="">
                                        <a href="<?='/site/change-language?language='.(Yii::$app->language == 'ru' ? 'en' : 'ru')?>" class="header-langs-item">
                                            <?=(Yii::$app->language == 'ru') ? 'en' : 'ru'?>
                                        </a>
                                    </div>
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

                    <span class="title-1">
                       <?=\Yii::t('app', 'web-home-subtitle-1');?>
                    </span>

                    <a href="#sign" style="text-decoration: none; color: #fff; ">
                        <button style="margin-top: 30px;" class="btn-2"><?=\Yii::t('app', 'web-button-try-free');?></button>
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
                        <li><a href="#features"><?=\Yii::t('app', 'web-menu-menu-1');?></a></li>
                        <li><a href="#faq"><?=\Yii::t('app', 'web-menu-menu-2');?></a></li>
                        <li><a href="#feedbacks"><?=\Yii::t('app', 'web-menu-menu-3');?></a></li>
                        <li><a href="#prices"><?=\Yii::t('app', 'web-menu-menu-4');?></a></li>
                        <li><a href="#" data-mfp-src="question"><?=\Yii::t('app', 'web-link-footer-3');?></a></a></li>
                        <li><a href="<?= Url::to(Yii::$app->params['backendUrl'].'/'.Yii::$app->language.'/support/categories') ?>"><?=\Yii::t('app', 'web-button-knowledge');?></a></li>
                    </ul>
                </div>

                <div class="spacer"></div>

                <div class="header-actions">



                    <div class="header-buttons">
                        <a href="<?=Url::to('https://apps.apple.com/app/vpn-max/id1619787851')?>" class="btn"><?=\Yii::t('app', 'web-button-download');?></a>
                        <?php if (Yii::$app->user->isGuest): ?>
                            <a href="<?= Url::to(Yii::$app->params['backendUrl'].'/'.Yii::$app->language.'/site/login?language='. Yii::$app->language) ?>"
                               class="btn"><?=\Yii::t('app', 'web-login-title');?></a>
                        <?php else: ?>

                            <?php $userId = Yii::$app->user->identity->getId();
                            if (!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])): ?>
                                <a href="<?= Url::to(['/vpn-user-settings/']) ?>"
                                   class="btn"><?=\Yii::t('app', 'web-profile-button');?></a>
                            <?php else: ?>
                                <?php if (!Yii::$app->controller->id == 'site'): ?>
                                    <?php echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline my-2 my-lg-0'])
                                        . Html::submitButton(
                                            \Yii::t('app', 'web-button-logout'),
                                            ['class' => 'btn btn-link logout']
                                        )
                                        . Html::endForm(); ?>
                                <?php else: ?>
                                    <a href="<?= Url::to(['/user/settings/account']) ?>"
                                       class="btn"><?=\Yii::t('app', 'web-profile-button');?></a>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>


                </div>
            </div>
        </div>
        <?php if ((Yii::$app->controller->id == 'tariff' || Yii::$app->controller->action->id == 'account' || Yii::$app->controller->id == 'vpn-ips' || Yii::$app->controller->action->id == 'config' || Yii::$app->controller->id == 'tariff' ||
            (Yii::$app->controller->id == 'support' && !Yii::$app->user->isGuest)
        )): ?>
            <?php echo $this->render('account_nav', ['cabinet' => true]); ?>
        <?php endif; ?>
        <?= $content ?>



        <?php $this->endBody() ?>


    </div>

    <footer class="footer">
        <script
                data-text="<?=\Yii::t('app', 'web-configuration-text-1');?>"
                data-button="<?=\Yii::t('app', 'button-accept');?>"
                data-expire="30"
                data-style="display: flex;justify-content: center;"
                type="text/javascript"
                id="cookieWarn"
                src="js/cookie-warn.min.js">
        </script>
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
                    <a href="/privacy" class="footer-text"><?=\Yii::t('app', 'web-link-footer-1');?></a>
                    <a href="/tos" class="footer-text"><?=\Yii::t('app', 'web-link-footer-2');?></a>
                    <a href="#" data-mfp-src="question" class="footer-text"><?=\Yii::t('app', 'web-link-footer-3');?></a>
                    <a href="<?= Url::to(Yii::$app->params['backendUrl'].'/'.Yii::$app->language.'/support/categories') ?>"  class="footer-text"><?=\Yii::t('app', 'web-button-knowledge');?></a>

                </div>
            </div>

        </div>
    </footer>
</div>

<?php echo $this->render('_modals', ['model' => new Questions()]); ?>
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(92893803, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
