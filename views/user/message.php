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
 * @var yii\web\View $this
 * @var dektrium\user\Module $module
 */

$this->title = $title;
$url= \yii\helpers\Url::to(['/user/settings/account']);
if(!empty($redirect) && $redirect){
    echo "<script> setTimeout(function () {
    window.location.href = '$url';
},3000) </script>";
}
?>
<?= $this->render('/_alert', ['module' => $module]);
