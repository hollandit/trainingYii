<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div>
    <?php $form = ActiveForm::begin([
        'id' => 'update-theme'
    ]) ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <div class="create-test_control">
        <hr>
        <div class="col-lg-8">
            <p>Укажите количество времени для теста:</p>
        </div>
        <div class="col-lg-4 update-time">
            <?=
            $form->field($model, 'minute')->textInput(['type' => 'number', 'class' => 'create-test_timeInput', 'min' => 0, 'max' => '59'])->label(false).
            Html::input('text', null, ':', ['class' => 'control-operator', 'disabled' => true]).
            $form->field($model, 'second')->textInput(['type' => 'number', 'class' => 'create-test_timeInput', 'min' => '0', 'max' => '59'])->label(false) ?>
        </div>
        <hr>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>