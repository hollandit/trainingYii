<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div>
    <?php $form = ActiveForm::begin([
        'id' => 'update-theme'
    ]) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['test/delete-theme', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>