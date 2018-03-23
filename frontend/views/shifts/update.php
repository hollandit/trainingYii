<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shifts */

$this->title = 'Update Shifts: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Shifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shifts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model', 'user')) ?>

</div>
