<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\Work;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * @return Response|string
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register())
        {
            return $this->redirect(['site/login']);
        }
        return $this->render('register', [
            'model' => $model,
            ]);
    }

    public function actionAdministration()
    {        
        if(Yii::$app->request->post('accion') == 'lockUser' && Yii::$app->request->post('id') != null)
        {
            Yii::$app->user->getIdentity()->lockUnlock(Yii::$app->request->post('id'), false);
            return $this->refresh();
        }

        if(Yii::$app->request->post('accion') == 'unlockUser' && Yii::$app->request->post('id') != null)
        {
            Yii::$app->user->getIdentity()->lockUnlock(Yii::$app->request->post('id'), true);
            return $this->refresh();
        }

        return $this->render('administration', ['dataProvider' => Yii::$app->user->getIdentity()->allUsers()]);
    }

    public function actionProfile()
    {
        if(Yii::$app->request->post('accion') == 'delete' && Yii::$app->request->post('id') != null)
        {
            Yii::$app->user->getIdentity()->deleteUser(Yii::$app->request->post('id'));
            return $this->actionLogout();
        }
        return $this->render('profile');
    }

    public function actionMedioteca()
    {
        $model = new Work();
        
        if(Yii::$app->request->get('search-button')=='search-button')
        {
            return $this->render('medioteca', ['dataProvider' => $model->allWorksFilter(Yii::$app->request->get('search'), Yii::$app->request->get('type'))]);
        }
        else
        {
            return $this->render('medioteca', ['dataProvider' => $model->allWorks()]);
        }
        
        
    }

    public function actionNewwork()
    {       

        if(!Yii::$app->user->isGuest)
        {
            $model = new Work();
            if (Yii::$app->request->post('create-button') == 'create-button' && $model->load(Yii::$app->request->post()))
            {
                if( !$model->registerWork())
                {
                    return $this->render('createWork', ['model' => $model]);
                }
                return $this->render('workView', ['model' => $model]);
            }
            return $this->render('createWork', ['model' => $model]);
        }
        else
        {
            return $this->actionMedioteca();
        }
    }

    public function actionWorkview()
    {
        if(Yii::$app->request->get('id') != null)
        {      
            $model = new Work();
            $model = Work::findWorkId(Yii::$app->request->get('id'));     

            if($model!=null)
            {
                return $this->render('workView', ['model' => $model]);
            }
            else
            {
               throw new \yii\web\NotFoundHttpException();
            }
        }
    }
}
