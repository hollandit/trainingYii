<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use \yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShiftsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $shops \app\models\Shop */

$this->title = 'Смены';

function cell($start, $end, $employee){
    return Yii::$app->formatter->asTime($start, 'php:H:i').'-'.Yii::$app->formatter->asTime($end, 'php:H:i').' '.Html::a($employee->user->lastNameEmployee, ['shifts/update', 'id' => $employee->id], ['class' => 'button-editShifts', 'data-pjax' => 0]).'<br>';
}
?>
<div class="shifts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('+', ['create'], ['id' => 'button-createShifts', 'class' => 'btn btn-success']) ?>
    </p>
    <p><?php echo $this->render('_search', ['model' => $searchModel]); ?> </p>

    <h3 style="text-align: center"><?= date('d.m', strtotime($dataProvider->weekDay['Пн'])).' - '.date('d.m' , strtotime($dataProvider->weekDay['Вс'])) ?></h3>
    <?php Pjax::begin([
        'id' => 'pjax-shifts'
    ]) ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>Магазины</th>
                <?php foreach ($dataProvider->weekDay as $shortname => $time): ?>
                    <th><?= $shortname ?> <?= date('d.m', strtotime($time)) ?></th>
                <?php endforeach; ?>
                <?php foreach ($dataProvider->shifts as $name => $shop) : ?>
                    <tr>
                        <td><?= $name ?></td>
                        <?php foreach ($dataProvider->weekDay as $time): ?>
                            <td>
                                <?php foreach ($shop as $value){
                                    if (in_array($time, (array)$value['date'])){
                                        echo cell($value->start_time, $value->end_time, $value);
                                    }
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
        </table>
    </div>
    <?php Pjax::end() ?>
</div>
<?php Modal::begin([
    'id' => 'modal-createShifts',
]);

echo '<div class="content-modal"></div>';
Modal::end(); ?>
