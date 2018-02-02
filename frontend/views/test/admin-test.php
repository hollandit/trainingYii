<?php

use frontend\components\NavThema;
use yii\helpers\Html;
?>

<div class="test-adminTest">
    <div class="col-lg-3">
        <?php echo NavThema::widget() ?>
        <?php echo Html::a('Создать тесты', ['#'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="col-lg-9">
        <h1><?php echo 'Тест '.$model[0]->idThemeQuestion->name ?></h1>
        <p>УСЛОВИЯ ПРОХОЖДЕНИЯ:</p>
        <p>Время на прохождение: 1 минута.</p>
        <p>Если Вы не прошли тест, пересдача возможна не ранее, чем через 14 дней. Результаты прохождения принимаются в расчет при начислении бонусов и премиальных, а также - при повышении должности.</p>

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
</div>
