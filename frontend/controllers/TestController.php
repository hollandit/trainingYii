<?php

namespace frontend\controllers;

use \Yii;
use app\models\Questions;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTesting($id)
    {
        $model = Questions::find()->where(['id_theme' => $id])->all();
        $right = 0;
        $done = null;
        if (Yii::$app->request->post('Answear')){
            foreach ($model as $value){
                foreach ($value->correct as $key => $correct){
                    if (Yii::$app->request->post('Answear')[$value->id] == $correct){
                        $right++;
                    };
                }
            }
            if ($right == 15){
                return $this->redirect(['test/result', 'message' => 'Тест пройден', 'right' => $right]);
            } else {
                return $this->redirect(['test/result', 'message' => 'Тест провален', 'right' => $right]);
            }
        }

        return $this->render('test', [
            'model' => $model,
            'right' => $right,
            'done' => $done
        ]);
    }

    public function actionResult($message, $right)
    {
        return $this->render('result', [
            'message' => $message,
            'right' => $right
        ]);
    }
}
