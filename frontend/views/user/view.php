<?php

use app\models\Choice;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $access app\models\Access */
/* @var $searchModel app\models\ChoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
?>
<div class="user-view">

    <h1><?= Html::encode($model->nameEmployee) ?></h1>

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

    <div class="col-lg-4">
        <?php Pjax::begin([
            'id' => 'pjax-employee-contact'
        ]) ?>
        <div class="panel">
            <span class="glyphicon glyphicon-pencil action-contact" data-id="<?=$model->id?>"></span>
            <div class="panel-body">
                <p>Контакты</p>
                <table class="employee-table">
                    <tr>
                        <td class="employee-table_label">Адрес</td>
                        <td><?= Html::encode($model->address) ?></td>
                    </tr>
                    <tr>
                        <td class="employee-table_label">Email</td>
                        <td class="employee-table_email"> <?= Html::encode($model->email) ?></td>
                    </tr>
                    <tr>
                        <td class="employee-table_label">Телефон</td>
                        <td class="employee-table_phone"> <?= Html::encode($model->phone) ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php Pjax::end() ?>
    </div>
    <div class="col-lg-3">
        <div class="panel">
            <span class="glyphicon glyphicon-pencil action-info" data-id="<?=$model->id ?>"></span>
            <div class="panel-body">
                <p>Информация о сотруднике</p>
                <table class="employee-table">
                    <tr>
                        <td class="employee-table_label">Оклад</td>
                        <td class="employee-table_salary"><?= Html::encode($model->salary) ?> <span class="glyphicon glyphicon-ruble"></span></td>
                    </tr>
                    <tr>
                        <td class="employee-table_label">График</td>
                        <td>5/2</td>
                    </tr>
                    <tr>
                        <td class="employee-table_label">Должность</td>
                        <td class="employee-table_position"><?= Html::encode($model->position->name) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-3 employee-test">
        <h3>Тесты</h3>
        <div>
            <div class="employee-test-label">Кол-во выполненых тестов</div>
            <div class="employee-test_rating"><?= Choice::find()->with('theme')->where(['done' => Choice::PASS, 'id_user' => $model->id])->count() . ' из ' . Choice::find()->with('theme')->where(['id_user' => $model->id])->count() ?></div>
        </div>
        <div class="appoint-table">
            <h3><?= Html::encode('Назначено') ?></h3>
            <div class="appointment-list">
                <?php foreach ($access as $thema){
                    echo '<div class="appointment-employee">
                <div>'.Html::a($thema->theme->name, ['test/test', 'id' => $thema->id_theme]).'</div>
                <span>'.Yii::$app->formatter->asDate($thema->create_at, 'php:d M').'</span>
            </div>';
                } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
    <?php Pjax::begin() ?>
        <?php try {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id_theme',
                        'label' => 'Темы',
                        'format' => 'raw',
                        'filter' => ArrayHelper::map(Choice::find()->with('theme')->where(['id_user' => $model->id])->groupBy('id_theme')->all(), 'id_theme', 'theme.name'),
                        'value' => function ($value) {
                            return Html::a($value->theme->name, ['test/modal-result', 'id' => $value->id], ['class' => 'result-test', 'data-pjax' => 0]);
                        }
                    ],
                    [
                        'attribute' => 'done',
                        'filter' => ['0' => 'Не сдал', '1' => 'Сдал'],
                        'value' => function ($value) {
                            return $value->done == 1 ? 'Сдал' : 'Не сдал';
                        }
                    ],
                    [
                        'attribute' => 'date',
                        'format' => 'datetime',
                        'filter' => ''
                    ]
                ]
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        } ?>
    <?php Pjax::end() ?>
    </div>
</div>
<?php Modal::begin([
    'id' => 'modal-resultTest'
]);

echo '<div class="content-modal"></div>';

Modal::end();?>