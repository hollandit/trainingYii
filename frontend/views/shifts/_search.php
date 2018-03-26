<?php

use app\models\Shop;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShiftsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shifts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_id')->dropDownList(
            ArrayHelper::map(User::find()->all(), 'id', 'nameEmployee'),
            [
                'prompt' => 'Выберите сотрудника',
                'value' => !Yii::$app->request->get() ? null : Yii::$app->request->get('ShiftsSearch')['user_id']
            ]
        ) ?>

    <?= $form->field($model, 'shop_id')->dropDownList(
            ArrayHelper::map(Shop::find()->all(), 'id', 'name'),
            [
                'prompt' => 'Выберите магазиг',
                'value' => !Yii::$app->request->get() ? null : Yii::$app->request->get('ShiftsSearch')['shop_id']
            ]
        ) ?>

    <?= $form->field($model, 'date')->textInput(['type' => 'week', 'value' => !Yii::$app->request->get() ? null : Yii::$app->request->get('ShiftsSearch')['date']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
