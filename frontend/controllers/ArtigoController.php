<?php

namespace frontend\controllers;

use backend\models\UploadMultipleForm;
use yii\web\UploadedFile;
use common\models\Comissao;
use Yii;
use common\models\Artigospremium;
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
        $queryParams['SearchArtigo']['exclude_user_id'] = Yii::$app->user->id;

        // Define os valores padrão caso não estejam nos parâmetros
        if (!isset($queryParams['SearchArtigo']['tipo'])) {
            $searchModel->tipo = 'normal';
        }
        if (!isset($queryParams['SearchArtigo']['ativo'])) {
            $searchModel->ativo = 1;
        }

        // Executa a pesquisa com os filtros
        $dataProvider = $searchModel->search($queryParams);




        // Renderiza a view com os dados
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
                ->andWhere(['not in', 'id', Artigospremium::find()->select('id')]) // Excluir artigos premium
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
                ->where(['ativo' => 1])
                ->andWhere(['not in', 'id', $id])
                ->andWhere(['id' => Artigospremium::find()->select('id')])
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


    public function actionViewMarketplace($id)
    {
        $model = $this->findModel($id);

        return $this->render('view_marketplace', [
            'model' => $model,
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

        if ($this->request->isPost) {
            $model->idperfil = Yii::$app->user->id;
            $model->tipoartigo = 'MARKETPLACE';
            $model->ativo = 1;
            $model->idcomissao = Comissao::getIdActiveComissao();

            if ($model->load($this->request->post()) && $model->save()) {
                // Configurar os diretórios de upload para artigos
                $uploadForm->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
                $uploadForm->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');
                $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');

                if ($uploadForm->upload($model->id)) {
                    return $this->redirect(['artigo/view-marketplace', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'O artigo foi salvo, mas as imagens não puderam ser carregadas.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }

    public function actionDisable($id){
        $model = $this->findModel($id);
        $model->ativo = 0;

        Yii::$app->session->setFlash('info', 'The article has been disabled');

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

        // Se for um POST request e o modelo for carregado e salvo corretamente
        if ($this->request->isPost && $model->load($this->request->post())) {

            // Salvar o modelo (Artigo)
            if ($model->save()) {
                // Configuração de diretórios de upload
                $uploadForm->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
                $uploadForm->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');

                // Obter as imagens enviadas
                $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');

                // Verificar se há imagens para fazer upload
                if (!empty($uploadForm->imageFiles)) {
                    // Salvar as imagens no servidor e associá-las ao artigo
                    if ($uploadForm->upload($model->id)) {
                        // Se o upload for bem-sucedido, redireciona para a página de visualização
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        // Caso haja falha no upload
                        Yii::$app->session->setFlash('error', 'As imagens não puderam ser carregadas.');
                    }
                } else {
                    // Caso não haja arquivos para enviar
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        // Caso o método GET ou POST falhe, renderize o formulário de atualização
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
