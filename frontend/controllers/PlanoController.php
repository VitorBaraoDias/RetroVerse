<?php

namespace frontend\controllers;

use common\models\Perfil;
use common\models\Plano;
use frontend\models\SearchArtigo;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * PlanoController implements the CRUD actions for Plano model.
 */
class PlanoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('You do not have permission to access this page.');
                    },
                ],
            ]
        );
    }

    /**
     * Lists all Plano models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Busca o plano ativo
        $planoAtivo = Plano::findOne(['ativo' => 1]);

        if (!$planoAtivo) {
            throw new NotFoundHttpException('Nenhum plano ativo encontrado.');
        }

        $userId = Yii::$app->user->id; //para ir buscar o perfil do utilizador logado
        $perfil = Perfil::findOne(['id' => $userId]);

        // Verifica se o utilizador tem um plano premium ativo
        $isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;

        // Define a variável pageName com base na verificação
        $pageName = $isPremium ? '_collection_premium' : '_aderir_plano';

        // Ir buscar os artigos premium
        $searchModel = new SearchArtigo();

        $queryParams = Yii::$app->request->queryParams;

        // Se o tipo não for passado, definimos como 'premium'
        if (!isset($queryParams['SearchArtigo']['tipo'])) {
            $searchModel->tipo = 'premium';
        }

        // Se o status de ativo não for passado, definimos como 1 (ativo)
        if (!isset($queryParams['SearchArtigo']['ativo'])) {
            $searchModel->ativo = 1;
        }

        $dataProvider = $searchModel->search($queryParams);

        // Renderiza a view
        return $this->render('index', [
            'plano' => $planoAtivo,
            'pageName' => $pageName,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the Plano model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Plano the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plano::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }







}
