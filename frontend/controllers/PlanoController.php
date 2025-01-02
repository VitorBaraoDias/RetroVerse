<?php

namespace frontend\controllers;

use common\models\Perfil;
use common\models\Plano;
use frontend\models\SearchArtigo;
use Yii;
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


        //Ir buscar os artigos premium
        $searchModel = new SearchArtigo();

        $queryParams = Yii::$app->request->queryParams;

        if (!isset($queryParams['SearchArtigo']['tipo'])) {
            $searchModel->tipo = 'premium';
        }
        if (!isset($queryParams['SearchArtigo']['ativo'])) {
            $searchModel->ativo = 1;
        }

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'plano' => $planoAtivo,
            'pageName' => $pageName,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }


    /**
     * Displays a single Plano model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Plano model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Plano();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Plano model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Plano model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Plano excluído com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao excluir o plano.');
        }

        return $this->redirect(['index']);
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
