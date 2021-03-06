<?php

namespace frontend\controllers;

use app\models\Access;
use app\models\AuthAssignment;
use app\models\ChoiceSearch;
use app\models\Position;
use frontend\models\SignupForm;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'create-position', 'dismised', 'delete', 'update-contact', 'update-info'],
                        'allow' => true,
                        'roles' => ['hr']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $position = new Position();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'position' => $position
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new ChoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $access = Access::find()->with('theme')->where(['id_user' => $id])->all();
        return $this->render('view', compact('searchModel', 'dataProvider', 'model', 'access'));
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())){
            if ($model->signup()){
                $user = User::find()->select('id')->where(['username' => $model->username])->one();
                $role = new AuthAssignment();
                $role->item_name = 'employee';
                $role->user_id = $user->id;
                if (!$role->save()){
                    print_r($role->getErrors());
                }
                return $this->redirect(['user/index']);
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateContact($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->post()){
            if ($model->email != $request->post('email') || $model->phone != $request->post('phone')){
                $model->email = $request->post('email');
                $model->phone = $request->post('phone');
                if (!$model->save()){
                    return json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE);
                }
            }
            $model = ['email' => $model->email, 'phone' => $model->phone];
            return json_encode($model);
        }

        $model = ['phone' => $model->phone, 'email' => $model->email];
        return json_encode($model);
    }

    public function actionUpdateInfo($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $position = Position::find()->with('themas')->all();
        $arrPosition = [];
        foreach ($position as $value){
            $arrPosition[] = ['id' => $value->id, 'name' => $value->name];
        }

        if ($request->post()){
            if ($model->salary != $request->post('post') || $model->id_position != $request->post('position')){
                $model->salary = $request->post('salary');
                $model->id_position = $request->post('position');
                if (!$model->save()){
                    return json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE);
                }
            }
            $model = ['salary' => $model->salary, 'position' => $model->position->name];
            return json_encode($model);
        }

        $model = ['salary' => $model->salary, 'position' => ['id' => $model->id_position, 'name' => $model->position->name], 'allPosition' => $arrPosition];
        return json_encode($model);
    }

    public function actionDismised($id)
    {
        $model = User::findOne($id);
        $model->active = User::DISMISSED;
        if (!$model->save()){
            print_r($model->getErrors());
        };
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
