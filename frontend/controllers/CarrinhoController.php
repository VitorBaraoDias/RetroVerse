<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\Linhascarrinho;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * Lists all Carrinho models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $carrinho = Carrinho::findOne(['iduser' => $id]);

        if ($carrinho === null) {
            Yii::$app->session->setFlash('error', 'Não existe o carrinho');
            return $this->redirect(['index']); // Página de fallback
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $carrinho->getLinhascarrinhos()]);
        // Renderize a view com o modelo encontrado
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Carrinho model.
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
     * Creates a new Carrinho model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {

        $userId = Yii::$app->user->id;

        // Tenta encontrar ou criar um carrinho
        $carrinho = Carrinho::findOne(['iduser' => $userId]) ?? new Carrinho(['iduser' => $userId]);

        if ($carrinho->isNewRecord && !$carrinho->save()) {
            Yii::$app->session->setFlash('error', 'Erro ao criar o carrinho.');
            return $this->redirect(['index']); // Página de fallback
        }
        if (Linhascarrinho::findOne(['idcarrinho' => $carrinho->id, 'idartigo' => $id])) {
            Yii::$app->session->setFlash('info', 'Artigo já está no carrinho.');
        } else {
            $linhaCarrinho = new Linhascarrinho(['idcarrinho' => $carrinho->id, 'idartigo' => $id]);
            $linhaCarrinho->save();
        }

        return $this->redirect(['site/index']); // Redireciona para o carrinho
    }

    /**
     * Updates an existing Carrinho model.
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
     * Deletes an existing Carrinho model.
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
     * Finds the Carrinho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Carrinho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
