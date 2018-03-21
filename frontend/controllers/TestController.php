<?php

namespace frontend\controllers;

use app\models\Access;
use app\models\Choice;
use app\models\Testing;
use app\models\Thema;
use app\models\User;
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
                        'actions' => ['create', 'update', 'delete','update-theme','delete-theme','test', 'result-test', 'condition'],
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

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionTesting($id)
    {
        if ((int)Testing::find()->andWhere(['=', 'id_user', Yii::$app->user->id])->andWhere(['in', 'id_theme', $id])->count() !== 0 && !Yii::$app->request->isAjax){
            return $this->redirect(['site/index']);
        }
        $idUser = Yii::$app->user->id;
        $startTest = new Testing();
        $startTest->saveTesting($idUser, $id);
        $this->layout = 'test';
        $model = Questions::find()->where(['id_theme' => $id])->all();
        shuffle($model);
        return $this->render('test', compact('model', 'right', 'done'));
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

    /**
     * @param $id
     * @return string
     */
    public function actionResult($id)
    {
        $idUser = Yii::$app->user->id;
        $this->layout = 'test';
        $model = Questions::find()->select(['correct', 'id_theme', 'id'])->where(['id_theme' => $id])->all();

        //result test for user
        if (Yii::$app->request->post('Answear')){
            $right = 0;
            foreach ($model as $value){
                for ($i = 0; $i < count($value); $i++){
                    if (Yii::$app->request->post('Answear')[$value->id] == $value->correct['right']){
                        $right++;
                    };
                }
            }
            $choice = new Choice();
            $choice->saveDB($idUser, $model, $right, Yii::$app->request->post('Answear'));
            $access = Access::find()->where(['id_theme' => $id, 'done' => 0, 'id_user' => $idUser])->one();
            $access->done = Access::DONE;
            $access->save();
            if ($right == count($model)) {
                $result['right'] = $right;
                $result['status'] = Choice::PASS;
                return json_encode($result, JSON_UNESCAPED_UNICODE);
            } else {
                $result['right'] = $right;
                $result['status'] = Choice::NOT_PASS;
                return json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }
        return $model;
    }

    /**
     * @param $id
     * @return array|string|\yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionTest($id)
    {
        $idUser = Yii::$app->request->post('apoint');
        $thema = Thema::find()->where(['id' => $id])->one();
        $user = User::find()->select(['id', 'last_name', 'name', 'patronymic'])->where(['active' => 1])->all();
        $model = Questions::find()->with('idThemeQuestion')->where(['id_theme' => $id, 'active' => Questions::ACTIVE])->all();
        $access = Access::find()->select(['id_theme', 'create_at', 'id_user'])->where(['id_theme' => $id])->limit(6)->orderBy('id DESC')->all();

        if ($idUser){
            $accessDelete = Access::find()->where(['id_theme' => $id, 'id_user' => $idUser])->one();
            $testing = Testing::find()->where(['id_theme' => $id, 'id_user' => $idUser])->one();
            if ($accessDelete != null){
                $accessDelete->delete();
            }
            if ($testing != null){
                $testing->delete();
            }
            $model = new Access();
            $model->id_user = $idUser;
            $model->id_theme = $id;
            if (!$model->save()){
                return $model->getErrors();
            } else {
                return true;
            }
        }
        return $this->render('admin-test', compact('model', 'thema', 'user', 'access'));
    }

    public function actionCondition($id)
    {
        $model = Thema::findOne($id);
        if (Yii::$app->request->post()){
            $model->conditions = Yii::$app->request->post('conditions');
            if (!$model->save()){
                return json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE);
            } else {
                return true;
            }
        }
        return $model;
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
