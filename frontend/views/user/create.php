<?php

use app\models\Position;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Создать сотрудника';
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->label('Логин') ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label('Фамилия') ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Имя') ?>

        <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true])->label('Отчество') ?>

        <?= $form->field($model, 'id_position')->dropDownList(ArrayHelper::map(Position::find()->all(), 'id', 'name'))->label('Должность') ?>

        <?= $form->field($model, 'date_birth')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
