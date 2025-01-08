<?php

namespace frontend\controllers;

use Yii;
use common\models\Artigo;
use common\models\Artigospremium;
use common\models\LoginForm;
use common\models\Perfil;
use common\models\Plano;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use common\models\Banner;
use common\models\Favorito;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->isGuest) {
                        return Yii::$app->response->redirect(['site/index']);
                    }
                    return Yii::$app->response->redirect(['site/login']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;

            if ($user && $user->perfil && $user->perfil->banido) {
                Yii::$app->user->logout();

                Yii::$app->session->setFlash('error', 'Your account has been banned. You cannot access this page.');

                return $this->redirect(['site/login']);
            }
        }

        return parent::beforeAction($action);
    }


    public function actionIndex()
    {

        $userId = Yii::$app->user->id;
        $perfil = Perfil::findOne(['id' => $userId]);

        $isPremiumActive = $perfil ? $perfil->hasActivePremiumPlano() : false;

        $dataProvider1 = new ActiveDataProvider([
            'query' => Artigo::find()
                ->with('fotosartigos')
                ->where(['not in', 'id', (new Query())->select('id')->from('artigospremium')])
                ->andWhere(['ativo' => 1])
                ->andWhere(['tipoartigo' => 'LOJA'])
                ->orderBy(['datacriacao' => SORT_DESC])
                ->limit(4),
            'pagination' => false,
        ]);


        $dataProvider2 = new ActiveDataProvider([
            'query' => Artigospremium::find()
                ->joinWith('artigo AS artigo')
                ->andWhere(['artigo.ativo' => 1])
                ->orderBy(['datacriacao' => SORT_DESC])
                ->limit(4),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);

        $banners = Banner::find()->where(['ativo' => 1])->asArray()->all();


        return $this->render('index', [
            'dataProvider1' => $dataProvider1,
            'dataProvider2' => $dataProvider2,
            'isPremiumActive' => $isPremiumActive,
            'banners' => $banners
        ]);
    }


    public function actionLogin()
    {

        $this->layout = 'blank';

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


    public function actionLogout()
    {

        Yii::$app->user->logout();
        Yii::$app->session->destroy();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionTerms()
    {
        return $this->render('terms');
    }


    public function actionPremium()
    {
        $plano = Plano::findOne(['id' => 2]);
        return $this->render('premium', ['plano' => $plano,
        ]);
    }



    public function actionSignup()
    {
        $this->layout = 'blank';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        Yii::error('Error submitting the form.', __METHOD__);
        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }


    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
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


    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }


    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
