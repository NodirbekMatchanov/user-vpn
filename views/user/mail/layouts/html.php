<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var \yii\web\View $this
 * @var yii\mail\BaseMessage $content
 */
?>
<!DOCTYPE html>
<html lang="ru">
<?php $root = 'https://www.vpn-max.com/web/' ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$root?>/tmp/public/css/email.css?<?= time() ?>">
</head>
<?php $class = '@@class' ?>
<style>
    main > .container {
        padding: 70px 15px 20px;
    }

    .footer {
        background-color: #f5f5f5;
        font-size: .9em;
        height: 60px;
    }
    .question {
        color: #56b366;
    }

    .NoActiveStatus {
        background:   #B9B9B9;
    }
    .DeletedStatus {
        background: #FFC4C4 ;
    }
    .ActiveStatus {
        background: #def7d3;
    }

    html, body{
        height: 100%;
    }
    .wrap_ {
        min-height: 100%;
        height: auto;
        padding: 0 0 60px;
    }
    .clearfix:before, .clearfix:after, .nav:before, .nav:after, .navbar:before, .navbar:after, .navbar-header:before, .navbar-header:after, .navbar-collapse:before, .navbar-collapse:after{
        display:none;
    }
    .navbar .container, .navbar .container-fluid, .navbar .container-sm, .navbar .container-md, .navbar .container-lg, .navbar .container-xl{
        display: block!important;
    }
    body {
        font-size: 14px!important;
        line-height: 1.42857143!important;
    }
    .footer > .container {
        padding-right: 15px;
        padding-left: 15px;
    }
    .navbar-nav{
        flex-direction:row!important;
    }
    .navbar-brand {
        float: left!important;
        height: 50px!important;
        padding: 15px 15px!important;
        font-size: 18px!important;
        line-height: 20px!important;
    }
    .not-set {
        color: #c55;
        font-style: italic;
    }

    /* add sorting icons to gridview sort links */
    a.asc:after, a.desc:after {
        content: '';
        left: 3px;
        display: inline-block;
        width: 0;
        height: 0;
        border: solid 5px transparent;
        margin: 4px 4px 2px 4px;
        background: transparent;
    }

    a.asc:after {
        border-bottom: solid 7px #212529;
        border-top-width: 0;
    }

    a.desc:after {
        border-top: solid 7px #212529;
        border-bottom-width: 0;
    }

    .grid-view th {
        white-space: nowrap_;
    }

    .hint-block {
        display: block;
        margin-top: 5px;
        color: #999;
    }

    .error-summary {
        color: #a94442;
        background: #fdf7f7;
        border-left: 3px solid #eed3d7;
        padding: 10px 20px;
        margin: 0 0 15px 0;
    }

    /* align the logout "link" (button in form) of the navbar */
    .nav li > form > button.logout {
        padding-top: 7px;
        color: rgba(255, 255, 255, 0.5);
    }

    @media(max-width:767px) {
        .nav li > form > button.logout {
            display:block;
            text-align: left;
            width: 100%;
            padding: 10px 0;
        }
    }

    .nav > li > form > button.logout:focus,
    .nav > li > form > button.logout:hover {
        text-decoration: none;
        color: rgba(255, 255, 255, 0.75);
    }

    .nav > li > form > button.logout:focus {
        outline: none;
    }

</style>

<body class="@@class">
<!-- все картинки должны быть с полным путем к сайту -->
ыы
<div class="wrap">

    <div class="header">
        <div class="header-logo">
            <!-- только png/jpg -->
            <img src="<?= $root ?>/img/logo.png" alt="">
        </div>
    </div>
                            <?= $content ?>
    <div class="footer">
        <div class="socials">

            <?php if ($class == '_dark'): ?>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-inst.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-fb.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-tw.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-youtube.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-tg.png" alt="">
                </a>
            <?php else: ?>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-inst.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-fb.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-tw.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-youtube.png" alt="">
                </a>
                <a href="#" class="socials-item">
                    <img src="<?= $root ?>/img/icons/email-socials-telegram.png" alt="">
                </a>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
