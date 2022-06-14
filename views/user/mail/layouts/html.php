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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/email.css?<?= $app->hash ?>">
</head>
<?php $class = '@@class' ?>
<?php $root = 'https://www.vpn-max.com/web/' ?>
<body class="@@class">
<!-- все картинки должны быть с полным путем к сайту -->

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
