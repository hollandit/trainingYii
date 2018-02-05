<?php

use frontend\components\NavThema;
use yii\helpers\Html;
?>

<div class="test-adminTest">
    <div class="col-lg-3 navBar-Thema">
        <h3>Все тесты</h3>
        <?php echo NavThema::widget() ?>
        <?php echo Html::a('Создать тесты', ['#'], ['class' => 'btn btn-primary btn-block button-thema-test']) ?>
    </div>
    <div class="col-lg-6 container column-basic">
        <h1><?php echo 'Тест '.$model[0]->idThemeQuestion->name ?></h1>
        <p>УСЛОВИЯ ПРОХОЖДЕНИЯ:</p>
        <p>Время на прохождение: 1 минута.</p>
        <p>Если Вы не прошли тест, пересдача возможна не ранее, чем через 14 дней. Результаты прохождения принимаются в расчет при начислении бонусов и премиальных, а также - при повышении должности.</p>
        <hr/>
        <?php foreach ($model as $count => $question){
            $count = $count+1;
            echo '<div class="test-block-admin">';
                echo '<div> Вопрос '.$count.'</div>';
                echo '<div>'.$question->name.'</div>';
                foreach ($question->answear as $key => $answear) {
                    echo Html::radio($question->id, false, ['label' => $answear]).'<br/>';
                }
                if ($count == 1){
                    echo Html::submitButton('>', ['class' => 'nextTestAdmin']);
                } else if ($count == 3){
                    echo Html::submitButton('<', ['class' => 'prevTestAdmin']);
                } else {
                    echo Html::submitButton('<', ['class' => 'prevTestAdmin']).' '.Html::submitButton('>', ['class' => 'nextTestAdmin']);
                }
            echo '</div>';
        }
        echo '<h3>'.$model->name.'</h3>';
        ?>
    </div>
    <div class="col-lg-3">
        <?= Html::a('Пройти тест', ['#'], ['class' => 'btn btn-success btn-lg btn-block']) ?>
        <p>СПИСОК НАНАЧЕНИЙ</p>
        <ht/>
        <div>
            <span class="glyphicon glyphicon-check"></span>
            <span>15 мар</span>
            <span>Руслан Абсалямов</span>
            <span>13/15</span>
        </div>
        <div>
            <span class="glyphicon glyphicon-retweet"></span>
            <span>15 мар</span>
            <span>Альберт Закиров</span>
            <span>8/15</span>
        </div>
        <div>
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-user"></span>
                <input type="text" class="form-control" placeholder="Найти учстника">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Назначить</button>
                </span>
            </div>
            <?= Html::submitButton('Создать ссылку на прохождение...', ['class' => 'btn']) ?>
            <p>СТАТИСТИКА</p>
            <div class="col-lg-12">
                <div class="col-lg-4">
                    <?= Html::img('@web/images/u3146.png', ['alt' => 'Статистика']) ?>
                </div>
                <div class="col-lg-8">
                    <p>Отлично (без ошибок): 60%</p>
                    <p>Сдали (1-3 ошибки): 30%</p>
                    <p>Не сдали (более 3 ошибок: 10%</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-4">
                    <?= Html::img('@web/images/u3148.png', ['alt' => 'Статистика']) ?>
                </div>
                <div class="col-lg-8">
                    <p>САМЫЕ ТЯЖЕЛЫЕ ВОПРОСЫ:</p>
                    <p>Вопрос №12 112 ошибок</p>
                    <p>Вопрос №2 89 ошибок</p>
                    <p>Вопрос №7 5 ошибок</p>
                </div>
            </div>
            <p>РЕКОМЕНДАЦИЯ</p>
            <hr/>
        </div>

    </div>
</div>
