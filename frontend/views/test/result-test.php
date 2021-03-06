<?php

use app\models\Questions;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/** @var \yii\data\Pagination $pages */
$this->title = 'Рейтинги'
?>

<div class="test-resultTest">
    <div>
        <?php Pjax::begin() ?>
        <?php foreach ($model as $result): ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $user = $result->user;
                        echo '<div>Сотрудник '.$user->last_name.' '.$user->name.' '.$user->patronymic.'</div>'; ?>
                    <p>Тема: <?php echo $result->theme->name ?></p>
                    <p>Дата выполнение теста <?php echo Yii::$app->formatter->asDatetime($result->date, 'dd.MM.YYYY HH:mm') ?></p>
                    <p>Правильных ответов: <?php echo $result->result ?></p>
                    <div class="col-lg-12">
                        <table class="table table-condensed">
                            <tr>
                                <th>Вопрос</th>
                                <th>Ответ</th>
                            </tr>
                            <?php foreach ($result->answear as $key => $answer){
                                $question = Questions::findOne($key);
                                if ($answer != $question->correct['right']){
                                    echo '<tr class="danger"><td>'.$question->name. '</td><td>'.$answer.'</td></tr>';
                                } else {
                                    echo '<tr><td>'.$question->name. '</td><td>'.$answer.'</td></tr>';
                                }
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php try {
            echo LinkPager::widget([
                'pagination' => $pages
            ]);
        } catch (Exception $e) {
        }
        Pjax::end()?>
    </div>
</div>
