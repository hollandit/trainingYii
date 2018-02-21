<?php

use kartik\file\FileInput;
use yii\bootstrap\Html;

/** @var $thema \app\models\Thema */

$radio = function ($number){
    echo '<label><input type="radio" name="right" class="radio radio-'.$number.'" required><span>Правильный</span></label>';
}
?>


<?= Html::beginForm(['test/create'], 'post', ['enctype' => 'multipart/form-data']); ?>
        <?php if ($thema != null){
            echo Html::hiddenInput('Thema', $thema->id);
        } else {
            echo '<div><label>Название темы</label>';
            echo Html::input('text', 'Thema', null, ['required' => true]).'</div>';
        } ?>
    <div>
        <label>Вопрос</label>
        <?= Html::input('text', 'Question', null, ['required' => true]) ?>
    </div>
    <div>
        <label>Ответ 1</label>
        <?= Html::input('text', 'Answer[1]', null, ['required' => true, 'class' => 'answer-1']);
        $radio(1); ?>
    </div>
    <div>
        <label>Ответ 2</label>
        <?= Html::input('text', 'Answer[2]', null, ['required' => true, 'class' => 'answer-2']);
        $radio(2);?>
    </div>
    <div>
        <label>Ответ 3</label>
        <?= Html::input('text', 'Answer[3]', null, ['required' => true, 'class' => 'answer-3']);
        $radio(3); ?>
    </div>
    <div>
        <label>Ответ 4</label>
        <?= Html::input('text', 'Answer[4]', null, ['required' => true, 'class' => 'answer-4']);
        $radio(4); ?>
    </div>
    <div>
        <?php try {
            echo FileInput::widget([
                'name' => 'attachment[]',
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'showUpload' => false,
                    'maxFileCount' => 4,
                    'maxFileSize' => 25600
                ]
            ]);
        } catch (Exception $e) {
            echo $e;
        } ?>
    </div>
    <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']); ?>
<?= Html::endForm(); ?>

<!--<div class="test-create">-->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!--    --><?//= Html::beginForm(['test/create'],'post') ?>
<!--        <div class="test-create_question">-->
<!--            <div class="test-create-question_page">-->
<!--                <label for="question">Вопрос 1</label>-->
<!--                --><?//= Html::input('text', 'Question[1]', null, ['id' => 'question']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-1">Ответ 1</label>-->
<!--                --><?//= Html::input('text', 'Answer[1]', null, ['id' => 'answer-1']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-2">Ответ 2</label>-->
<!--                --><?//= Html::input('text', 'Answer[2]', null, ['id' => 'answer-2']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-3">Ответ 3</label>-->
<!--                --><?//= Html::input('text', 'Answer[3]', null, ['id' => 'answer-3']) ?>
<!--            </div>-->
<!--            <div>-->
<!--                <label for="answer-4">Ответ 4</label>-->
<!--                --><?//= Html::input('text', 'Answer[4]', null, ['id' => 'answer-4']) ?>
<!--            </div>-->
<!--        </div>-->
<!--        --><?//= Html::button('Добавить вопрос', ['class' => 'btn btn-success addQuestion']) ?>
<!--        --><?//= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
<!--    --><?//= Html::endForm() ?>
<!--</div>-->