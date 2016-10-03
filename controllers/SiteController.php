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
use app\components\helpers\KladrHelper;

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
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
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
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
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
     * Displays search detail information page.
     *
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionDetail($id)
    {
        if (!$id || !is_numeric($id)) {
            return $this->goHome();
        }

        $searchAddressModel = new SearchAddress();
        $search_request = $searchAddressModel->getSearchRequestById($id);
        $search_result = [];

        if (!empty($search_request['request'])) {
            $search_result = KladrHelper::get($search_request['request']);
        }

        return $this->render('detail', [
            'search_request' => $search_request,
            'search_result'  => $search_result,
        ]);
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
        $searchAddressForm = new SearchAddressForm();

        if ($searchAddressForm->load(Yii::$app->request->post()) && $searchAddressForm->search()) {

            if (!empty($searchAddressForm->address)) {
                $result = KladrHelper::get($searchAddressForm->address);

                $data['search_request'] = $searchAddressForm->address;
                $data['search'] = 'Not found';

                if (!empty($result)) {
                    $data['search'] = $result[0]['fullName'];
                    $searchAddressModel->insertRecordsTransaction($data['search_request'], $result[0]);
                }
            }
        }

        $data['search_history'] = $searchAddressModel->selectSearchRequests(5);

        return $this->render('search', [
            'model' => $searchAddressForm,
            'data'  => $data,
        ]);
    }
}
