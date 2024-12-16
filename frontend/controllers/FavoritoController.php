<?php

namespace frontend\controllers;

use common\models\Favorito;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Favorito models.
     *
     * @return string
     */
    public function actionIndex()
    {

        // Verifica se o utilizador está logado
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Inicie sessão ou registe-se para ver adicionar artigos aos favoritos');
            return $this->redirect(['site/login']); // Redireciona para a página de login
        }

        $userId = Yii::$app->user->id;

        $dataProvider = new ActiveDataProvider([
            'query' => Favorito::find()->where(['idperfil' => $userId]), // Filtra pelos favoritos do utilizador
        ]);

        // obter favoritos do user atual
        $idperfil = Yii::$app->user->id;
        $favoritos = [];
        if ($idperfil) {
            $favoritos = Favorito::find()
                ->select('idartigo')
                ->where(['idperfil' => $idperfil])
                ->column();
        }


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'favoritos' => $favoritos,
        ]);

    }

    /**
     * Displays a single Favorito model.
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
     * Creates a new Favorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate($id)
    {
        $userId = Yii::$app->user->id;  // Recupera o ID do usuário logado

        // Tenta encontrar ou criar um favorito para o usuário
        $favorito = Favorito::findOne(['idperfil' => $userId]) ?? new Favorito(['idperfil' => $userId]);

        // Verifica se o artigo já está nos favoritos
        if (Favorito::findOne(['idperfil' => $userId, 'idartigo' => $id])) {
            Yii::$app->session->setFlash('info', 'Artigo já está nos favoritos.');
        } else {
            // Adiciona o artigo aos favoritos
            $novoFavorito = new Favorito(['idperfil' => $userId, 'idartigo' => $id]);
            if ($novoFavorito->save()) {
                Yii::$app->session->setFlash('success', 'Artigo adicionado aos favoritos com sucesso!');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao adicionar o artigo aos favoritos.');
            }
        }

        return $this->redirect(['artigo/index']);
    }



    /**
     * Updates an existing Favorito model.
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
     * Deletes an existing Favorito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $userId = Yii::$app->user->id;

        $favorito = Favorito::findOne(['idperfil' => $userId, 'idartigo' => $id]);

        if ($favorito) {
            if ($favorito->delete()) {
                Yii::$app->session->setFlash('success', 'Artigo removido dos favoritos com sucesso!');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao remover o artigo dos favoritos.');
            }
        } else {
            Yii::$app->session->setFlash('info', 'Artigo não encontrado nos favoritos.');
        }


        return $this->redirect(['artigo/index']);
    }



    /**
     * Finds the Favorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Favorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
