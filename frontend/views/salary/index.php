<?php
/* @var $this yii\web\View */
/* @var $users \app\models\User */
/* @var $arr \app\models\User */
/** @var $depreming \app\models\Depreming */

use app\models\Depreming;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Зарплаты';
$url = Url::to(['salary/create']);
?>

<div class="salary-index">
    <div class="col-lg-4">
        <?php foreach ($arr as $key => $user){
            echo '<div><h4><strong>'.$key.'</strong></h4></div>';
            echo '<table class="table salary-employee">';
            foreach ($user as $index => $item) {
                echo '<tr>';
                echo '<td class="table-salary_employee">'.Html::a($item['name'], ['user/view', 'id' => $item['id']]).'</td>';
                echo '<td>'.$item['salary'].' рублей</td>';
                echo '</tr>';
            }
            echo '</table>';
        } ?>
    </div>
    <div class="col-lg-8">
        <div class="panel panel-warning">
            <div class="panel-heading">Создать</div>
            <div class="panel-body">
                <form id="create-depreming">
                    <div class="col-lg-3">
                        <input type="radio" name="type" value="<?= Depreming::BONUS ?>" id="bonus" required><label for="bonus">Премия</label>
                        <input type="radio" name="type" value="<?= Depreming::FINE ?>" id="fide" required><label for="fide">Штрафы</label>
                    </div>
                    <div class="col-lg-3">
                        <?= Html::input('number', 'amount', null, ['class' => 'form-control', 'placeholder' => 'Сумма', 'required' => true, 'min' => 0, 'max' => 5000]) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= Html::dropDownList('user', null, ArrayHelper::map($users, 'id', 'nameEmployee'), ['class' => 'form-control', 'prompt' => 'Введите сотрудника', 'required' => true]) ?>
                    </div>
                    <div class="col-lg-12">
                        <?= Html::textarea('comment', null, ['placeholder' => 'Комментарий', 'required' => true, 'class' => 'form-control', 'rows' => 1, 'style' => 'resize:none']) ?>

                    </div>
                    <div>
                        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <?php Pjax::begin([
            'id' => 'table-depreming'
        ]) ?>
        <div class="depreming">
            <?php if (count($depreming) == 0){
                echo '<tr><td colspan="4" style="text-align: center">Данных нет</td></tr>';
            } else {
                foreach ($depreming as $item) {
                    $item->type === Depreming::BONUS ? $type = ['color' => '#5cb85c', 'name' => 'Премия'] : $type = ['color' => '#d9534f', 'name' => 'Штраф'];
                    echo '<div class="panel depreming-panel" style="padding: 10px">';
                        echo '<div style="float:left; width: 52px; color: '.$type['color'].'">'.$type['name'].'</div>';
                        echo '<div style="float:left; width: 62px">'.$item->amount.'<span class="glyphicon glyphicon-rub
"></span></div>';
                        echo '<div style="float:left; width: 191px">'.$item->user->nameEmployee.'</div>';
                        echo '<div style="float:left; width: 344px">'.$item->comment.'</div>';
                        echo '<div style="float: left">'.Yii::$app->formatter->asDate($item->create_at, 'php:d.M').'</div>';
                        echo '<span class="glyphicon glyphicon-remove-circle delete-depreming" data-id="'.$item->id.'"></span>';
                    echo '</div>';
                }
            } ?>
        </div>
        <?php Pjax::end() ?>
    </div>
</div>