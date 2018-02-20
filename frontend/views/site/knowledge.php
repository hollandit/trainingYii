<?php

use frontend\components\NavKnowledge;
use yii\helpers\Html;

$this->title = 'База знаний';
$model = $model[0];
?>

<div class="site-index">
    <div class="col-lg-3 navBar-Thema test-contant">
        <?php echo NavKnowledge::widget() ?>
    </div>
    <div class="col-lg-9">
        <h2><?= Html::encode($model->title) ?></h2>
        <?php if ($model->video != null ) {
            echo '<iframe width="560" height="315" src='.$model->video.' frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        } else {
            echo '';
        } ?>
        <div><?php echo $model->text ?></div>
    </div>
</div>