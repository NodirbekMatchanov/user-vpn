<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Проверка push-уведомлений';
$this->params['breadcrumbs'][] = [
    'label' => 'Параметры',
    'url' => '/setting/'
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo Html::encode($this->title) ?></h1>
<div class="push-test-index">
<div style="margin-bottom: 40px;">
<?php Pjax::begin(['id' => 'result', 'enablePushState' => false, 'timeout'=>false]); ?>
<?php $form = ActiveForm::begin([
   'options' => ['data-pjax' => true ],
   'action'  => ['index'],
   'method'  => 'post'
]); ?>
<?= $form->field($model, "fcm_token")->textarea(['rows' => 2 ]) ?>
<?= $form->field($model, "ios_token")->textarea(['rows' => 2 ]) ?>
<?= $form->field($model, "title") ?>
<?= $form->field($model, "body")->textarea([ "rows" => 4 ]) ?>

<div class="form-group">
<?php echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php if ($fcm_result) { ?>
<p>Android:</p>
<pre>
<?php if (isset($fcm_result[2])) { ?>
<?php     foreach ($fcm_result[2] as $header => $vals) { ?>
<?php         foreach ($vals as $v) { ?>
<?= $header ?>: <?= $v ?>  
<?php         } ?>
<?php     } ?>

<?php if (isset($fcm_result[1])) { ?>
<?= json_encode($fcm_result[1], JSON_PRETTY_PRINT) ?>
<?php } ?>
<?php } ?>
</pre>
<?php } ?>
<?php if ($ios_result) { ?>
<p>iOS</p>
<pre>
<?= $ios_result[1] ?>
</pre>
<?php } ?>

<?php Pjax::end(); ?>
</div>
</div>
