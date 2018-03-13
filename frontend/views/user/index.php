<?php

use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\models\User */
/* @var $position \app\models\Position */

$this->title = 'Картотека';
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
<!--        --><?php //Modal::begin([
//            'header' => 'Создать должность',
//            'toggleButton' => [
//                'tag' => 'button',
//                'class' => 'btn btn-primary',
//                'label' => 'Создать должность'
//            ]
//        ]);
//
//        $form = ActiveForm::begin([
//            'id' => 'user-create-position',
//            'action' => ['create-position']
//        ]);
//
//        echo $form->field($position, 'name')->textInput();
//
//        echo Html::submitButton('Создать', ['class' => 'tbn btn-primary']);
//
//        ActiveForm::end();
//
//        Modal::end(); ?>
    </p>

    <?php Pjax::begin() ?>
        <?php try {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'username',
                    [
                        'attribute' => 'nameEmployee',
                        'label' => 'ФИО'
                    ],
                    [
                        'attribute' => 'date_birth',
                        'format' => 'date',
                        'filter' => DateControl::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_birth',
                            'autoWidget' => true,
                            'type' => DateControl::FORMAT_DATE,
                            'displayFormat' => 'dd.MM.yyyy'
                        ])
                    ],
                    [
                        'attribute' => 'id_position',
                        'filter' => ArrayHelper::map(\app\models\Position::find()->all(), 'id', 'name'),
                        'value' => function ($value) {
                            return $value->position->name;
                        },
                        'label' => 'Должность'
                    ],
                    [
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '-',
                            'pluginOptions' => ['format' => 'dd.mm.yyyy'],
                        ]),
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Дата приема'
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}'
                    ],
                ],
            ]);
        } catch (Exception $e) {
            print_r($e->getMessage());
        } ?>
    <?php Pjax::end() ?>
</div>
