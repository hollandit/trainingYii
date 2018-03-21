<?php

use app\models\Questions;
?>

<div style="padding: 10px;">
    <p>Правильных ответов: <?= $model->result ?></p>
    <table class="table table-condensed">
        <tr>
            <th>Вопрос</th>
            <th>Ответ</th>
        </tr>
        <?php foreach ($model->answear as $key => $answer){
            $question = Questions::findOne($key);
            if ($answer != $question->correct['right']){
                echo '<tr class="danger"><td>'.$question->name. '</td><td>'.$answer.'</td></tr>';
            } else {
                echo '<tr><td>'.$question->name. '</td><td>'.$answer.'</td></tr>';
            }
        } ?>
    </table>
</div>
