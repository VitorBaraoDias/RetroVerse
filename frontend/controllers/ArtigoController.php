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
                        'actions' => ['index', 'create','update', 'view-marketplace', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['site/login']);
                },
            ],
        ];
    }


    public function actionIndex()
    {
            $searchModel = new SearchArtigo();

            $queryParams = Yii::$app->request->queryParams;
            $queryParams['SearchArtigo']['exclude_user_id'] = Yii::$app->user->id ?? null;

            if (!isset($queryParams['SearchArtigo']['tipo'])) {
                $searchModel->tipo = 'normal';
            }
            if (!isset($queryParams['SearchArtigo']['ativo'])) {
                $searchModel->ativo = 1;
            }


            $dataProvider = $searchModel->search($queryParams);

            $userId = Yii::$app->user->id;
            $perfil = Perfil::findOne(['id' => $userId]);

            $isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;


            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'isPremium' => $isPremium,
            ]);
    }

    public function actionView($id)
    {

            $model = $this->findModel($id);

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

            $isPremium = Artigospremium::find()->where(['id' => $id])->exists();

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


    public function actionCreate()
    {
        if (\Yii::$app->user->can('criarArtigoMarketplaceFrontend')) {
            $model = new Artigo();
            $uploadForm = new UploadMultipleForm();

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

                            Yii::$app->session->setFlash('error', 'The item has been saved, but the images cannot be saved.');

                            $transaction->rollBack();
                        }
                    } else {

                        Yii::$app->session->setFlash('error', 'Failed to save item.');
                        $transaction->rollBack();
                    }
                }
            } catch (\Exception $e) {
                Yii::error("Erro durante a criação do artigo: " . $e->getMessage(), __METHOD__);
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'An unexpected error has occurred. Please try again.');
            }

            return $this->render('create', [
                'model' => $model,
                'uploadForm' => $uploadForm,
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    public function actionDisable($id)
    {
        if (\Yii::$app->user->can('alterarArtigoMarketplaceFrontend')) {

            $model = $this->findModel($id);
            $model->ativo = 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('info', 'The item has been disabled');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to disable the item');
            }

            return $this->redirect(['perfil/index', 'id' => $model->idperfil]);
        }
        else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }

    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('alterarArtigoMarketplaceFrontend')) {

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

                            Yii::$app->session->setFlash('error', 'Images could not be loaded.');
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
        else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    protected function findModel($id)
    {
        if (($model = Artigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
