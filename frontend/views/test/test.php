<?php

use app\models\Image;
use yii\bootstrap\Modal;
use yii\bootstrap\Progress;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$write = $model[0];
$lenght = count($model);

$compulsory = Url::to(['test/compulsory', 'id' => $write->id_theme]);
$term = Url::to(['test/term', 'id' => $write->id_theme]);
function stringLenght($time){
    if (strlen($time) < 2){
        return '0'.$time;
    }
    return $time;
}
$minute = stringLenght($model[0]->idThemeQuestion->minute);
$second = stringLenght($model[0]->idThemeQuestion->second);
?>

<header class="header">
    <div class="container">
        <div class="header-test-logo">
            <?= Html::img('@web/images/u156.png')
            .'<span> Тест "<span class="test-title" data-toggle="tooltip" title="'.$write->idThemeQuestion->name.'">'. StringHelper::truncate($write->idThemeQuestion->name, 8, '...').'</span>"</span>'
            ?>
        </div>
        <div class="header-timer" id="timer">
            <div><span id="m"><?= $minute[0] ?></span></div>
            <div><span id="mm"><?= $minute[1] ?></span></div>
            <div><span>:</span></div>
            <div><span id="s"><?= $second[0] ?></span></div>
            <div><span id="ss"><?= $second[1] ?></span></div>
        </div>
        <div class="header-completion">
            <?= Html::a('<i class="fa fa-2x fa-angle-double-right" aria-hidden="true"></i><span>Завершить тест<span>', ['#'], ['class' => 'headerCRM pull-left', 'id' => 'completion-button']);?>
        </div>
    </div>
</header>
<div class="test-testing container">
    <?php echo Html::beginForm(['test/testing', 'id' => $write->id_theme], 'post', ['id' => 'testForm-result', 'data-id' => $write->id_theme]) ?>
        <?php foreach ($model as $count => $question){
            $count = $count+1;
            $imageModel = Image::find()->where(['id_question' => $question->id]);
            $image = $imageModel->all();
            $imageCount = $imageModel->count();
            echo '<div class="test-block">';
            try {
                echo Progress::widget([
                    'percent' => ($count/$lenght)*100,
                    'label' => '<p class="progress-test_info">progress '.$count.'/'.$lenght.'</p>'
                ]);
            } catch (Exception $e) {
                $e->getMessage();
            }
            echo '<div class="test-block-question">'.$question->name.'</div>';
            echo '<hr/>';
            echo '<div class="row test-block-images">';
                foreach ($image as $i => $images){
                    switch ($imageCount){
                        case '4':
                            echo '<div class="col-lg-6">'.Html::a(Html::img($images->path, ['style' => 'width:329px;height:143px;']), $images->path, ['data-lightbox' => 'roadtrip']).'</div>';
                            break;
                        case '3':
                            if ($i == 0){
                                echo '<div class="col-lg-6">'.Html::a(Html::img($images->path, ['style' => 'width:329px;height:292px;']), $images->path, ['data-lightbox' => 'roadtrip']).'</div>';
                            } else {
                                echo '<div class="col-lg-6">'.Html::a(Html::img($images->path, ['style' => 'width:329px;height:143px;']), $images->path, ['data-lightbox' => 'roadtrip']).'</div>';
                            };
                            break;
                        case '2':
                            echo '<div class="col-lg-6">'.Html::a(Html::img($images->path, ['style' => 'width:329px;height:143px;']), $images->path, ['data-lightbox' => 'roadtrip']).'</div>';
                            break;
                        default:
                            echo '<div class="col-lg-12">'.Html::a(Html::img($images->path, ['style' => 'width:660px;height:295px;']), $images->path, ['data-lightbox' => 'roadtrip']).'</div>';
                    }
                }
            echo '</div>';
            echo '<div class="test-block-answer">';
                foreach ($question->answear as $key => $answear){
                    if ($count != $lenght){
                        echo Html::radio('Answear['.$question->id.']', false, ['label' => $answear, 'required' => true, 'value' => $answear, 'class' => 'test-radio nextTest']);
                    } else {
                        echo Html::radio('Answear['.$question->id.']', false, ['label' => $answear, 'required' => true, 'value' => $answear, 'class' => 'test-radio test-answer']);
                    }
                }
            echo '</div>';
            echo '</div>';
        } ?>
    <?php echo Html::submitButton('Ответить', ['class' => 'answerButton']); ?>
    <?php echo Html::button('Срок', ['class' => 'answerButton', 'id' => 'buttonTerm']); ?>
    <?php echo Html::endForm() ?>
    <?php Modal::begin([
        'id' => 'modalResult',
        'header' => 'Результаты'
    ]);
    echo '<div class="modal-result_test"></div>';
    echo '<div class="modal-footer">'.
        Html::a('ОК', ['test/index'], ['class' => 'btn modal-result_button'])
    .'</div>';
    Modal::end()?>

    <?php Modal::begin([
        'id' => 'modalTerm',
        'header' => 'ВРЕМЯ ИСТЕКЛО...'
    ]);
    echo '<div class="modal-result_test"></div>';
    echo '<div class="modal-footer">'.
        Html::a('ОК', ['test/index'], ['class' => 'btn modal-result_button timeTerm'])
        .'</div>';
    Modal::end()?>
