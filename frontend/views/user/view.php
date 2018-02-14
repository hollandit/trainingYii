<?php

use app\models\Choice;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $searchModel app\models\ChoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Уволить', ['dismised', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите уволить сотрудника?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'nameEmployee',
            [
              'attribute' => 'id_position',
              'value' => function($value){
                return $value->position->name;
              }
            ],
            'email:email',
            'created_at:datetime',
        ],
    ]) ?>

    <?php Pjax::begin() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id_theme',
                    'label' => 'Темы',
                    'filter' => ArrayHelper::map(Choice::find()->where(['id_user' => $model->id])->groupBy('id_theme')->all(), 'id_theme', 'theme.name'),
                    'value' => function($value){
                        return $value->theme->name;
                    }
                ],
                [
                    'attribute' => 'done',
                    'filter' => ['0' => 'Не сдал', '1' => 'Сдал'],
                    'value' => function($value){
                        return $value->done == 1 ? 'Сдал' : 'Не сдал';
                    }
                ]
            ]
        ]) ?>
    <?php Pjax::end() ?>

</div>
