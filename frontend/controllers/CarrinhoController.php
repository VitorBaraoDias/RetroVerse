<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\Carrinho;
use common\models\Iva;
use common\models\Linhascarrinho;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CarrinhoController implements the CRUD actions for Carrinho model.
 */
class CarrinhoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'create'],
                            'allow' => true,
                            'roles' => ['membro'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                            return Yii::$app->response->redirect(['site/login']);
                    },
                ],

                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        //'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex()
    {
        if (Yii::$app->user->can('verCarrinhoFrontend')) {
            $userId = Yii::$app->user->id;
            $carrinho = Carrinho::findOne(['iduser' => $userId]);
            $iva = Iva::findOne(['emvigor' => 1]);
            if ($carrinho === null) {
                Yii::$app->session->setFlash('error', 'There is no cart');
                return $this->redirect(['index']);
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $carrinho->getLinhascarrinhos()]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'iva' => $iva->percentagem
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    public function actionCreate($id)
    {
        if (Yii::$app->user->can('criarCarrinhoFrontend')) {
            $userId = Yii::$app->user->id;

            $carrinho = Carrinho::findOne(['iduser' => $userId]) ?? new Carrinho(['iduser' => $userId]);

            if ($carrinho->isNewRecord && !$carrinho->save()) {
                Yii::$app->session->setFlash('error', 'Error creating the cart.');
                return $this->redirect(['site/index']);
            }


            if (Linhascarrinho::findOne(['idcarrinho' => $carrinho->id, 'idartigo' => $id])) {
                Yii::$app->session->setFlash('info', 'Item is already in the cart.');
            } else {

                $artigo = Artigo::findOne($id);
                if (!$artigo || !$artigo->ativo) {
                    Yii::$app->session->setFlash('error', 'Item is not available.');
                } else {
                    $linhaCarrinho = new Linhascarrinho(['idcarrinho' => $carrinho->id, 'idartigo' => $id]);
                    if ($linhaCarrinho->save()) {
                        Yii::$app->session->setFlash('success', 'Item successfully added to the cart!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Error adding item to the cart.');
                    }
                }
            }

            return $this->redirect(['site/index']);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }



    protected function findModel($id)
    {
        if (($model = Carrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
