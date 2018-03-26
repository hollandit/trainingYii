<?php

namespace frontend\controllers;

use app\models\ShiftsSearch;
use app\models\Shop;
use app\models\User;
use Yii;
use app\models\Shifts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShiftsController implements the CRUD actions for Shifts model.
 */
class ShiftsController extends Controller
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
        ];
    }

    /**
     * Lists all Shifts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $shops = Shop::find()->all();
        $searchModel = new ShiftsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('shops', 'searchModel', 'dataProvider'));
    }

    /**
     * Displays a single Shifts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Shifts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shifts();
        $user = User::find()->where(['active' => User::WORK])->all();
        $request = Yii::$app->request;

        if (Yii::$app->request->post()){
            $arr = explode(' ', $request->post('date'));
            unset($arr[0]);
            $date = [1 => 'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];
            $key = array_keys($date, $arr[2])[0];
            $model->user_id = $request->post('user');
            $model->shop_id = $request->post('shop');
            $model->date = $arr[3].'-'.$key.'-'.$arr[1];
            $model->start_time = date('H:i', strtotime($request->post('start')));
            $model->end_time = date('H:i', strtotime($request->post('end')));
            if (!$model->save()){
                return json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE);
            }
            return true;
        }

        return $this->renderAjax('create', compact('model', 'user'));
    }

    /**
     * Updates an existing Shifts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = User::find()->where(['active' => User::WORK])->all();
        $request = Yii::$app->request;

        if($request->post()){
            $arr = explode(' ', $request->post('date'));
            unset($arr[0]);
            $date = [1 => 'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];
            $key = array_keys($date, $arr[2])[0];
            $model->user_id = $request->post('user');
            $model->shop_id = $request->post('shop');
            $model->date = $arr[3].'-'.$key.'-'.$arr[1];
            $model->start_time = date('H:i', strtotime($request->post('start')));
            $model->end_time = date('H:i', strtotime($request->post('end')));
            if (!$model->save()){
                return json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE);
            }
            return true;
        }

        return $this->renderAjax('update', compact('model', 'user'));
    }

    /**
     * Deletes an existing Shifts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return true;
//        return $this->redirect(['index']);
    }

    /**
     * Finds the Shifts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shifts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shifts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
