<?php

namespace frontend\controllers;

use app\models\Choice;
use app\models\Testing;
use app\models\Thema;
use \Yii;
use app\models\Questions;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;

class TestController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete','update-theme','delete-theme','test', 'result-test'],
                        'allow' => true,
                        'roles' => ['hr']
                    ],
                    [
                        'actions' => ['index', 'result'],
                        'allow' => true,
                        'roles' => ['employee']
                    ],
                    [
                        'actions' => ['testing', 'compulsory', 'term'],
                        'allow' => true,
                        'roles' => ['hr', 'employee']
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Questions();
        $themaModel = new Thema();
        $request = Yii::$app->request;
        $thema = $request->post('Thema');
        $question = $request->post('Question');
        $answer = $request->post('Answer');
        $right = $request->post('right');
        if ($request->post()){
            if ((int)$thema != 0){
                $model->id_theme = (int)$thema;
            } else {
                $themaModel->name = $thema;
                $themaModel->minute = $request->post('minute');
                $themaModel->second = $request->post('second');
                if (!$themaModel->save()) {
                    print_r($themaModel->getErrors());
                }
                $model->id_theme = $themaModel->id;
            }
            $model->name = $question;
            $model->answear = Json::encode($answer, JSON_UNESCAPED_UNICODE);
            $model->correct = '{"right": "'.$right.'"}';
            if(!$model->save()){
                print_r($model->getErrors());
            } else {
                $model->save();
                if (is_uploaded_file($_FILES['attachment']['tmp_name'][0])){
                    $model->upload($model->id);
                };
                return $this->redirect(['test/test', 'id' => $model->id_theme]);
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = Questions::findOne($id);
        $request = Yii::$app->request;
        if ($request->post()){
            if (is_uploaded_file($_FILES['attachment']['tmp_name'][0])){
                $model->upload($id);
            }
            $model->name = $request->post('Question');
            $model->answear = json_encode($request->post('Answer'), JSON_UNESCAPED_UNICODE);
            $model->correct = '{"right": "'.$request->post('right').'"}';
            if (!$model->save()){
                print_r($model->getErrors());
            }
            return $this->redirect(['test/test', 'id' => $model->id_theme]);
        }

        return $this->renderAjax('update', [
            'model' => $model
        ]);
    }

    public function actionUpdateTheme($id)
    {
        $model = Thema::findOne($id);
        if($model->load(Yii::$app->request->post())){
            if (!$model->save()){
                print_r($model->getErrors());
            } else {
                return $this->redirect(['test', 'id' => $id]);
            }
        }
        return $this->renderAjax('update-theme', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Questions::findOne($id);
        $model->active = Questions::NOT_ACTIVE;
        $model->correct = json_encode($model->correct, JSON_UNESCAPED_UNICODE);
        $model->answear = json_encode($model->answear, JSON_UNESCAPED_UNICODE);
        if(!$model->save()){
            print_r($model->getErrors());
        };
        return $this->redirect(['test', 'id' => $model->id_theme]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteTheme($id)
    {
        Thema::findOne($id)->delete();
        return $this->redirect(['test/test', 'id' => 1]);
    }

    public function actionTesting($id)
    {
        if ((int)Testing::find()->andWhere(['=', 'id_user', Yii::$app->user->id])->andWhere(['in', 'id_theme', $id])->count() !== 0){
            return $this->redirect(['site/index']);
        }
        $idUser = Yii::$app->user->id;
        $startTest = new Testing();
        $startTest->id_user = $idUser;
        $startTest->id_theme = $id;
        $startTest->save();
        $this->layout = 'test';
        $model = Questions::find()->where(['id_theme' => $id])->all();
        $right = 0;
        $done = null;
        //result test for user
        if (Yii::$app->request->post('Answear')){
            $result = [];
            foreach ($model as $value){
                foreach ($value->correct as $key => $correct){
                    if (Yii::$app->request->post('Answear')[$value->id] == $correct){
                        $right++;
                    };
                }
            }
            $choice = new Choice();
            $choice->id_user = $idUser;
            $choice->id_theme = $model[0]->id_theme;
            $choice->answear = json_encode(Yii::$app->request->post('Answear'), JSON_UNESCAPED_UNICODE);
            $choice->result = $right;
            if (!$choice->save()){
                print_r($choice->getErrors());
            }
            if ($right == count($model)) {
                $result['right'] = $right;
                $result['status'] = 1;
                return json_encode($result, JSON_UNESCAPED_UNICODE);
            } else {
                $result['right'] = $right;
                $result['status'] = 0;
                return json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }

        return $this->render('test', [
            'model' => $model,
            'right' => $right,
            'done' => $done,
        ]);
    }

    public function actionResultTest()
    {
        $query = Choice::find()->orderBy(['date' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('result-test', [
            'model' => $model,
            'pages' => $pages
        ]);
    }

    public function actionResult($message, $right)
    {
        return $this->render('result', [
            'message' => $message,
            'right' => $right
        ]);
    }

    public function actionTest($id)
    {
        $thema = Thema::find()->where(['id' => $id])->one();
        $model = Questions::find()->with('idThemeQuestion')->where(['id_theme' => $id, 'active' => Questions::ACTIVE])->all();

        return $this->render('admin-test', [
            'model' => $model,
            'thema' => $thema
        ]);
    }

    public function actionTerm($id)
    {
        return $this->saveDb($id, 'Закончилось время');
    }

    public function actionCompulsory($id)
    {
        return $this->saveDb($id, 'Принудительно закрыл тест');
    }

    protected function saveDb($id, $message)
    {
        $model = Questions::find()->where(['id_theme' => $id])->all();
        $choice = new Choice();
        $choice->id_user = Yii::$app->user->id;
        $choice->id_theme = $model[0]->id_theme;
        $choice->answear = json_encode(['action' => $message], JSON_UNESCAPED_UNICODE);
        $choice->result = 0;
        if(!$choice->save()){
            print_r($choice->getErrors());
        }
        return $this->redirect(['site/index']);
    }
}
