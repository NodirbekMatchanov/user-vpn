<!DOCTYPE html>
<html lang="ru">
<?php $root = 'https://www.vpn-max.com/web/' ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$root?>/tmp/public/css/email.css?<?= time() ?>">
</head>
<?php $class = '@@class' ?>
<body class="@@class">
<!-- все картинки должны быть с полным путем к сайту -->

<div class="wrap">

    <div class="header">
        <div class="header-logo">
            <!-- только png/jpg -->
            <img src="<?= $root ?>/img/logo.png" alt="">
        </div>
    </div>