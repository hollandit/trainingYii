<?php

use andkon\yii2kladr\Kladr;
use app\models\Position;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;


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

            <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                'mask' => '8(999)999-99-99',
                'options' => [
                    'placeholder' => 'Телефон',
                    'class' => 'form-control'
                ]
            ])->label(false) ?>

            <?= $form->field($model, 'city')->widget(Kladr::className(), [
                'type' => Kladr::TYPE_CITY,
                'options' => [
                    'placeholder' => 'Город',
                    'class' => 'form-control'
                ]
            ])->label(false) ?>

            <?= Html::input('text', 'city_name', '', ['class' => 'city-name']) ?>

            <?= $form->field($model, 'street')->widget(Kladr::className(), [
                'type' => Kladr::TYPE_STREET,
                'options' => [
                    'placeholder' => 'Улица',
                    'class' => 'form-control'
                ]
            ])->label(false) ?>

            <?= Html::input('text', 'street_name', '', ['class' => 'street-name']) ?>

            <?= $form->field($model, 'build')->widget(Kladr::className(), [
                'type' => Kladr::TYPE_BUILDING,
                'options' => [
                    'placeholder' => 'Дом',
                    'class' => 'form-control'
                ]
            ])->label(false) ?>

            <?= Html::input('text', 'build_name', '', ['class' => 'build-name']) ?>

            <?= $form->field($model, 'appartament')->textInput(['maxlength' => true, 'placeholder' => 'Квартира'])->label(false) ?>

            <?= $form->field($model, 'id_position')->dropDownList(
                    ArrayHelper::map(
                            Position::find()->all(),
                            'id',
                            'name'
                    ), [
                        'prompt' => 'Должность',
                        'required' => true
                    ])->label(false) ?>

            <?= $form->field($model, 'salary')->textInput(['type' => 'number', 'placeholder' => 'Оклад'])->label(false) ?>

            <?= $form->field($model, 'date_birth')->textInput(['type' => 'date', 'placeholder' => 'Дата рождение'])->label(false) ?>

            <?= $form->field($model, 'email')->textInput(['type' => 'email','placeholder' => 'Email'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['type' => 'password','placeholder' => 'Пароль'])->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>

</div>
