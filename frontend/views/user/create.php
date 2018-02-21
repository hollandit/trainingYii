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
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Логин'])->label(false) ?>

            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Фамилия'])->label(false) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Имя'])->label(false) ?>

            <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true, 'placeholder' => 'Отчество'])->label(false) ?>

            <?= $form->field($model, 'id_position')->dropDownList(
                    ArrayHelper::map(
                            Position::find()->all(),
                            'id',
                            'name'
                    ), [
                        'prompt' => 'Должность',
                        'required' => true
                    ])->label(false) ?>

            <?= $form->field($model, 'date_birth')->textInput(['type' => 'date', 'placeholder' => 'Дата рождение'])->label(false) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>

</div>
