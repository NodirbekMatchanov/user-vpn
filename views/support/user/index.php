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


<div class="container" style="margin-top: 50px">


    <?php if(!$category):?>

        <h1 class="title-2">Ответы от команды VPN MAX</h1>

    <?php else:?>
        <div class="breadcrumbs">
            <ul>
                <li><a href='<?=\yii\helpers\Url::to(['/support/categories'])?>'>Все ответы</a></li>
                <li><a href="#"><?= ($category) ?></a></li>
            </ul>
        </div>
    <?php endif;?>

    <form class="questions-form">
        <div class="questions-form-icon"><img src="/web/img/icons/search.svg" alt=""></div>
        <input type="text" placeholder='Поиск ответов' name='s' required>
    </form>
<br>
    <div class="row">

            <?php if(Yii::$app->request->get('id')):?>
                <?= $this->render('_view', [
                    'model' => $model,
                ]) ?>
            <?php else:?>
            <div class="questions">
                <div class="container">
                    <div class="questions-content">
                      <?php if(!$category):?>
                          <?= $this->render('questions', [
                              'data' => $data,
                          ]) ?>
                            <?php else: ?>
                        <h1 class="title-3"><?= ($category) ?></h1>
                        <div class="questions-items">

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
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>

</div>