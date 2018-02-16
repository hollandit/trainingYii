<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Knowledge */

$this->title = 'Редактировать статью';
?>
<div class="knowledge-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
