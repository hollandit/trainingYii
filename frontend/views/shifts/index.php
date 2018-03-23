<?php

use app\models\Shifts;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use \yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShiftsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var $shops \app\models\Shop */

$this->title = 'Смены';

function day($shop_id, $day){
    return Shifts::find()->andWhere(['shop_id' => $shop_id, 'date' => date('Y-m-d 00:00:00', strtotime($day))])->all();
}
function cell($start, $end, $employee){
    echo Yii::$app->formatter->asTime($start, 'php:H:i').'-'.Yii::$app->formatter->asTime($end, 'php:H:i').' '.Html::a($employee->user->lastNameEmployee, ['shifts/update', 'id' => $employee->id], ['class' => 'button-editShifts', 'data-pjax' => 0]).'<br>';
}
?>
<div class="shifts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('+', ['create'], ['id' => 'button-createShifts', 'class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([
        'id' => 'pjax-shifts'
    ]) ?>
    <table class="table">
        <tr>
            <th>Магазины</th>
            <th>Пн <?= date("d.m", strtotime("last Monday")) ?></th>
            <th>Вт <?= date("d.m", strtotime("last Tuesday")); ?></th>
            <th>Ср <?= date("d.m", strtotime("last Wednesday")); ?></th>
            <th>Чт <?= date("d.m", strtotime("Thursday")); ?></th>
            <th>Пт <?= date("d.m", strtotime("Friday")); ?></th>
            <th>Сб <?= date("d.m", strtotime("Saturday")); ?></th>
            <th>Вс <?= date("d.m", strtotime("Sunday")); ?></th>
        </tr>
        <?php foreach ($shops as $shop){
            echo '<tr>
                <td>'.$shop->name.'</td>';
            echo '<td>';
            foreach (day($shop->id, 'last Monday') as $employee){
                cell($employee->start_time, $employee->end_time, $employee);
            }
            echo '</td>
                <td>';
            foreach (day($shop->id, 'last Tuesday') as $employee){
                cell($employee->start_time, $employee->end_time, $employee);
            }
            echo '</td>
                <td>';
            foreach (day($shop->id, 'last Wednesday') as $employee){
                cell($employee->start_time, $employee->end_time, $employee);
            }
            echo '</td>
                <td>';
            foreach (day($shop->id, 'Thursday') as $employee){
                cell($employee->start_time, $employee->end_time, $employee);
            }
            echo '</td>
                <td>';
            foreach (day($shop->id, 'Friday') as $employee){
                cell($employee->start_time, $employee->end_time, $employee);
            }
            echo '</td>
                <td>';
            foreach (day($shop->id, 'Saturday') as $employee){
                cell($employee->start_time, $employee->end_time, $employee);
            }
            echo '</td>
                <td>';
            foreach (day($shop->id, 'Sunday') as $employee){
                cell($employee->start_time, $employee->end_time, $employee);
            }
            echo '</td>
            </tr>';
        } ?>
        <tr>
            <td>Итого</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <?php Pjax::end() ?>
</div>
<?php Modal::begin([
    'id' => 'modal-createShifts',
]);

echo '<div class="content-modal"></div>';
Modal::end(); ?>
<?php Modal::begin([
    'id' => 'modal-editShifts',
]);

echo '<div class="content-modal"></div>';
Modal::end() ?>
