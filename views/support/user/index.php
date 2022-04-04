<?php
/* @var $data app\models\Support */
/* @var $dataProvider app\models\Support */
$this->title = 'Справочник';
$this->params['breadcrumbs'][] = $this->title;
$category = '';
if($category = Yii::$app->request->get('category')){
    $this->params['breadcrumbs'][] = $category;
}
?>

<div class="row">
    <div class="col-sm-3">
        <?= $this->render('_sidebar', [
            'data' => $data,
        ]) ?>
    </div>
    <div class="col-sm-9">
        <?php if(Yii::$app->request->get('id')):?>
            <?= $this->render('_view', [
                'model' => $model,
            ]) ?>
        <?php else:?>
            <h3><?= ($category) ? $category : 'Все'?></h3>
            <?=
            \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'viewParams' => [
                    'fullView' => true,
                    'context' => 'main-page',
                ],
            ]);
            ?>
        <?php endif;?>
    </div>
</div>
