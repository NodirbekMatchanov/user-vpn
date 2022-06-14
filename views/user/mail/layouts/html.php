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
</head>
<?php $class = '@@class' ?>

<body class="@@class" style="box-sizing: border-box; color: #232323; font-family: Arial, sans-serif; font-weight: 400; line-height: 1.1; margin: 0; max-width: 100%; outline: none; padding: 0;">
<!-- все картинки должны быть с полным путем к сайту -->

<div class="wrap" style="background: #fff; box-sizing: border-box; margin-left: auto; margin-right: auto; max-width: 600px; outline: none;">

    <div class="header" style="box-sizing: border-box; max-width: 100%; outline: none; padding: 60px 50px 0; text-align: center;">
        <div class="header-logo" style="box-sizing: border-box; display: inline-block; max-width: 100%; outline: none;">
            <!-- только png/jpg -->
            <img src="<?= $root ?>/img/logo.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none; width: 120px;">
        </div>
    </div>
                            <?= $content ?>

    <div class="footer" style="background: #F5F8FB; box-sizing: border-box; max-width: 100%; outline: none; padding: 28px 50px; width: 100%;">
        <div class="socials" style="box-sizing: border-box; margin-left: auto; margin-right: auto; max-width: 100%; outline: none; text-align: center;">

            <?php if ($class == '_dark'): ?>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-inst.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-fb.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 13px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-tw.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 13px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-youtube.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-blue-tg.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
            <?php else: ?>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-inst.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-fb.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-tw.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-youtube.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
                <a href="#" class="socials-item" style="background: #555555; border-radius: 50%; box-sizing: border-box; color: #4A90E2; display: inline-block; height: 45px; margin-left: 3px; margin-right: 3px; max-width: 100%; outline: none; overflow: hidden; padding-top: 10px; text-align: center; width: 45px;">
                    <img src="<?= $root ?>/img/icons/email-socials-telegram.png" alt style="-moz-user-select: none; -ms-interpolation-mode: bicubic; -ms-user-select: none; -o-object-fit: contain; -webkit-backface-visibility: hidden; -webkit-user-select: none; backface-visibility: hidden; border: 0; box-sizing: border-box; display: inline-block; height: auto; line-height: 100%; max-width: 100%; object-fit: contain; outline: none; text-decoration: none; user-select: none;">
                </a>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
