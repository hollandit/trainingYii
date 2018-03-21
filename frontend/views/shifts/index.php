<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use \yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShiftsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var $shops \app\models\Shop */

$this->title = 'Смены';
?>
<div class="shifts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('+', ['create'], ['id' => 'button-createShifts', 'class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin() ?>
    <table class="table">
        <tr>
            <th>Магазины</th>
            <th>Пн</th>
            <th>Вт</th>
            <th>Ср</th>
            <th>Чт</th>
            <th>Пт</th>
            <th>Сб</th>
            <th>Вс</th>
        </tr>
        <?php foreach ($shops as $shop){
            echo '<tr>
                <td>'.$shop->name.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
    'id' => 'modal-createShifts'
]);

echo '<div class="content-modal"></div>';
Modal::end(); ?>