<?php
use vova07\imperavi\Widget;
use yii\bootstrap\Html;

/** @var $thema \app\models\Thema */
?>
<?= Html::beginForm(null, null, ['data-id' =>$thema->id, 'id' =>'form-condition']) ?>
<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
<?php try {
    echo Widget::widget([
        'name' => 'conditions',
        'value' => $thema->conditions == null ? null : $thema->conditions,
        'settings' => [
            'lang' => 'ru',
            'buttons' => ['bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist'],
        ]
    ]);
} catch (Exception $e) {
    echo $e;
} ?>
    <?= Html::submitButton('Редактировать', ['class' => 'createTest-modal']) ?>
<?= Html::endForm() ?>
