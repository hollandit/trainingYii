<?php
namespace frontend\controllers;

use app\models\Access;
use app\models\Choice;
use app\models\Knowledge;
use app\models\Testing;
use app\models\Thema;
use app\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $arr = [];
        $accessArr = [];
        $idUser = Yii::$app->user->id;
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } else {
            $user = User::findOne(Yii::$app->user->identity->id);
            $testing = Testing::find()->select('id_theme')->where(['id_user' => $idUser])->andWhere(['>', 'beginning', date('Y-m-d 00:00:00', strtotime('-2 week'))])->all();
            $access = Access::find()->select('id_theme')->where(['id_user' => $idUser, 'done' => Access::NOT_DONE])->groupBy('id_theme')->all();
            foreach ($access as $acc){
                $accessArr[] = $acc->id_theme;
            }
            foreach ($testing as $key => $test){
                $arr[] = $test->id_theme;
            }
            $thema = Thema::find()->andWhere(['not in', 'id', $arr])->andWhere(['in', 'id', $accessArr])->limit(10)->all();
            $choice = Choice::find();
            $count = $choice->where(['id_user' => $user->id])->count();
            $done = $choice->where(['id_user' => $user->id, 'done' => Choice::PASS])->count();
            $failed = $choice->where(['id_user' => $user->id, 'done' => Choice::NOT_PASS])->count();
            return $this->render('index', compact('user', 'thema', 'count', 'done', 'failed', 'arr'));
        }
    }

    /**
     * @return string
     */
    public function actionKnowledge()
    {
        $model = Knowledge::find()->limit(1)->all();

        return $this->render('knowledge', [
           'model' => $model,
        ]);
    }

    public function actionPost($id)
    {
        $model = Knowledge::findOne($id);
        return $this->render('post', [
            'model' => $model
        ]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $user = Yii::$app->user;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($user->can('hr')){
                return $this->redirect(['user/index']);
            } else {
                return $this->redirect(['site/index']);
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