</div>
<?php $script = <<< JS
  window.onkeydown = function(evt) {
     if(evt.keyCode === 116) return false;
  };
  let urlSite = 'http://hosttraining';
  function timer(){
    let minute = document.getElementById("m").innerHTML + document.getElementById("mm").innerHTML;
    let second = document.getElementById("s").innerHTML + document.getElementById("ss").innerHTML;
    let end = false;

    if(second > 0) second--;
    else {
      second = 59;
      if( minute > 0) minute--;
      else {
        end = true;
      }
    }
    if(end){
      clearInterval(intervalID);
      $('#modalTerm').modal('show');
      $('#modalTerm').on('hide.bs.modal', function () {
          window.location.replace(urlSite+'$term');
      });
      $('body').on('click', '.timeTerm', function(e) {
        e.preventDefault();
        window.location.replace(urlSite+'$term');
      });
      $('.modal-result_test').html('<div class="modal-result_title">К сожалению, Вы не прошли тест.<br/>' +
                        '</div><div class="modal-result_information">Это плохой результат.<br>' +
                        'Этот тест Вы сможете пройти не раньше, чем через 2 недели.<br>' +
                        'Рекомендую Вам не тратить это время зря и основательно подготовиться.</div><div class="modal-result_information">' +
                        'Успехов!' +
                        '</div>');
      console.log("Время истекло");
    } else {
      document.getElementById("m").innerHTML = Math.floor(minute/10);
      document.getElementById("mm").innerHTML = minute % 10;
      document.getElementById("s").innerHTML = Math.floor(second/10);
      document.getElementById("ss").innerHTML = second % 10;
    }
  }
  window.intervalID = setInterval(timer, 1000);
  $('.test-title').tooltip({
      placement: 'bottom'
  });
  $('#completion-button').click(function (e) {
      e.preventDefault();
      let div = document.createElement('div');
      div.className = 'completion-modal';
      div.onclick = function (e) {
          let t = e ? e.target : window.event.srcElement;
          if(t.tagName === 'INPUT'){
              t.value === 'Завершить' && window.location.replace(urlSite+'$compulsory');
              this.parentNode.removeChild(this);
          }
      };
      div.innerHTML='<div><h1>Уверены?...</h1><br/><p>Если Вы завершите тест сейчас, то он будет считаться непройденным. Это отрицательно отразится на Вашем рейтинге.</p></div><input type="button" value="Вернуться к тесту"><input type="button" class="completion-button" value="Завершить">';
      return document.body.appendChild(div);
  });

JS;
$this->registerJs($script)?>
