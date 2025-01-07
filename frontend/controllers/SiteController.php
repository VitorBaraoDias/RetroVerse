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
                    throw new \yii\web\ForbiddenHttpException('Você não tem permissão para realizar esta ação.');
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
        // Verifica se o usuário está logado
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;

            // Verifica se o perfil do usuário está banido
            if ($user && $user->perfil && $user->perfil->banido) {
                // Desconecta o usuário
                Yii::$app->user->logout();

                // Define uma mensagem de erro
                Yii::$app->session->setFlash('error', 'Sua conta foi banida. Você não pode acessar esta página.');

                // Redireciona para a página de login
                return $this->redirect(['site/login']);
            }
        }

        // Caso contrário, o fluxo normal continua
        return parent::beforeAction($action);
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $userId = Yii::$app->user->id;
        $perfil = Perfil::findOne(['id' => $userId]);

        //verificar se ele tem premium
        $isPremiumActive = $perfil ? $perfil->hasActivePremiumPlano() : false;

        $dataProvider1 = new ActiveDataProvider([
            'query' => Artigo::find()
                ->with('fotosartigos')
                ->where(['not in', 'id', (new Query())->select('id')->from('artigospremium')]) // exclui os artigos premium
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

    /**
     * Logs in a user.
     *
     * @return mixed
     */
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

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {

        Yii::$app->user->logout();
        Yii::$app->session->destroy();
        return $this->goHome();
    }
    /**
     * Displays contact page.
     *
     * @return mixed
     */
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
    /**
     * Displays about page.
     *
     * @return mixed
     */
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

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'blank';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        Yii::error('Erro no envio do formulário.', __METHOD__);
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
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
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

    /**
     * Resend verification email
     *
     * @return mixed
     */
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
