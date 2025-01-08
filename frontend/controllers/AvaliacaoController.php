<?php

namespace frontend\controllers;

use common\models\Avaliacao;
use common\models\Linhavenda;
use common\models\Perfil;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AvaliacaoController implements the CRUD actions for Avaliacao model.
 */
class AvaliacaoController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect('site/login');
                }
            ],
        ];
    }

    /**
     * Lists all Avaliacao models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $perfil = Perfil::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query' => $perfil->getAvaliacoes(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'perfil' => $perfil,
        ]);
    }

    /**
     * Displays a single Avaliacao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreate($id)
    {
        if (\Yii::$app->user->can('criarAvaliacaoMarketplaceFrontend')) {

            $model = new Avaliacao();
            $linhaVenda = Linhavenda::findOne(['id' => $id]);


            if ($linhaVenda->avaliacao) {
                Yii::$app->session->setFlash('error', 'Já possui avaliação');
                return $this->redirect(['venda/view', 'id' => $id]);

            }
            if ($this->request->isPost) {

                $model->idremetente = Yii::$app->user->id;
                $model->iddestinatario = $linhaVenda->idvendedor;
                $model->idlinhavenda = $linhaVenda->id;
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
                'linhaVenda' => $linhaVenda,
            ]);
        }
        else{
            return Yii::$app->response->redirect('site/login');
        }
    }

    /**
     * Finds the Avaliacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Avaliacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avaliacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
