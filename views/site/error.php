<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;
$this->title = $name;
?>
<?php echo $this->render('404', ['exception' => $exception,'title' => $name]); ?>
