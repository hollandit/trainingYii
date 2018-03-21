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
    <div class="col-lg-4">
        <h3>Добро пожаловать <br><?= $user->nameEmployee ?></h3>
        <h4>Должность: <?= $user->position->name ?></h4>
        <h4>Базовый оклад: <?= $user->salary.' рублей' ?></h4>
        <h4>Адрес: <?= $user->address ?></h4>
        <h4>Email: <?= $user->email ?></h4>
        <h4>Телефон: <?= $user->phone ?></h4>
    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-4">
                <div class="jumbotron">
                    <div class="container result">
                        <h4>Количество тестов</h4><p><?= $count ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="jumbotron">
                    <div class="container result">
                        <h4>Пройденные тесты</h4><p><?= $done ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="jumbotron">
                    <div class="container result">
                        <h4>Проваленные тесты</h4><p><?= $failed ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-6">
                <h3>Доступные тесты</h3>
                <?php foreach ($thema as $name){
                    echo Html::a($name->name, ['test/testing', 'id' => $name->id]).'<br>';
                } ?>
                <?= Html::a('Все тесты', ['#'], ['class' => 'btn btn-link']) ?>
            </div>
            <div class="col-lg-6">
                <h3>Доступные тренинги</h3>
                <?= Html::a('Все тренинги', ['#'], ['class' => 'btn btn-link']) ?>
            </div>
        </div>
    </div>
</div>
