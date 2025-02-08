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
                        'actions' => ['index', 'getdenunciaspendentes'],
                        'allow' => true,
                        'roles' => ['admin', 'moderador'],
                    ],
                    [
                        'actions' => ['getsalesdata'],
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
                'layout' => 'blank',
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
        if (Yii::$app->user->can('verDashboardCompletaBackend')) {

            //para o admin
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
        } else {
            //para o moderador
            $denunciasPendentes = $this->getDenunciasPendentes();

            return $this->render('index', [
                'denunciasPendentes' => $denunciasPendentes,
            ]);
        }
    }

    private function getSalesData($type)
    {
        if (Yii::$app->user->can('getInformacoesVendasBackend')) {
            $salesCount = Linhavenda::find()
                ->joinWith('idartigo0')
                ->where(['artigos.tipoartigo' => $type])
                ->count();

            return $salesCount ?: 0;
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to use this function.');
        }
    }

    private function getDenunciasPendentes()
    {
        if (Yii::$app->user->can('getInformacoesDenunciasBackend')) {
        $denunciasCount = Denuncia::find()
            ->where(['estado' => 0])
            ->count();

        return $denunciasCount ?: 0;
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to use this function.');
        }
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
        Yii::$app->session->setFlash('error', 'You do not have permission to access this area.');
        $model->password = '';

        return $this->render('login',
            ['model' => $model,]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
