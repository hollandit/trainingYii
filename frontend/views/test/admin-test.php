<?php

use frontend\components\NavThema;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Image;

/** @var $model \app\models\Questions */
/** @var $thema \app\models\Thema */

$lenght = count($model) - 1;
$this->title = 'Тестирование';

?>

<div class="test-adminTest">
    <div class="col-lg-2 navBar-Thema test-contant">
        <h3>ВCЕ ТЕСТЫ</h3>
        <?php try {
            echo NavThema::widget();
        } catch (Exception $e) {
            echo $e;
        } ?>
        <?php Modal::begin([
            'header' => 'Создание теста',
            'toggleButton' => [
                'tag' => 'button',
                'class' => 'btn btn-primary button-thema-test',
                'label' => 'СОЗДАТЬ ТЕСТ'
            ]
        ]);

        echo $this->render('create');

        Modal::end()?>
    </div>
    <div class="col-lg-6 column-basic test-contant">
        <h1 class="column-basic-title"><?php echo 'Тест "<span class="title-test">'.$model[0]->idThemeQuestion->name.'</span>"' ?></h1>
        <?= Html::img('@web/images/u3045.png', ['data-path' => Url::to(['test/update-theme', 'id' => $model[0]->id_theme]), 'class' => 'editTitle']) ?>
        <span><?php Modal::begin([
                'header' => 'Создать вопрос',
                'toggleButton' => [
                    'tag' => 'span',
                    'class' => 'addQuestionButton',
                    'label' => '+'
                ]
            ]);
            echo $this->render('create', ['thema' => $thema]);
            Modal::end(); ?></span>
        <div class="column-basic-condition">
            <p>УСЛОВИЯ ПРОХОЖДЕНИЯ:</p>
            <p>Время на прохождение: 1 минута.</p>
            <p>Если Вы не прошли тест, пересдача возможна не ранее, чем через 14 дней. Результаты прохождения принимаются в расчет при начислении бонусов и премиальных, а также - при повышении должности.</p>
        </div>
        <hr/>
        <div>
        <?php foreach ($model as $count => $question){
            $number = $count+1;
            echo '<div class="test-block-admin">';
                echo '<div class="question-test-admin">';
            if ($count == 0){
                    if ($lenght == 0) {
                        echo '';
                    } else {
                        echo Html::img('@web/images/u3087.png', ['class' => 'nextTestAdmin']);
                    }
                } else if ($count == $lenght){
                    echo Html::img('@web/images/u3085.png', ['class' => 'prevTestAdmin']);
                } else {
                    echo Html::img('@web/images/u3085.png', ['class' => 'prevTestAdmin']).' '.Html::img('@web/images/u3087.png', ['class' => 'nextTestAdminSecond']);
                }
                    if (count($model) == 1){
                        echo '<div class="question-one"><h3> Вопрос '.$number.'.<span>'.Html::button("Источник", ["class" => "btn btn-primary"]).'</span></h3>';
                    } else {
                        echo '<div class="question-some"><h3> Вопрос '.$number.'.<span><button>Источник</button></h3></span>';
                    }
                    echo Html::img('@web/images/u3045.png', ['class' => 'editQuestion', 'data-path' => Url::to(['test/update', 'id' => $question->id])]);
                    echo '</div>';
                    echo '<div><p>'.$question->name.'</p></div>';
                    echo '<div class="radio-answear">';
                        foreach ($question->answear as $key => $answear) {
                            if($answear != $question->correct['right']){
                                echo '<label><input type="radio" class="radio" name="'.$question->id.'" value="'.$answear.'" ><span class="answer">Ответ <span class="key-answear">'.$key.'</span> '.$answear.'</span></label><br/>';
                            } else {
                                echo '<label><input type="radio" class="radio" name="'.$question->id.'" value="'.$answear.'" checked ><span class="answer" >Ответ <span class="key-answear">'.$key.'</span> '.$answear.'</span></label><br/>';
                            }
                        }
                    echo '</div>';
                echo '</div>';
                $file = Image::find()->where(['id_question' => $question->id])->all();
                echo '<div class="row test-image">';
                foreach ($file as $attachment){
                    switch (count($file)){
                        case 4:
                            echo '<div class="col-lg-3">'.Html::a(Html::img($attachment->path, ['style' => 'width:150px;', 'class' => 'thumbnail']), $attachment->path, ['data-lightbox' => 'roadtrip']).'</div>';
                            break;
                        case 3:
                            echo '<div class="col-lg-4">'.Html::a(Html::img($attachment->path, ['style' => 'width:200px;', 'class' => 'thumbnail']), $attachment->path, ['data-lightbox' => 'roadtrip']).'</div>';
                            break;
                        case 2:
                            echo '<div class="col-lg-6">'.Html::a(Html::img($attachment->path, ['style' => 'width:300px;margin-left:10px', 'class' => 'thumbnail']), $attachment->path, ['data-lightbox' => 'roadtrip']).'</div>';
                            break;
                        case 1:
                            echo '<div class="col-lg-7">'.Html::a(Html::img($attachment->path, ['style' => 'width:576px;height:257px; margin-left:22px']), $attachment->path, ['data-lightbox' => 'image-1']).'</div>';
                    }
                }
                echo '</div>';
            echo '</div>';
        } ?>
        </div>
    </div>
    <div class="col-lg-3 statistics test-contant">
        <?= Html::a('Пройти тест', ['test/testing', 'id' => $model[0]->id_theme], ['class' => 'btn btn-success btn-lg passTest']) ?>
        <div class="purpose">
            <p>СПИСОК НАЗНАЧЕНИЯ <?= Html::img('@web/images/u3045.png', ['style' => 'float:right']) ?></p>
            <hr/>
            <div class="statistics_appointment">
                <?= Html::img('@web/images/u3104.png') ?>
                <span class="statistics_appointment-date">15 мар</span>
                <span class="statistics_appointment-name success">Руслан Абсалямов</span>
                <span class="statistics_appointment-result">13/15</span>
            </div>
            <div class="statistics_appointment">
                <?= Html::img('@web/images/u3104.png') ?>
                <span class="statistics_appointment-date">15 мар</span>
                <span class="statistics_appointment-name success">Альберт Закиров</span>
                <span class="statistics_appointment-result">8/15</span>
            </div>
            <div class="statistics_appointment">
                <?= Html::img('@web/images/u3108.png', ['class' => 'statistics_appointment-icon']) ?>
                <span class="statistics_appointment-date">28 фев</span>
                <span class="statistics_appointment-name error">Дамир Закиев</span>
                <span class="statistics_appointment-result">10/16</span>
            </div>
            <div class="statistics_appointment">
                <?= Html::img('@web/images/u3140.png') ?>
                <span class="statistics_appointment-date">14 янв</span>
                <span class="statistics_appointment-name">Алексей Филипсон</span>
                <span class="statistics_appointment-result">8/18</span>
            </div>
            <div class="statistics_appointment">
                <span class="glyphicon glyphicon-check statistics_appointment-icon success"></span>
                <span class="statistics_appointment-date">13 янв</span>
                <span class="statistics_appointment-name success">Светлана Левина</span>
                <span class="statistics_appointment-result">15/15</span>
            </div>
            <div class="statistics_appointment">
                <?= Html::img('@web/images/u3140.png') ?>
                <span class="statistics_appointment-date">28 дек</span>
                <span class="statistics_appointment-name">Виктория Кузнецова</span>
                <span class="statistics_appointment-result">10/16</span>
            </div>
        </div>
        <div class="form-search">
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-user form-search-icon"></span>
                <input type="text" class="form-control form-search-input" placeholder="Найти учстника">
                <span class="input-group-btn">
                    <button class="btn form-search-button" type="button">Назначить</button>
                </span>
            </div>
            <?= Html::submitButton('Создать ссылку на прохождение...', ['class' => 'btn addLinkButton']) ?>
        </div>
        <div class="statistics-paragraph purpose">
            <p>СТАТИСТИКА</p>
            <hr/>
            <div class="col-lg-12 statistics-paragraph-result">
                <div class="col-lg-4 test-chart">
                    <?= Html::img('@web/images/u3146.png', ['alt' => 'Статистика']) ?>
                </div>
                <div class="col-lg-8 statistics-paragraph-interest">
                    <table>
                        <tr>
                            <td>Отлично (без ошибок):</td>
                            <td class="table-percent">60%</td>
                        </tr>
                        <tr>
                            <td>Сдали (1-3 ошибки):</td>
                            <td class="table-percent">30%</td>
                        </tr>
                        <tr>
                            <td>Не сдали (более 3 ошибок:</td>
                            <td class="table-percent">10%</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-lg-12 statistics-paragraph-result">
                <div class="col-lg-4">
                    <?= Html::img('@web/images/u3148.png', ['alt' => 'Статистика']) ?>
                </div>
                <div class="col-lg-8 statistics-paragraph-interest">
                    <p class="statistics-paragraph-interest_title">САМЫЕ ТЯЖЕЛЫЕ ВОПРОСЫ:</p>
                    <table>
                        <tr>
                            <td>Вопрос №12</td>
                            <td class="table-errors">112 ошибок</td>
                        </tr>
                        <tr>
                            <td>Вопрос №2</td>
                            <td class="table-errors">89 ошибок</td>
                        </tr>
                        <tr>
                            <td>Вопрос №7</td>
                            <td class="table-errors">5 ошибок</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="recomendation">
                <p>РЕКОМЕНДАЦИЯ</p>
                <hr/>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    'id' => 'modal-editQuestion',
    'header' => 'Редактировние вопроса',
]);

echo '<div class="modal-content"></div>';

Modal::end(); ?>