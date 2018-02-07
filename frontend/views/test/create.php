<?php

use yii\bootstrap\Html;
?>

<?= Html::beginForm(['test/create'], 'post'); ?>
        <?php if ($thema != null){
            echo Html::hiddenInput('Thema', $thema->id);
        } else {
            echo '<div><label>Название темы</label>';
            echo Html::input('text', 'Thema').'</div>';
        } ?>
    <div>
        <label>Вопрос</label>
        <?= Html::input('text', 'Question') ?>
    </div>
    <div>
        <label>Ответ 1</label>
        <?= Html::input('text', 'Answer[1]', null, ['required' => true]) ?>
        <label><input type="radio" name="right" class="radio"><span>Правильный</span></label>
    </div>
    <div>
        <label>Ответ 2</label>
        <?= Html::input('text', 'Answer[2]', null, ['required' => true]) ?>
        <label><input type="radio" name="right" class="radio"><span>Правильный</span></label>
    </div>
    <div>
        <label>Ответ 3</label>
        <?= Html::input('text', 'Answer[3]', null, ['required' => true]) ?>
        <label><input type="radio" name="right" class="radio"><span>Правильный</span></label>
    </div>
    <div>
        <label>Ответ 4</label>
        <?= Html::input('text', 'Answer[4]', null, ['required' => true]) ?>
        <label><input type="radio" name="right" class="radio"><span>Правильный</span></label>
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