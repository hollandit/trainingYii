<?php

namespace frontend\controllers;

use app\models\Depreming;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class SalaryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'delete'],
                        'allow' => true,
                        'roles' => ['hr']
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $arr = [];
        $model = new Depreming();
        $users = User::find()->select(['name', 'last_name', 'patronymic', 'salary', 'id_position', 'id'])->where(['active' => User::WORK])->all();

        foreach ($users as $user){
            $userArr = [];
            $userArr['id'] = $user->id;
            $userArr['name'] = $user->nameEmployee;
            $userArr['position'] = $user->position->name;
            $userArr['salary'] = $user->salary;
            $arr[] = $userArr;
        }
        $depreming = Depreming::find()->andWhere(['between', 'create_at', date('Y-m-01 00:00:00'), date('Y-m-31 23:59:59')])->all();
        $arr = ArrayHelper::index($arr, 'id', 'position');
        return $this->render('index', compact('users', 'model', 'depreming', 'arr'));
    }

    public function actionCreate(){
        $model = new Depreming();
        $request = Yii::$app->request;
        if(Yii::$app->request->post()){
            $model->type = $request->post('type');
            $model->id_user = $request->post('user');
            $model->amount = $request->post('amount');
            $model->comment = $request->post('comment');
            return $model->save();
        }
    }

    public function actionDelete($id){
        $model = Depreming::findOne($id);
        return $model->delete();
    }
}
