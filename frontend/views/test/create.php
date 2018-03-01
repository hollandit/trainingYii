<?php

use yii\bootstrap\Html;

/** @var $thema \app\models\Thema */

$radio = function ($number){
    echo '<label class="label-radio"><input type="radio" name="right" class="radio radio-'.$number.'" required><div></div></label>';
}
?>
<div class="test-create">
    <?= Html::beginForm(['test/create'], 'post', ['enctype' => 'multipart/form-data']); ?>
            <?php if ($thema != null){
                echo Html::hiddenInput('Thema', $thema->id);
            } else {
                echo '<div class="create-test_thema">'. Html::input('text', 'Thema', null, ['required' => true, 'placeholder' => 'Введите название теста...', 'class' => 'test-create_themaForm']).'</div>';
            } ?>
        <div class="test-create-question">
            <div class="test-create-questionInput">
                <label>Вопрос.</label>
                <?= Html::input('text', 'Question', null, ['required' => true, 'placeholder' => 'Введите вопрос...', 'class' => 'test-create_questionForm']) ?>
            </div>
            <div class="col-lg-3">
                <div class="test-create_fileInput">
                    <label>
                        <div>
                            <?= Html::img('@web/images/u1503.png', ['class' => 'test-created-image']) ?>
                            <span class="test-created-span">Загрузите</span>
                            <span class="test-created-span">фото</span>
                        </div>
                        <?= Html::input('file', 'attachment[]', null, ['multiple' => true, 'class' => 'test-created-input', 'accept' => 'image/jpeg, image/jpg, image/png']) ?>
                    </label>
                </div>
            </div>
            <div>
                <div>
                    <?= Html::input('text', 'Answer[1]', null, ['required' => true, 'class' => 'answer-1 test-create_answerForm', 'placeholder' => 'Введите вариант ответа...']);
                    $radio(1); ?>
                </div>
                <div>
                    <?= Html::input('text', 'Answer[2]', null, ['required' => true, 'class' => 'answer-2 test-create_answerForm', 'placeholder' => 'Введите вариант ответа...']);
                    $radio(2);?>
                </div>
                <div>
                    <?= Html::input('text', 'Answer[3]', null, ['required' => true, 'class' => 'answer-3 test-create_answerForm', 'placeholder' => 'Введите вариант ответа...']);
                    $radio(3); ?>
                </div>
                <div>
                    <?= Html::input('text', 'Answer[4]', null, ['required' => true, 'class' => 'answer-4 test-create_answerForm', 'placeholder' => 'Введите вариант ответа...']);
                    $radio(4); ?>
                </div>
            </div>
        </div>
        <div class="create-test_control">
            <?= Html::button('Еще вопрос',['class' => 'create-test_addQuest']) ?>
            <hr>
            <div class="col-lg-8">
                <p>Укажите количество времени для теста:</p>
            </div>
            <div class="col-lg-4">
                <?=
                    Html::input('number', null, null, ['class' => 'create-test_timeInput']).
                    Html::input('number', null, null, ['class' => 'create-test_timeInput']).
                    Html::input('text', null, ':', ['class' => 'control-operator', 'disabled' => true]).
                    Html::input('number', null, null, ['class' => 'create-test_timeInput']).
                    Html::input('number', null, null, ['class' => 'create-test_timeInput'])
                ?>
            </div>
            <hr>
        </div>
        <p>
            <?= Html::button('Отмена', ['class' => 'closeModal', 'data-dismiss' => 'modal']); ?>
            <?= Html::submitButton('Создать', ['class' => 'createTest-modal']); ?>
        </p>
    <?= Html::endForm(); ?>

</div>


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