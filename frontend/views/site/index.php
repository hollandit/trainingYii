<?php

use \yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Главная страница';
?>
<div class="site-index">

    <h3>Добро пожаловать <?php echo $user->last_name.' '.$user->name.' '.$user->patronymic ?></h3>
    <h4>Должность: <?php echo $user->position->name ?></h4>

    <h3>Доступные тесты</h3>
        <?php foreach ($thema as $name){
            echo Html::a($name->name, ['test/testing', 'id' => $name->id]).'<br>';
        } ?>
    <h3>Доступные тренинги</h3>

    <h3>Статистика</h3>
    <p>Количество тестов: 0</p>
    <p>Пройденные тесты: 0</p>
    <p>Проваленные тесты: 0</p>
</div>
