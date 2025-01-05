<?php

namespace backend\controllers;

use common\models\Linhavenda;
use common\models\LoginForm;
use common\models\User;
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
                        'roles' => ['admin'],
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

        return $this->render('index', [
            'marketplaceSales' => json_encode($marketplaceSales),
            'lojaSales' => json_encode($lojaSales),
            'userCount' => $userCount,
            'marcas' => json_encode($marcasData['marcas']),
            'quantidadeVendas' => json_encode($marcasData['quantidade_vendas']),
            'lojaSalesCount' => $lojaSalesCount,
            'marketplaceSalesCount' => $marketplaceSalesCount,
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

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $user_roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (!isset($user_roles['admin'])) {
                Yii::$app->user->logout();

                return $this->render('login');
            }
            return $this->goHome();

        }
        $this->layout = 'blank';
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
}
