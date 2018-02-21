<?php

use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \app\models\User */
/** @var $thema \app\models\Thema */
/** @var  $count \app\models\Choice */
/** @var  $done \app\models\Choice */
/** @var  $failed \app\models\Choice */

$this->title = 'Главная страница';
?>
<div class="site-index">
    <div class="col-lg-5">
        <h3>Добро пожаловать <?php echo $user->nameEmployee ?></h3>
        <h4>Должность: <?php echo $user->position->name ?></h4>
        <h3>Доступные тесты</h3>
            <?php foreach ($thema as $name){
                echo Html::a($name->name, ['test/testing', 'id' => $name->id]).'<br>';
            } ?>
<!--            --><?//= Html::a('Все тесты', ['#'], ['class' => 'btn btn-link']) ?>
        <h3>Доступные тренинги</h3>
        <h3>Статистика</h3>
        <p>Количество тестов: <?= $count ?></p>
        <p>Пройденные тесты: <?= $done ?></p>
        <p>Проваленные тесты: <?= $failed ?></p>
    </div>
</div>
