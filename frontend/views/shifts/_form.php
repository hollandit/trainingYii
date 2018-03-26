<?php

use app\models\Shop;
use kartik\time\TimePicker;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shifts */
/* @var $form yii\widgets\ActiveForm */
$months = [1 => 'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];
$days = [1 => 'Пнд', 'Втр', 'Срд', 'Чтв', 'Птн', 'Суб', 'Вск'];
$month = $months[date('n', strtotime($model->date))];
$weekend = $days[date('N', strtotime($model->date))];
$year = date('Y', strtotime($model->date));
$day = date('d', strtotime($model->date));
?>

<div class="shifts-form">
    <?= Html::beginForm(['#'], 'post', $model->isNewRecord ? ['id' => 'create-shifts'] : ['id' => 'edit-shifts', 'data-id' => $model->id]) ?>
    <div class="col-lg-6 form-group">
        <?= Html::dropDownList('user', $model->isNewRecord ? null : $model->user_id, ArrayHelper::map($user, 'id', 'nameEmployee'), ['prompt' => 'Выберите сотрудника', 'class' => 'form-control']) ?>
    </div>
    <div class="col-lg-6 form-group">
            <?= Html::dropDownList('shop', $model->isNewRecord ? null : $model->shop_id, ArrayHelper::map(Shop::find()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => 'Выебрите магазин']) ?>
    </div>
    <div class="col-lg-6 form-group">
        <?= DatePicker::widget([
            'name' => 'date',
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            'value' => !$model->isNewRecord ? $weekend.' '.$day.' '.$month.' '.$year : '',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'D d M yyyy',
                'convertFormat' => true
            ]
        ]); ?>
    </div>
    <div class="col-lg-6 form-group">
        <?= TimePicker::widget([
            'name' => 'start',
            'value' => $model->isNewRecord ? '08:00' : Yii::$app->formatter->asTime($model->start_time, 'php:H:i'),
            'pluginOptions' => [
                'showMeridian' => false,
                'template' => false
            ]
        ]) ?>
        <?= TimePicker::widget([
            'name' => 'end',
            'value' => $model->isNewRecord ? '18:00' : Yii::$app->formatter->asTime($model->end_time, 'php:H:i'),
            'pluginOptions' => [
                'showMeridian' => false,
                'template' => false
            ]
        ]) ?>
    </div>

    <div class="form-group">
        <?= $model->isNewRecord ? Html::submitButton('Создать смену', ['class' => 'btn btn-success']) : Html::submitButton('Редактировать', ['class' => 'btn btn-primary']).' '.Html::a('Удалить', ['shifts/delete', 'id' => $model->id],['class' => 'btn btn-danger delete-shifts']) ?>
    </div>
    <?= Html::endForm() ?>
</div>
