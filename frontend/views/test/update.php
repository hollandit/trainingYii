<?php
use yii\helpers\Html;

$right = $model->correct['right'];
function radio($answer, $right, $number){
    if ($answer == $right){
        return '<label><input type="radio" name="right" class="radio radio-'.$number.'" value="'.$answer.'" checked><span>Правильный</span></label>';
    } else {
        return '<label><input type="radio" name="right" class="radio radio-'.$number.'" value="'.$answer.'" checked><span>Правильный</span></label>';
    }
}
$answer = $model->answear;
?>

<h3>Редактирование вопроса</h3>

<?= Html::beginForm(['test/update', 'id' => $model->id], 'post') ?>
    <div>
        <label>Вопрос </label>
        <?= Html::input('text', 'Question', $model->name, ['class' => ['form-control']]) ?>
    </div>
    <div>
        <label>Ответ 1 </label>
        <?php echo Html::input('text', 'Answer[1]', $answer[1], ['class' => 'answer-1']);
        echo radio($answer[1], $right, 1); ?>
    </div>
    <div>
        <label>Ответ 2 </label>
        <?php echo Html::input('text', 'Answer[2]', $answer[2], ['class' => 'answer-2']);
        echo radio($answer[2], $right, 2); ?>
    </div>
    <div>
        <label>Ответ 3 </label>
        <?php echo Html::input('text', 'Answer[3]', $answer[3], ['class' => 'answer-3']);
        echo radio($answer[3], $right, 3); ?>
    </div>
    <div>
        <label>Ответ 4 </label>
        <?php echo Html::input('text', 'Answer[4]', $answer[4], ['class' => 'answer-4']);
        echo radio($answer[4], $right, 4); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Удалить', ['test/delete', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </div>
<?= Html::endForm() ?>