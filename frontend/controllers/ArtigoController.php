<?php

namespace frontend\controllers;

use Yii;
use common\models\Artigospremium;
use common\models\Artigo;
use common\models\Favorito;
use frontend\models\SearchArtigo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;




/**
 * ArtigoController implements the CRUD actions for Artigo model.
 */
class ArtigoController extends Controller
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
     * Lists all Artigo models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new SearchArtigo(); // Instancia o SearchModel

        // Obtém os parâmetros da requisição
        $queryParams = Yii::$app->request->queryParams;

        // Define os valores padrão caso não estejam nos parâmetros
        if (!isset($queryParams['SearchArtigo']['tipo'])) {
            $searchModel->tipo = 'normal';
        }
        if (!isset($queryParams['SearchArtigo']['ativo'])) {
            $searchModel->ativo = 1;
        }

        // Executa a pesquisa com os filtros
        $dataProvider = $searchModel->search($queryParams);


        // obter favoritos do user atual
        $idperfil = Yii::$app->user->id;
        $favoritos = [];
        if ($idperfil) {
            $favoritos = Favorito::find()
                ->select('idartigo')
                ->where(['idperfil' => $idperfil])
                ->column();
        }

        // Renderiza a view com os dados
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'favoritos' => $favoritos,
        ]);
    }




    /**
     * Displays a single Artigo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        // DataProvider para artigos normais relacionados
        $relatedDataProviderNormal = new ActiveDataProvider([
            'query' => Artigo::find()
                ->where(['ativo' => 1]) // Apenas artigos ativos
                ->andWhere(['not in', 'id', $id]) // Excluir o próprio artigo
                ->andWhere(['not in', 'id', (new Query())->select('id')->from('artigospremium')]) // Excluir artigos premium
                ->andWhere([
                    'or',
                    ['idcategoria' => $model->idcategoria], // Mesma categoria
                    ['idmarca' => $model->idmarca],         // Mesma marca
                    ['idtamanho' => $model->idtamanho]      // Mesmo tamanho
                ])
                ->limit(4), // Limitar a 4 artigos
            'pagination' => false, // Sem paginação
        ]);

        // DataProvider para artigos premium relacionados
        $relatedDataProviderPremium = new ActiveDataProvider([
            'query' => Artigo::find()
                ->where(['ativo' => 1]) // Apenas artigos ativos
                ->andWhere(['not in', 'id', $id]) // Excluir o próprio artigo
                ->andWhere(['id' => (new Query())->select('id')->from('artigospremium')]) // Apenas artigos premium
                ->andWhere([
                    'or',
                    ['idcategoria' => $model->idcategoria], // Mesma categoria
                    ['idmarca' => $model->idmarca],         // Mesma marca
                    ['idtamanho' => $model->idtamanho]      // Mesmo tamanho
                ])
                ->limit(4), // Limitar a 4 artigos
            'pagination' => false, // Sem paginação
        ]);

        // verifica se o artigo é premium
        $isPremium = Artigospremium::find()->where(['id' => $id])->exists();

        // se for premium relaciona a rtigos premium senao normais
        $relatedDataProviderToUse = $isPremium ? $relatedDataProviderPremium : $relatedDataProviderNormal;

        return $this->render('view', [
            'model' => $model,
            'relatedDataProvider' => $relatedDataProviderToUse,
        ]);
    }

    /**
     * Creates a new Artigo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Artigo();

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
     * Updates an existing Artigo model.
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
     * Deletes an existing Artigo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Artigo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Artigo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
