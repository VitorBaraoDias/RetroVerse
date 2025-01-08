<?php

namespace frontend\controllers;

use backend\models\UploadMultipleForm;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\Comissao;
use Yii;
use common\models\Artigospremium;
use common\models\Perfil;
use common\models\Artigo;
use frontend\models\SearchArtigo;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


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
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view-marketplace', 'view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'view-marketplace', 'view', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('You do not have permission to access this page.');
                },
            ],
        ];
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
        $queryParams['SearchArtigo']['exclude_user_id'] = Yii::$app->user->id ?? null   ;

        // Define os valores padrão caso não estejam nos parâmetros
        if (!isset($queryParams['SearchArtigo']['tipo'])) {
            $searchModel->tipo = 'normal';
        }
        if (!isset($queryParams['SearchArtigo']['ativo'])) {
            $searchModel->ativo = 1;
        }

        // Executa a pesquisa com os filtros
        $dataProvider = $searchModel->search($queryParams);

        $userId = Yii::$app->user->id;
        $perfil = Perfil::findOne(['id' => $userId]);

        //verificar se o user tem premium
        $isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;


        // Renderiza a view com os dados
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isPremium' => $isPremium,
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
                ->where(['ativo' => 1])
                ->andWhere(['not in', 'id', $id])
                ->andWhere(['not in', 'id', Artigospremium::find()->select('id')])
                ->andWhere([
                    'or',
                    ['idcategoria' => $model->idcategoria],
                    ['idmarca' => $model->idmarca],
                    ['idtamanho' => $model->idtamanho]
                ])
                ->limit(4),
            'pagination' => false,
        ]);

        // DataProvider para artigos premium relacionados
        $relatedDataProviderPremium = new ActiveDataProvider([
            'query' => Artigo::find()
                ->where(['ativo' => 1])
                ->andWhere(['not in', 'id', $id])
                ->andWhere(['id' => Artigospremium::find()->select('id')])
                ->andWhere([
                    'or',
                    ['idcategoria' => $model->idcategoria],
                    ['idmarca' => $model->idmarca],
                    ['idtamanho' => $model->idtamanho]
                ])
                ->limit(4),
            'pagination' => false,
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


    public function actionViewMarketplace($id)
    {
        $model = $this->findModel($id);

        $relatedDataProvider = new ActiveDataProvider([
            'query' => Artigo::find()
                ->where(['ativo' => 1])
                ->andWhere(['tipoartigo' => "MARKETPLACE"])
                ->andWhere(['not in', 'id', $id])
                ->andWhere(['not in', 'id', Artigospremium::find()->select('id')])
                ->andWhere([
                    'or',
                    ['idcategoria' => $model->idcategoria],
                    ['idmarca' => $model->idmarca],
                    ['idtamanho' => $model->idtamanho]
                ])
                ->limit(4),
            'pagination' => false,
        ]);

        $userId = Yii::$app->user->id;
        $perfil = Perfil::findOne(['id' => $userId]);
        $isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;


        return $this->render('view_marketplace', [
            'model' => $model,
            'isPremium' => $isPremium,
            'relatedDataProvider' => $relatedDataProvider,
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
        $uploadForm = new UploadMultipleForm();

        // Inicia uma transação
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->request->isPost) {
                $model->idperfil = Yii::$app->user->id;
                $model->tipoartigo = 'MARKETPLACE';
                $model->ativo = 1;
                $model->idcomissao = Comissao::getIdActiveComissao();


                if ($model->load($this->request->post()) && $model->save()) {

                    $uploadForm->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
                    $uploadForm->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');
                    $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');


                    if ($uploadForm->upload($model->id)) {

                        $transaction->commit();
                        return $this->redirect(['perfil/index', 'id' => $model->idperfil]);
                    } else {

                        Yii::$app->session->setFlash('error', 'O artigo foi salvo, mas as imagens não puderam ser carregadas.');

                        $transaction->rollBack();
                    }
                } else {

                    Yii::$app->session->setFlash('error', 'Falha ao salvar o artigo.');
                    $transaction->rollBack();
                }
            }
        } catch (\Exception $e) {
            Yii::error("Erro durante a criação do artigo: " . $e->getMessage(), __METHOD__);
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.');
        }

        return $this->render('create', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }


    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->ativo = 0;

        if ($model->save()) {
            Yii::$app->session->setFlash('info', 'The item has been disabled');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to disable the item');
        }

        return $this->redirect(['perfil/index', 'id' => $model->idperfil]);
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
        $uploadForm = new UploadMultipleForm();


        if ($this->request->isPost && $model->load($this->request->post())) {


            if ($model->save()) {

                $uploadForm->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
                $uploadForm->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');


                $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');

                if (!empty($uploadForm->imageFiles)) {
                    if ($uploadForm->upload($model->id)) {
                        if ($model->tipoartigo === "LOJA") {
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            return $this->redirect(['view-marketplace', 'id' => $model->id]);
                        }
                    } else {

                        Yii::$app->session->setFlash('error', 'As imagens não puderam ser carregadas.');
                    }
                } else {
                    if ($model->tipoartigo === "LOJA") {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->redirect(['view-marketplace', 'id' => $model->id]);
                    }
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
            'uploadForm' => $uploadForm,
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
