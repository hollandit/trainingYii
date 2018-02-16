<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Knowledge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="knowledge-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'text')->widget(Widget::className(),
        [
            'settings' => [
                'lang' => 'ru',
                'buttons' => ['bold', 'italic','deleted', 'unorderedlist', 'orderedlist', 'link'],
            ],
        ]) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true, 'placeholder' => 'Введите ссылку с youtube']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
