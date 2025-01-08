<?php

namespace frontend\controllers;

use common\models\Favorito;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete'],
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

    /**
     * Lists all Favorito models.
     *
     * @return string|\yii\console\Response|\yii\web\Response
     */
    public function actionIndex()
    {

        if (\Yii::$app->user->can('verTodosFavoritosFrontend')) {

            // Verifica se o utilizador está logado
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Log in or register to add articles to your favourites');
                return $this->redirect(['site/login']);
            }

            $userId = Yii::$app->user->id;
            $dataProvider = new ActiveDataProvider([
                'query' => Favorito::find()->where(['idperfil' => $userId]),
            ]);
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
        }else{
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    public function actionCreate($id)
    {
        if (\Yii::$app->user->can('criarFavoritoFrontend')) {

            $userId = Yii::$app->user->id;
            $favorito = Favorito::findOne(['idperfil' => $userId]) ?? new Favorito(['idperfil' => $userId]);

            // Verifica se o artigo já está nos favoritos
            if (Favorito::findOne(['idperfil' => $userId, 'idartigo' => $id])) {
                Yii::$app->session->setFlash('info', 'Item already bookmarked.');
            } else {
                // Adiciona o artigo aos favoritos
                $novoFavorito = new Favorito(['idperfil' => $userId, 'idartigo' => $id]);
                if ($novoFavorito->save()) {
                    Yii::$app->session->setFlash('success', 'Item successfully added to favourites!');
                } else {
                    Yii::$app->session->setFlash('error', 'Error adding item to favourites.');
                }
            }
            return $this->redirect(Yii::$app->request->referrer ?: ['artigo/index']);
        }
        else{
            return Yii::$app->response->redirect(['site/login']);
        }
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
        if (\Yii::$app->user->can('eliminarFavoritoFrontend')) {

            $userId = Yii::$app->user->id;

            $favorito = Favorito::findOne(['idperfil' => $userId, 'idartigo' => $id]);

            if ($favorito) {
                if ($favorito->delete()) {
                    Yii::$app->session->setFlash('success', 'Item successfully removed from favourites!');
                } else {
                    Yii::$app->session->setFlash('error', 'Error removing item from favourites.');
                }
            } else {
                Yii::$app->session->setFlash('info', 'Item not found in favourites.');
            }


            return $this->redirect(Yii::$app->request->referrer ?: ['artigo/index']);
        }
        else{
            return Yii::$app->response->redirect(['site/login']);

        }
    }


    public function isFavorito($userId, $artigoId)
    {
        return (bool) Favorito::find()
            ->where(['idperfil' => $userId, 'idartigo' => $artigoId])
            ->exists();
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
