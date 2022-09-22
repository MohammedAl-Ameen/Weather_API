<?php

namespace app\controllers;

use Yii;
use Exception;
use yii\base\View;
use yii\web\Response;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SignupForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\helpers;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        try {
            return [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['logout'],
                    'rules' => [
                        [
                            'actions' => ['logout'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['weather'],
                    'rules' => [
                        [
                            'actions' => ['weather'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ];
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        try {
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ],
                'captcha' => [
                    'class' => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
            ];
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        try {
            return $this->render('index');
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        try {
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }

            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }


    /**
     * Signup action.
     *
     * @return Response|string
     */
    public function actionSignup()
    {
        try {
            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post()) && $model->signup()) {
                return $this->redirect(url: yii::$app->homeUrl);
            }

            return $this->render('signup', [
                'model' => $model,
            ]);
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        try {
            Yii::$app->user->logout();

            return $this->goHome();
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }


    /**
     * Displays whether page.
     *
     * @return string
     */
    public function actionWeather()
    {
        try {
            $role = Yii::$app->user->identity->role;

            return $this->render('weather', [
                "role" => $role,
            ]);
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }
}
