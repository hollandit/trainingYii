<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

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
    <div class="content">
        <?= $content ?>
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
