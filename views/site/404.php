<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */
use yii\helpers\Html;

?>

<div class="error">
	<div class="container">
		<div class="error-wrap">
			<div class="error-img">
				<img src="/web/img/error-1.svg">
			</div>
			<div class="error-content">
				<div class="error-img-2">
					<img src="/web/img/error-2.svg">
				</div>
				<h1 class="error-title"><?= Html::encode(Yii::$app->response->getStatusCode()) ?></h1>
				<div class="error-text"><?= nl2br(Html::encode($exception->getMessage())) ?></div>
				<a href="/" style="text-decoration: none"><button class="btn-2">На главную</button></a>
			</div>
		</div>
	</div>
</div>

