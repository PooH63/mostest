<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SearchAddressForm;
use app\models\SearchAddress;

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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays search page.
     *
     * @return string
     */
    public function actionSearch()
    {
        $data = [];
        $searchAddressModel = new SearchAddress();
        $searchAddressForm  = new SearchAddressForm();

        if ($searchAddressForm->load(Yii::$app->request->post()) && $searchAddressForm->search()) {

            if(!empty($searchAddressForm->address)) {
                $kladrApi = new \Kladr\Api('51dfe5d42fb2b43e3300006e', '86a2c2a06f1b2451a87d05512cc2c3edfdf41969');

                $kladrQuery = new \Kladr\Query();
                $kladrQuery->ContentName = $searchAddressForm->address;
                $kladrQuery->OneString = TRUE;
                $kladrQuery->Limit     = 5;

                $arResult = $kladrApi->QueryToArray($kladrQuery);

                $data['search_request'] = $searchAddressForm->address;
                $data['search'] = $arResult[0]['fullName'];

                $searchAddressModel->insertRecords($searchAddressForm->address);
            }
        }

        $data['search_history'] = $searchAddressModel->selectRecords(5);

        return $this->render('search', [
            'model' => $searchAddressForm,
            'data' => $data,
        ]);
    }
}
