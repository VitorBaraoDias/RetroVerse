<?php

namespace backend\controllers;

use common\models\Linhavenda;
use common\models\LoginForm;
use common\models\User;
use common\models\Denuncia;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'logout'],
                        'allow' => true,
                        'roles' => ['?', "@"],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin', 'moderador'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['site/login']);
                }

            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
                'class' => \yii\web\ErrorAction::class,
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
        $userCount = User::find()->count();
        $marketplaceSales = Linhavenda::getVendasMensaisPorTipoArtigo('MARKETPLACE');
        $lojaSales = Linhavenda::getVendasMensaisPorTipoArtigo('LOJA');
        $marcasData = Linhavenda::getMarcasMaisVendidas();



        $lojaSalesCount = $this->getSalesData("LOJA");
        $marketplaceSalesCount = $this->getSalesData("MARKETPLACE");
        $denunciasPendentes = $this->getDenunciasPendentes();

        return $this->render('index', [
            'marketplaceSales' => json_encode($marketplaceSales),
            'lojaSales' => json_encode($lojaSales),
            'userCount' => $userCount,
            'marcas' => json_encode($marcasData['marcas']),
            'quantidadeVendas' => json_encode($marcasData['quantidade_vendas']),
            'lojaSalesCount' => $lojaSalesCount,
            'marketplaceSalesCount' => $marketplaceSalesCount,
            'denunciasPendentes' => $denunciasPendentes,
        ]);
    }

    private function getSalesData($type)
    {

        $salesCount = Linhavenda::find()
            ->joinWith('idartigo0')
            ->where(['artigos.tipoartigo' => $type])
            ->count();

        return $salesCount ?: 0;
    }

    private function getDenunciasPendentes()
    {

        $denunciasCount = Denuncia::find()
            ->where(['estado' => 0])
            ->count();

        return $denunciasCount ?: 0;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'blank';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $user = \common\models\User::findByUsername($model->username);
                if ($user) {
                    $user_roles = Yii::$app->authManager->getRolesByUser($user->id);
                    if (!isset($user_roles['admin']) && !isset($user_roles['moderador'])) {
                        return $this->redirect(['site/login']);
                    }
                    if ($model->login()) {
                        return $this->goBack();
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Usuário não encontrado.');
                }
            }
        }
        Yii::$app->session->setFlash('error', 'Você não tem permissão para acessar esta área.');
        $model->password = '';
        // Renderiza a página de login

        return $this->render('login', ['model' => $model,]);
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

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }




}
