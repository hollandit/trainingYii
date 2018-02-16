<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php if(!Yii::$app->user->isGuest): ?>
        <?php
        NavBar::begin([
            'brandLabel' => 'Holland',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                    'class' => 'navbar-inverse header_nav',
            ],
        ]);
        $menuItems = [
            ['label' => 'Главная страница', 'url' => ['/site/index'], 'visible' => Yii::$app->user->can('employee')],
            ['label' => 'База знаний', 'url' => ['/site/knowledge'], 'visible' => Yii::$app->user->can('employee')],
            ['label' => 'Треннинги', 'url' => ['/site/contact'], 'visible' => Yii::$app->user->can('employee')],
            ['label' => 'Тесты', 'url' => ['/test/test', 'id' => 1], 'visible' => Yii::$app->user->can('hr')],
            ['label' => 'Результаты', 'url' => ['/test/result-test'], 'visible' => Yii::$app->user->can('hr')],
            ['label' => 'Картотека', 'url' => ['user/index'], 'visible' => Yii::$app->user->can('hr')],
            ['label' => 'База Знаний', 'url' => ['knowledge/index'], 'visible' => Yii::$app->user->can('hr')]
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
    <?php endif; ?>

    <div class="content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="container">
            <div class="row">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <?= Html::img('@web/images/u2367.png', ['style' => 'width:61px;margin-top:9px']) ?>
        <div class="col-lg-3 footer-rights">
<!--            &copy; -->
            <?= Html::img('@web/images/u2349.png', ['style' => 'margin-top:8px;margin-right: 7px']) ?>
            <?= date('Y') ?>
            <span class="text-footer">All rights reserved</span>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-3 footer-error">
            <?= Html::img('@web/images/u2361.png') ?>
            <?= Html::input('text', 'errors', null, ['placeholder' => 'Введите текст']).'<span>'.Html::button('ОК', ['class' => '']).'</span>' ?>
            <div class="footer-text_errors">Нашел ошибку? Есть предложения и идеи? Напиши сюда!</div>
        </div>
        <div class="col-lg-3 footer-contact">
            <?= Html::img('@web/images/u2355.png') ?>
            <div class="phone">216-36-96</div>
            <div class="footer-contact_text">Есть вопрос?  Позвони админу!</div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
